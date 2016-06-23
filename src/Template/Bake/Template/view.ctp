<%
use Cake\Utility\Inflector;

$associations += ['BelongsTo' => [], 'HasOne' => [], 'HasMany' => [], 'BelongsToMany' => []];
$immediateAssociations = $associations['BelongsTo'];
$associationFields = collection($fields)
    ->map(function($field) use ($immediateAssociations) {
        foreach ($immediateAssociations as $alias => $details) {
            if ($field === $details['foreignKey']) {
                return [$field => $details];
            }
        }
    })
    ->filter()
    ->reduce(function($fields, $value) {
        return $fields + $value;
    }, []);

$groupedFields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    })
    ->groupBy(function($field) use ($schema, $associationFields) {
        $type = $schema->columnType($field);
        if (isset($associationFields[$field])) {
            return 'string';
        }
        if (in_array($type, ['integer', 'float', 'decimal', 'biginteger'])) {
            return 'number';
        }
        if (in_array($type, ['date', 'time', 'datetime', 'timestamp'])) {
            return 'date';
        }
        return in_array($type, ['text', 'boolean']) ? $type : 'string';
    })
    ->toArray();

$groupedFields += ['number' => [], 'string' => [], 'boolean' => [], 'date' => [], 'text' => []];
$pk = "\$$singularVar->{$primaryKey[0]}";
%>
<?php
$this->assign('title', __('View'));
$this->Html->addCrumb(__('<%= $pluralHumanName %>'), ['controller' => '<%= $pluralHumanName %>', 'action' => 'index']);
$this->Html->addCrumb(__('View'));
?>
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title"><?= h($<%= $singularVar %>-><%= $displayField %>) ?></div>
                </div>
                <div class="pull-right card-action">
                    <div class="btn-group" role="group" aria-label="...">
                        <?=$this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', <%= $pk%>], ['escape' => false, 'class' => 'btn btn-warning'])?>&nbsp;
                        <?=$this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', <%= $pk%>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk%>), 'escape' => false, 'class' => 'btn btn-danger'])?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
<% if ($groupedFields['string']) : %>
<% foreach ($groupedFields['string'] as $field) : %>
<% if (isset($associationFields[$field])) :
            $details = $associationFields[$field];
%>
                    <tr>
                        <th><?= __('<%= Inflector::humanize($details['property']) %>') ?></th>
                        <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
                    </tr>
<% else : %>
                    <tr>
                        <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
                        <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
                    </tr>
<% endif; %>
<% endforeach; %>
<% endif; %>
<% if ($associations['HasOne']) : %>
    <%- foreach ($associations['HasOne'] as $alias => $details) : %>
                    <tr>
                        <th><?= __('<%= Inflector::humanize(Inflector::singularize(Inflector::underscore($alias))) %>') ?></th>
                        <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
                    </tr>
    <%- endforeach; %>
<% endif; %>
<% if ($groupedFields['number']) : %>
<% foreach ($groupedFields['number'] as $field) : %>
                    <tr>
                        <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
                        <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
                    </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['date']) : %>
<% foreach ($groupedFields['date'] as $field) : %>
                    <tr>
                        <th><%= "<%= __('" . Inflector::humanize($field) . "') %>" %></th>
                        <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
                    </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['boolean']) : %>
<% foreach ($groupedFields['boolean'] as $field) : %>
                    <tr>
                        <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
                        <td><?= $<%= $singularVar %>-><%= $field %> ? __('Yes') : __('No'); ?></td>
                    </tr>
<% endforeach; %>
<% endif; %>
                </table>
            </div>
        </div>
<% if ($groupedFields['text']) : %>
<% foreach ($groupedFields['text'] as $field) : %>
            <div class="card-body">
                <h4><?= __('<%= Inflector::humanize($field) %>') ?></h4>
                <?= $this->Text->autoParagraph(h($<%= $singularVar %>-><%= $field %>)); ?>
            </div>
<% endforeach; %>
<% endif; %>
    </div>
<%
$relations = $associations['HasMany'] + $associations['BelongsToMany'];
foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize(Inflector::underscore($details['controller']));
    %>
    <?php if (!empty($<%= $singularVar %>-><%= $details['property'] %>)): ?>
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title"><?= __('Related <%= $otherPluralHumanName %>') ?></div>
                    </div>
                </div>
                <div class="card-body no-padding">
                    <table class="table table-striped table-hover" cellspacing="0" width="100%">
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
<% foreach ($details['fields'] as $field): %>
                            <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
<% endforeach; %>
                        </tr>
                    <?php foreach ($<%= $singularVar %>-><%= $details['property'] %> as $<%= $otherSingularVar %>): ?>
                        <tr>
            <%- $otherPk = "\${$otherSingularVar}->{$details['primaryKey'][0]}"; %>
                            <td>
                                <?=$this->Html->link('<i class="fa fa-search"></i>', ['controller' => '<%= $details['controller'] %>', 'action' => 'view', <%= $otherPk %>], ['escape' => false])?>&nbsp;
                                <?=$this->Html->link('<i class="fa fa-edit"></i>', ['controller' => '<%= $details['controller'] %>', 'action' => 'edit', <%= $otherPk %>], ['escape' => false])?>&nbsp;
                                <?=$this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => '<%= $details['controller'] %>', 'action' => 'delete', <%= $otherPk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $otherPk %>), 'escape' => false])?>
                            </td>
            <%- foreach ($details['fields'] as $field): %>
                            <td><?= h($<%= $otherSingularVar %>-><%= $field %>) ?></td>
            <%- endforeach; %>
                        </tr>
                    <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
<% endforeach; %>
</div>
