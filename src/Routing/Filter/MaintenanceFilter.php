<?php

namespace App\Routing\Filter;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Routing\DispatcherFilter;

/**
 * MaintainFilter
 *
 */
class MaintenanceFilter extends DispatcherFilter
{

    /**
     * beforeDispatch function
     * @param Cake\Event\Event $event event
     * @return void
     */
    public function beforeDispatch(Event $event)
    {
        parent::beforeDispatch($event);
        $maintenance = Configure::read('Maintenance');

        // Allow ip in the list only.
        // Allow all if empty restrict ip
        if (!$maintenance['enable'] || empty($maintenance['allowedIp'])) {
            return;
        }
        $userIP = $this->_getUserIpAddr();
        $ips = explode(',', trim($maintenance['allowedIp']));
        foreach ($ips as $ip) {
            if ($this->_compareIp($userIP, trim($ip))) {
                return;
            }
        }

        $view = $this->_getView();
        $body = $view->render('Public/maintenance', 'error');
        $response = $event->data['response'];
        $response->statusCode(503);
        $response->body($body);
        $event->stopPropagation();
        return $response;
    }

    /**
     * _getView
     * @return Cake\View\View
     */
    protected function _getView()
    {
        $view = new \Cake\View\View();
        $view->loadHelper('WyriHaximus/MinifyHtml.MinifyHtml');
        $view->hasRendered = false;
        return $view;
    }

    /**
     * _getUserIpAddr
     * @return string
     */
    protected function _getUserIpAddr()
    {
        $ip = '0.0.0.0';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //if from shared
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //if from a proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * _compareIp function
     * @param int $userIp user Id
     * @param int $compareIp compare Ip
     * @return bool true|false
     */
    protected function _compareIp($userIp, $compareIp)
    {
        $compareIpLowerBoundary = str_replace("*", "0", $compareIp);
        $compareIpUpperBoundary = str_replace("*", "255", $compareIp);
        if (ip2long($compareIpLowerBoundary) <= ip2long($userIp) && ip2long($userIp) <= ip2long($compareIpUpperBoundary)) {
            return true;
        } else {
            return false;
        }
    }
}
