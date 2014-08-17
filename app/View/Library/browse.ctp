<ul class="nav nav-pills navbar-right">
    <li class="active"><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span> Add', array('controller' => 'boardgames', 'action' => 'add'), array('escape' => false)); ?></li>
</ul>
<div class="btn-toolbar" role="toolbar">
    <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
            <span class="glyphicon glyphicon-filter"></span> Filter: <?php echo ucwords($filter); ?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><?php echo $this->Html->link('All', array('controller' => 'library', 'action' => 'browse')); ?></li>
            <li class="divider"></li>
            <li><?php echo $this->Html->link('Checked Out', array('controller' => 'library', 'action' => 'browse', 'filter' => 'checkout')); ?></li>
            <li><?php echo $this->Html->link('Checked In', array('controller' => 'library', 'action' => 'browse', 'filter' => 'checkin')); ?></li>
        </ul>
    </div>
</div>
<table class="table table-striped table-hover table-browse table-condensed browse-table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th># of Players</th>
            <th>Best with</th>
            <th>Playing Time</th>
            <th>Status</th>
            <th># Check-outs</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($games as $g): ?>
    <tr>
        <td><?php echo $this->Html->link(
            $this->Html->image('boardgames/thumbnails/' . $g['Boardgame']['thumbnail']), 
            array(
                'controller' => 'boardgames',
                'action' => 'edit',
                $g['Boardgame']['id']
            ),
            array(
                'escape' => false
            )
        ); ?></td>
        <td><?php echo $this->Html->link($g['Boardgame']['title'], array('controller' => 'boardgames', 'action' => 'edit', $g['Boardgame']['id']), array('escape' => false)); ?></td>
        <td><?php echo $g['Boardgame']['num_players']; ?></td>
        <td><?php echo $g['Boardgame']['best_num_players']; ?> players</td>
        <td><?php echo $g['Boardgame']['playing_time']; ?> mins</td>
        <td><span class="label label-md <?php echo ($g['Boardgame']['status'] == 'in') ? 'label-success' : 'label-danger'; ?>"><?php echo strtoupper($g['Boardgame']['status']); ?></span></td>
        <td><?php echo count($g['Checkout']); ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>