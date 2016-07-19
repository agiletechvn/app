<?php
namespace App\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\Widget\WidgetInterface;

/**
 * Input widget class for generating a file upload control.
 *
 * This class is intended as an internal implementation detail
 * of Cake\View\Helper\FormHelper and is not intended for direct use.
 */
class FileWidget implements WidgetInterface
{

    /**
     * Constructor
     *
     * @param \Cake\View\StringTemplate $templates Templates list.
     */
    public function __construct($templates)
    {
        $this->_templates = $templates;
    }

    /**
     * Render a file upload form widget.
     *
     * Data supports the following keys:
     *
     * - `name` - Set the input name.
     * - `escape` - Set to false to disable HTML escaping.
     *
     * All other keys will be converted into HTML attributes.
     * Unlike other input objects the `val` property will be specifically
     * ignored.
     *
     * @param array $data The data to build a file input with.
     * @param \Cake\View\Form\ContextInterface $context The current form context.
     * @return string HTML elements.
     */
    public function render(array $data, ContextInterface $context)
    {
        $data += [
            'name' => '',
            'id' => '',
            'val' => null,
            'type' => 'text',
            'escape' => true,
            'templateVars' => [],
        ];
        $data['value'] = $data['val'];
        unset($data['val']);

        return $this->_templates->format('file', [
            'name' => $data['name'],
            'id' => str_to_slug($data['name']),
            'type' => $data['type'],
            'templateVars' => $data['templateVars'],
            'attrs' => $this->_templates->formatAttributes($data, ['name', 'type'])
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function secureFields(array $data)
    {
        if (!isset($data['name']) || $data['name'] === '') {
            return [];
        }

        return [$data['name']];
    }
}
