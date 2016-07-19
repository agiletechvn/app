<?php
namespace App\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\Database\Schema\Table as Schema;
use Cake\Database\Type;
use Cake\I18n\FrozenTime;
use Cake\ORM\Table;

/**
 * EmailQueue Model
 *
 */
class EmailQueueTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('email_queue');
        $this->displayField('subject');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'existing',
                ],
            ],
        ]);
    }

    /**
     * Stores a new email message in the queue.
     *
     * @param mixed|array $to           email or array of emails as recipients
     * @param array $data    associative array of variables to be passed to the email template
     * @param array $options list of options for email sending.
     * @param null|mixed|array $cc           null or email or array of emails as cc
     * @param null|mixed|array $bcc          null or email or array of emails as bcc
     * @param null|mixed|array $replyTo     null or email or array of emails as replyTo
     *
     * $options Possible keys:
     * - subject : Email's subject
     * - send_at : date time sting representing the time this email should be sent at (in UTC)
     * - template :  the name of the element to use as template for the email message
     * - layout : the name of the layout to be used to wrap email message
     * - format: Type of template to use (html, text or both)
     * - config : the name of the email config to be used for sending
     *
     * @return bool
     */
    public function enqueue($to, array $data, array $options = [], $cc = null, $bcc = null, $replyTo = null)
    {
        $defaults = [
            'subject' => '',
            'send_at' => new FrozenTime('now'),
            'template' => 'default',
            'layout' => 'default',
            'theme' => '',
            'format' => 'both',
            'headers' => [],
            'template_vars' => $data,
            'config' => 'default',
        ];

        $email = $options + $defaults;
        if (!is_array($to)) {
            $to = [$to];
        }
        $email['email_to'] = implode(',', $to);
        if ($cc) {
            if (!is_array($cc)) {
                $cc = [$cc];
            }
            $email['email_cc'] = implode(',', $cc);
        }
        if ($bcc) {
            if (!is_array($bcc)) {
                $bcc = [$bcc];
            }
            $email['email_bcc'] = implode(',', $bcc);
        }
        if ($replyTo) {
            if (!is_array($replyTo)) {
                $replyTo = [$replyTo];
            }
            $email['email_reply_to'] = implode(',', $replyTo);
        }

        return $this->save($this->newEntity($email));
    }

    /**
     * Returns a list of queued emails that needs to be sent.
     * @param int $size number of unset emails to return
     * @return array list of unsent emails
     */
    public function getBatch($size = 10)
    {
        return $this->connection()->transactional(function () use ($size) {
            $emails = $this->find()
                ->where([
                    $this->aliasField('sent') => false,
                    $this->aliasField('send_tries') . ' <=' => 3,
                    $this->aliasField('send_at') . ' <=' => new FrozenTime('now'),
                    $this->aliasField('locked') => false,
                ])
                ->limit($size)
                ->order([$this->aliasField('created') => 'ASC']);

            $emails
                ->extract('id')
                ->through(function ($ids) {
                    if (!$ids->isEmpty()) {
                        $this->updateAll(['locked' => true], ['id IN' => $ids->toList()]);
                    }

                    return $ids;
                });

            return $emails->toList();
        });
    }

    /**
     * Releases locks for all emails in $ids.
     *
     * @param array|Traversable $ids The email ids to unlock
     * @return void
     */
    public function releaseLocks($ids)
    {
        $this->updateAll(['locked' => false, 'modified' => new FrozenTime('now')], ['id IN' => $ids]);
    }

    /**
     * Releases locks for all emails in queue, useful for recovering from crashes.
     * @return bool
     */
    public function clearLocks()
    {
        return $this->updateAll(['locked' => false, 'modified' => new FrozenTime('now')], '1=1');
    }

    /**
     * Marks an email from the queue as sent.
     * @param string $id queued email id
     * @param string $fromEmail from email
     * @param string $fromName from name
     * @return bool
     */
    public function success($id, $fromEmail, $fromName)
    {
        return $this->updateAll(['sent' => true, 'from_email' => $fromEmail, 'from_name' => $fromName, 'modified' => new FrozenTime('now')], ['id' => $id]);
    }

    /**
     * Marks an email from the queue as failed, and increments the number of tries.
     *
     * @param string $id queued email id
     * @param string $fromEmail queued email fromEmail
     * @param string $fromName queued email fromName
     *
     * @return bool
     */
    public function fail($id, $fromEmail, $fromName)
    {
        return $this->updateAll(['send_tries' => new QueryExpression('send_tries + 1'), 'from_email' => $fromEmail, 'from_name' => $fromName, 'modified' => new FrozenTime('now')], ['id' => $id]);
    }

    /**
     * Sets the column type for template_vars and headers to json.
     *
     * @param Schema $schema The table description
     *
     * @return Schema
     */
    protected function _initializeSchema(Schema $schema)
    {
        $schema->columnType('template_vars', 'serialize');
        $schema->columnType('headers', 'serialize');

        return $schema;
    }
}
