<div class="queue-default-index">
    <h4>Ochered nomeri: <?=$id?></h4>
    <h5><?=Yii::$app->queue->isWaiting($id);?></h5>
    <h6><?=Yii::$app->queue->isReserved($id);?></h6>

    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
