<?php
$this->assign('title', __('Setting'));
$this->Html->addCrumb(__('Setting'));

$this->Html->css('//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css', ['block' => true]);
$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js', ['block' => true]);
$this->Html->scriptBlock('
  $(".iframe-btn").fancybox({ 
      "width": 900,
      "height": 600,
      "type": "iframe",
      "autoScale": true,
      "minHeight": 280
  });
', ['block' => true]);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="no-padding">
                <?= $this->Tabs->tabs()?>
            </div>
        </div>
    </div>
</div>
