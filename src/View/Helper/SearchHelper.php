<?php
namespace App\View\Helper;

use Cake\Collection\Collection;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Search helper
 */
class SearchHelper extends Helper
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
            'file' => '<div class="input-group">',
            'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
            'formStart' => '<form{{attrs}} role="form">',
            'formEnd' => '</div></form>',
            'formGroup' => '{{label}}{{input}}',
            'hiddenBlock' => '<div style="display: none;">{{content}}</div>',
            'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
            'inputSubmit' => '<input class="btn btn-primary" type="{{type}}"{{attrs}}/>',
            'inputContainer' => '{{content}}',
            'inputContainerError' => '{{content}}{{error}}',
            'label' => '<label{{attrs}}>{{text}}</label>',
            'nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>',
            'legend' => '<legend>{{text}}</legend>',
            'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
            'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
            'select' => '<select class="form-control" name="{{name}}"{{attrs}}>{{content}}</select>',
            'selectMultiple' => '<select  class="form-control" name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>',
            'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
            'radioWrapper' => '{{label}}',
            'textarea' => '<textarea class="form-control" name="{{name}}"{{attrs}}>{{value}}</textarea>',
            'submitContainer' => '{{content}}'
        ]
    ];

    public $helpers = ['Form'];

    /**
     * generate menu function
     * @param array $fields array input
     * @return string
     */
    public function generate(array $fields = [])
    {
        $result = '<tr class="search">';
        $result .= $this->Form->create(null, ['templates' => $this->_defaultConfig['templates']]);

        foreach ($fields as &$field) {
            $result .= '<td>';
            if (count($field) > 1) {
                $options = array_merge($field[1], ['label' => false]);
                $result .= $this->Form->input("$field[0]", $options);
            } else {
                $result .= $this->Form->input("$field[0]", ['label' => false]);
            }
            $result .= '</td>';
        }
        $result .= '</tr>';
        $result .= $this->Form->end();

        return $result;
    }
}
