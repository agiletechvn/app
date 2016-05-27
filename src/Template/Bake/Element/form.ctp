<%
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
%>
<?php
$this->assign('title', __('<%= $pluralHumanName %>') . '/' . __('<%= Inflector::humanize($action) %>'));
$this->Html->addCrumb(__('<%= $pluralHumanName %>'), ['controller' => '<%= $pluralHumanName %>', 'action' => 'index']);
$this->Html->addCrumb(__('<%= Inflector::humanize($action) %>'));
?>
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title"><?= __('<%= Inflector::humanize($action) %> <%= $pluralHumanName %>') ?></div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->Form->create($<%= $singularVar %>, ['templates' => 'template_form_1_column']) ?>
                    <?php
<%
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
%>
                    echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true]);
<%
                } else {
%>
                    echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>]);
<%
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (in_array($fieldData['type'], ['date', 'datetime', 'time']) && (!empty($fieldData['null']))) {
%>
                    echo $this->Form->input('<%= $field %>', ['empty' => true]);
<%
                } else {
%>
                    echo $this->Form->input('<%= $field %>');
<%
                }
            }
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
                    echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
<%
            }
        }
%>
                    ?>
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
