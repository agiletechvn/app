<?php
namespace App\View\Helper;

use Cake\Utility\Text;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Menu helper
 */
class MenuHelper extends Helper
{

    /**
     *
     */
    public $helpers = ['Html'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * link function
     * @param string $title title for menu link
     * @param string|array $url same like Html->url
     * @param array $options configure for link
     * @return string inside <li> tag
     */
    public function link($title, $url, array $options = [])
    {
        $result = '<li';
        if (is_array($url) && $this->Html->request->controller === $url['controller']) {
            $result .= " class='active'";
        }
        $result .= '>';
        $result .= $this->Html->link($title, $url, $options);
        $result .= '</li>';

        return $result;
    }

    /**
     * group link function
     * @param string $title title for menu link
     * @param array $urls force array
     * @param array $options configure for link
     * @return string inside <li> tag
     */
    public function groupLink($title, array $urls = [], array $options = [])
    {
        $result = '<li class="panel panel-default dropdown">';
        $controller = $this->Html->request->controller;
        foreach ($urls as $k => $v) {
            if (isset($v[1]) && $controller === $v[1]['controller']) {
                $result = '<li class="active panel panel-default dropdown">';
                break;
            }
        }
        $collapseId = Text::uuid();
        $result .= $this->Html->link($title, '#' . $collapseId, ['data-toggle' => 'collapse', 'escape' => false]);
        $result .= '<div id="' . $collapseId . '" class="panel-collapse collapse">';
        $result .= '<div class="panel-body">';
        $result .= '<ul class="nav navbar-nav">';
        foreach ($urls as $k => $v) {
            if (empty($v[0]) || empty($v[1])) {
                continue;
            }
            $result .= '<li>' . $this->Html->link($v[0], $v[1]) . '</li>';
        }
        $result .= '</ul>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</li>';

        return $result;
    }
}
