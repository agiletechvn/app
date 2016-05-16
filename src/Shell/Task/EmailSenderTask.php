<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Network\Exception\SocketException;
use Cake\ORM\TableRegistry;
use EmailQueue\Model\Table\EmailQueueTable;

/**
 * EmailSender shell task.
 */
class EmailSenderTask extends Shell
{

	public $params = [
		'limit' => 50,
		'template' => 'default',
		'layout' => 'default',
		'stagger' => false,
		'config' => 'default',
	];

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        if ($this->params['stagger']) {
            sleep(rand(0, $this->params['stagger']));
        }

        Configure::write('App.baseUrl', '/');
        $emailQueue = TableRegistry::get('EmailQueue', ['className' => EmailQueueTable::class]);
        $emails = $emailQueue->getBatch($this->params['limit']);

        $count = count($emails);
        foreach ($emails as $e) {
            $configName = $e->config === 'default' ? $this->params['config'] : $e->config;
            $template = $e->template === 'default' ? $this->params['template'] : $e->template;
            $layout = $e->layout === 'default' ? $this->params['layout'] : $e->layout;
            $headers = empty($e->headers) ? array() : (array) $e->headers;
            $theme = empty($e->theme) ? '' : (string) $e->theme;
            $helpers = ['Html', 'Text', 'Number', 'Url'];
            $from_email = null;
            $from_name  = null;

            try {
                $email = $this->_newEmail($configName);
                if (!empty($e->from_email) && !empty($e->from_name)) {
                    $email->from($e->from_email, $e->from_name);
                }

                $transport = $email->transport();
                if ($transport && $transport->config('additionalParameters')) {
                    $from = key($email->from());
                    $transport->config(['additionalParameters' => "-f $from"]);
                }
                $sent = $email
                    ->to($e->email_to)
                    ->subject($e->subject)
                    ->template($template, $layout)
                    ->emailFormat($e->format)
                    ->addHeaders($headers)
                    ->theme($theme)
                    ->helpers($helpers)
                    ->viewVars($e->template_vars)
                    ->messageId(false)
                    ->returnPath($email->from());
                if ($e->email_cc) {
                    $sent->addCc(explode(',', $e->email_cc));
                }
                if ($e->email_bcc) {
                    $sent->addBcc(explode(',', $e->email_bcc));
                }
                if (get_class($transport) === 'Cake\Mailer\Transport\SmtpTransport') {
                    $from_email = $from_name = $transport->config()['username'];
                } else {
                    foreach ($sent->from() as $k => $v) {
                        $from_email = $k;
                        $from_name  = $v;
                    }
                }
                if ($e->email_reply_to) {
                    $sent->replyTo(explode(',', $e->email_reply_to));
                } else {
                    $sent->replyTo($from_email, $from_name);
                }
                $sent = $sent->send();
            } catch (SocketException $exception) {
                $this->err($exception->getMessage());
                $sent = false;
            }
            if ($sent) {
                $emailQueue->success($e->id, $from_email, $from_email);
                $this->out('<success>Email ' . $e->id . ' was sent</success>');
            } else {
                $emailQueue->fail($e->id, $from_email, $from_email);
                $this->out('<error>Email ' . $e->id . ' was not sent</error>');
            }
        }
        if ($count > 0) {
            $emailQueue->releaseLocks(collection($emails)->extract('id')->toList());
        }
    }

    /**
     * Clears all locked emails in the queue, useful for recovering from crashes.
     **/
    public function clearLocks()
    {
        TableRegistry::get('EmailQueue', ['className' => EmailQueueTable::class])->clearLocks();
    }

    /**
     * Returns a new instance of CakeEmail.
     *
     * @return Email
     **/
    protected function _newEmail($config)
    {
        return new Email($config);
    }
}
