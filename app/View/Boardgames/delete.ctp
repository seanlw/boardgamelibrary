<div class="container-fluid">
    <h1>Are you sure?</h1>
    <p>Are you sure you want to delete the board game <?php echo $game['Boardgame']['title'];?>? This will also delete all check out information with this game.</p>
    <?php echo $this->Form->create('Boardgame', array('role' => 'form')); ?>
    <?php echo $this->Form->hidden('confirm', array('value' => true)); ?>
    <?php echo $this->Form->hidden('id'); ?>
    <?php echo $this->Form->hidden('title'); ?>
    <?php echo $this->Form->button('Confirm', array('class' => 'btn btn-primary')); ?>
    <?php echo $this->Html->link('Cancel', array('controller' => 'boardgames', 'action' => 'edit', $game['Boardgame']['id']), array('class' => 'btn btn-default')); ?>
    <?php echo $this->Form->end(); ?>
</div>