<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Hash;

/**
 * Tabs component
 */
class TabsComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * tabs
     *
     * @var array
     */
    protected static $tabs = [];

    /**
     * Controller
     *
     * @var object
     */
    private $Controller = null;

    /**
     * initialize
     *
     * @param array $config config
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Controller = $this->_registry->getController();
        $this->Controller->viewBuilder()->helpers(['Tabs']);
    }

    /**
     * startup
     *
     * @param Cake/Event/Event $event Event
     * @return void
     */
    public function startup(Event $event)
    {
        $this->setController($event->subject());
    }

    /**
     * beforeRender set tabs to the view
     *
     * @return void
     */
    public function beforeRender()
    {
        $this->Controller->set('tabs', self::$tabs);
    }

    /**
     * beforeFilter initTabsItems
     *
     * @param Cake/Event/Event $event Event
     * @return void
     */
    public function beforeFiler(Event $event)
    {
        $this->setController($event->subject());
        if (method_exists($this->Controller, 'initTabsItems')) {
            $this->Controller->initTabsItems($event);
        }
    }

    /**
     * add item to the tabs
     *
     * @param string $title title
     * @param array $item item
     * @return void
     */
    public function add($title, array $item = [])
    {
        $list = self::$tabs;
        $_item = [
            'id' => $title,
            'url' => '#',
            'title' => $title,
            'active' => false,
            'weight' => 10,
        ];
        $item = array_merge($_item, $item);
        $url = Router::url($item['url']);
        $active = $this->config('active');
        if ($url === Router::url('/' . $this->Controller->request->url)) {
            $item['active'] = true;
        }
        $tabs = self::$tabs;
        $tabs[$item['id']] = $item;
        $tabs = Hash::sort($tabs, '{s}.weight', 'asc');
        self::$tabs = $tabs;
    }

    /**
     * clear tabs
     *
     * @return void
     */
    public function clear()
    {
        self::$tabs = [];
    }

    /**
     * set controller
     *
     * @param Cake\Controller\Controller $controller Controller
     * @return void
     */
    public function setController($controller)
    {
        $this->Controller = $controller;
    }
}
