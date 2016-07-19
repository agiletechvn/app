<?php
namespace App\View\Helper;

use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Tabs helper
 */
class TabsHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'button' => '<button{{attrs}}>{{text}}</button>',
            'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
            'checkboxFormGroup' => '{{label}}',
            'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
            'dateWidget' => '{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}',
            'error' => '<div class="error-message">{{content}}</div>',
            'errorList' => '<ul>{{content}}</ul>',
            'errorItem' => '<li>{{text}}</li>',
            'file' => '<div class="input-group"><input type="text" name="{{name}}"{{attrs}} class="form-control"><span class="input-group-btn"><a href="/filemanager/dialog.php?type=1&relative_url=1&field_id={{id}}" class="btn btn-default iframe-btn"><i class="fa fa-upload"></i></a></span></div>',
            'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
            'formStart' => '<form{{attrs}} role="form">',
            'formEnd' => '</form>',
            'formGroup' => '{{label}}{{input}}',
            'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
            'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
            'inputSubmit' => '<input class="btn btn-primary" type="{{type}}"{{attrs}}/>',
            'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div class="form-group has-error {{type}}{{required}}">{{content}}{{error}}</div>',
            'label' => '<label{{attrs}}>{{text}}</label>',
            'nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>',
            'legend' => '<legend>{{text}}</legend>',
            'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
            'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
            'select' => '<select class="form-control select2" name="{{name}}"{{attrs}}>{{content}}</select>',
            'selectMultiple' => '<select  class="form-control select2" name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>',
            'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
            'radioWrapper' => '{{label}}',
            'textarea' => '<textarea class="form-control" name="{{name}}"{{attrs}}>{{value}}</textarea>',
            'submitContainer' => '<div class="submit">{{content}}</div>'
        ]
    ];

    /**
     * helpers
     *
     * @var array
     */
    public $helpers = ['Html', 'Form'];
 
    /**
     * __construct
     *
     * @param /Cake/View/View $view View
     * @param array $config config
     * @return void
     */
    public function __construct(View $view, array $config = [])
    {
        parent::__construct($view, $config);
    }

    /**
     * generate bootstrap 3 tabs
     *
     * @return string
     */
    public function tabs()
    {
        $tabs = $this->_View->viewVars['tabs'];
        $html = '<div role="tabpanel">';
        $html .= '<ul class="nav nav-tabs" role="tablist">';
        foreach ($tabs as $tab) {
            $html .= $this->item($tab);
        }
        $html .= '</ul>';
        $html .= '<div class="tab-content card-body">';
        $html .= $this->content();
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * generate bootstrap 3 tabs link
     *
     * @param array $tab tab
     * @return string
     */
    protected function item($tab = [])
    {
        if ($tab['active']) {
            $html = '<li role="presentation" class="active">';
            $html .= $this->Html->link($tab['title'], '#!', ['aria-controls' => $tab['id'], 'role' => 'tab']);
        } else {
            $html = '<li role="presentation">';
            $html .= $this->Html->link($tab['title'], $tab['url'], ['aria-controls' => $tab['id'], 'role' => 'tab']);
        }
        $html .= '</li>';

        return $html;
    }

    /**
     * generate bootstrap 3 tabs panel
     *
     * @return string
     */
    protected function content()
    {
        $html = '<div role="tabpanel" class="tab-pane active">';
        $html .= $this->Form->create(null, ['templates' => $this->_defaultConfig['templates']]);
        $settings = $this->_View->viewVars['settings'];
        foreach ($settings as $id => $setting) {
            $html .= $this->Form->input($id . '.id', [
                'type' => 'hidden',
                'value' => $setting->id
            ]);
            $name = explode('.', $setting->name);
            $html .= $this->Form->input($id . '.value', [
                'type' => (($setting->type) ? $setting->type : 'text'),
                'label' => ucfirst(end($name)) . (($setting->description) ? ' - ' . $setting->description : ''),
                'options' => (($setting->options) ? $setting->options : ''),
                'default' => $setting->value,
            ]);
        }
        $html .= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']);
        $html .= $this->Form->end();

        return $html;
    }
}
