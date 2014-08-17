<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Board Game Check In</div>
                <div class="panel-body">
                <?php echo $this->Form->create(array(
                    'inputDefaults' => array(
                            'label' => false,
                            'class' => 'form-control'
                    ),
                    'role' => 'form'
                )); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('Boardgame.upc', array('placeholder' => 'Board game identifier code')); ?>
                </div>
                <div class="col-md-12 text-center">
                    <?php echo $this->Form->button('Check In', array('class' => 'btn btn-primary')); ?>
                </div>
                <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>