<table class="table table-striped table-hover table-browse table-condensed browse-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Identifier</th>
            <th># of Checkouts</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $u): ?>
    <tr>
        <td><?php echo $u['User']['name']; ?></td>
        <td><?php echo $u['User']['identifier']; ?></td>
        <td><?php echo count($u['Checkout']); ?></td>
        <td>
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group">
                    <?php echo $this->Form->create(null, array('role' => 'form', 'url' => array('controller' => 'library', 'action' => 'checkout'))); ?>
                    <?php echo $this->Form->hidden('nextstep', array('value' => 2)); ?>
                    <?php echo $this->Form->hidden('User.identifier', array('value' => $u['User']['identifier'])); ?>
                    <?php echo $this->Form->button('<span class="glyphicon glyphicon-open"></span> Game', array('class' => 'btn btn-primary btn-sm')); ?>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>