<div class="container-fluid">
    <?php echo $this->Form->create(null, array(
        'inputDefaults' => array(
                'class' => 'form-control'
        ),
        'role' => 'form'
    )); ?>
    <?php echo $this->Form->hidden('nextstep', array('value' => 3)); ?>
    <?php if (!isset($user) || !$user): ?>
     <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">Create New User</div>
                <div class="panel-body">
                    <div class="form-group">
                        <?php echo $this->Form->input('User.name'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('User.identifier', array('value' => '', 'label' => 'Identifier Code')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Board Game Checkout</div>
                <div class="panel-body">
                    <div class="form-group">
                        <?php echo $this->Form->input('Boardgame.upc', array('label' => false, 'placeholder' => 'Boardgame Identifier Code')); ?>
                    </div>
                    <div class="col-md-12 text-center">
                        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($user) && $user): ?>
    <?php echo $this->Form->hidden('User.id', array('value' => $user['User']['id'])); ?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-success">
                <div class="panel-heading">User <?php echo $user['User']['name']; ?></div>
                <div class="panel-body">
                    <?php if ($user['Checkout']): ?>
                        <p class="text-center"><b>Board Games Checked Out</b></p>
                        <table class="table table-bordered user-checkouts">
                            <?php foreach ($user['Checkout'] as $c): ?>
                            <tr>
                                <td><?php echo $c['Boardgame']['title']; ?></td>
                                <td><?php echo date('m-d-Y H:i:s', strtotime($c['checkout'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        <p class="text-center"><b>Nothing Checked Out</b></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php echo $this->Form->end(); ?>
</div>