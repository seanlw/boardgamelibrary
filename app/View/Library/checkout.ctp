<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Board Game Checkout</div>
                <div class="panel-body">
                <?php echo $this->Form->create(array(
                    'inputDefaults' => array(
                            'label' => false,
                            'class' => 'form-control'
                    ),
                    'role' => 'form'
                )); ?>
                <?php echo $this->Form->hidden('nextstep', array('value' => 2)); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('User.identifier', array('placeholder' => 'User identifier code')); ?>
                </div>
                <div class="col-md-12 text-center">
                    <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
                </div>
                <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>