<%
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return !in_array($schema->columnType($field), ['binary', 'text']);
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}

if (!empty($indexColumns)) {
    $fields = $fields->take($indexColumns);
}

%>

<?php
$this->assign('title', __('<%= $pluralHumanName %>'));
$this->Html->addCrumb(__('<%= $pluralHumanName %>'));
$this->loadHelper('Search');

$this->Html->css('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker3.min.css', ['block' => true]);
$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js', ['block' => true]);
$this->Html->scriptBlock('
    $("#created").datepicker({autoclose: true,todayHighlight: true});
    $("#modified").datepicker({autoclose: true,todayHighlight: true});
', ['block' => true]);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">
                        <?=__('List <%= $singularHumanName %>')?>
                    </div>
                </div>
                <div class="pull-right card-action">
                    <div class="btn-group" role="group" aria-label="...">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false])?>&nbsp;
                        <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false])?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
<% foreach ($fields as $field): %>
                            <th><?= $this->Paginator->sort('<%= $field %>') ?></th>
<% endforeach; %>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $this->Search->generate([
                            [
                                __('Search'), ['type' => 'submit', 'class' => 'btn btn-primary', 'style' => 'margin: 0px']
                            ],
            <%

            $colspan = 1;
            foreach ($fields as $field):
                $colspan++;
                            echo "['$field'],";
            endforeach;
            %>
                        ])?>
                        <?php
                        if($<%= $pluralVar%>->count() == 0):
                        ?>
                            <tr>
                                <td colspan="<%= $colspan%>" class="text-center"><?= __('No data found')?></td>
                            </tr>
                        <?php endif;?>

                        <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
<%
                        $pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
                        <tr>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-search"></i>', ['action' => 'view', <%= $pk %>], ['escape' => false])?>&nbsp;
                                <?= $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', <%= $pk %>], ['escape' => false])?>&nbsp;
                                <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', <%= $pk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>), 'escape' => false])?>
                            </td>
<%
                    foreach ($fields as $field) {
                        $isKey = false;
                        if (!empty($associations['BelongsTo'])) {
                            foreach ($associations['BelongsTo'] as $alias => $details) {
                                if ($field === $details['foreignKey']) {
                                    $isKey = true;
%>
                            <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
<%
                                    break;
                                }
                            }
                        }
                        if ($isKey !== true) {
                            if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
%>
                            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                            } else {
%>
                            <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                            }
                        }
                    }
%>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <ul class="pagination pagination-sm pull-right">
                    <?= $this->Paginator->prev() ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next() ?>
                </ul>
                <p><?= $this->Paginator->counter() ?></p>
            </div>
        </div>
    </div>
</div>
