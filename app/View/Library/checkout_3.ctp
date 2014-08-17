<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-md-offset-2">
             <div class="panel panel-primary">
                <div class="panel-heading"><?php echo $boardgame['Boardgame']['title']; ?></div>
                <div class="panel-body">
                    <?php echo $this->Html->image('boardgames/images/' . $boardgame['Boardgame']['image'], array('class' => 'img-responsive')); ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-primary">
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
    <div class="row">
        <?php echo $this->Form->create(null, array('role' => 'form')); ?>
        <?php echo $this->Form->hidden('nextstep', array('value' => 4)); ?>
        <?php echo $this->Form->hidden('User.id', array('value' => $user['User']['id'])); ?>
        <?php echo $this->Form->hidden('Boardgame.id', array('value' => $boardgame['Boardgame']['id'])); ?>
        <div class="col-md-2 col-md-offset-4 text-center">
            <?php echo $this->Form->button('Check Out', array('class' => 'btn btn-primary')); ?>
        </div>
        <div class="col-md-2 text-center">
            <?php echo $this->Html->link('Cancel', array('controller' => 'library', 'action' => 'checkout'), array('class' => 'btn btn-default')); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>