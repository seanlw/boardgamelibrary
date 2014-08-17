<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <?php echo $this->Html->image('boardgames/images/' . $this->request->data['Boardgame']['image'], array('class' => 'img-responsive bgart')); ?>
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">Board Game Detail</div>
                <div class="panel-body">
                    <table class="table table-bordered information">
                        <tbody>
                            <tr>
                                <td><b>Title</b></td>
                                <td><?php echo $this->request->data['Boardgame']['title']; ?></td>
                            </tr>
                            <tr>
                                <td><b>Number of Players</b></td>
                                <td><?php echo $this->request->data['Boardgame']['num_players']; ?></td>
                            </tr>
                            <tr>
                                <td><b>Best with</b></td>
                                <td><?php echo $this->request->data['Boardgame']['best_num_players']; ?> players</td>
                            </tr>
                            <tr>
                                <td><b>Playing Time</b></td>
                                <td><?php echo $this->request->data['Boardgame']['playing_time']; ?> mins</td>
                            </tr>
                            <tr>
                                <td><b>Checked Out</b></td>
                                <td><?php echo count($this->request->data['Checkout']); ?> times</td>
                            </tr>
                        </tbody>
                    </table>
                    <?php echo $this->Form->create(null, array(
                        'inputDefaults' => array(
                            'label' => array('class' => 'control-label'),
                            'class' => 'form-control'
                        )
                    )); ?>
                    <?php echo $this->Form->hidden('id'); ?>
                    <div class="form-group">
                        <?php echo $this->Form->input('upc', array('label' => 'Boardgame Identification Code')); ?>
                    </div>
                    <div class="col-md-12" style="text-align: center;">
                        <?php echo $this->Form->button('Update', array('class' => 'btn btn-primary')); ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
            <?php if ($user): ?>
            <div class="alert alert-warning" role="alert">
                <h4>Checked out by</h4>
                <?php foreach($user as $u): ?>
                <div class="current-checkout-list"><?php echo $u['User']['name']; ?> at <?php echo $u['Checkout']['checkout']; ?></div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="panel panel-primary">
                <div class="panel-heading">Check Out History</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</td>
                            <th>Check Out Time</th>
                            <th>Check In Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->request->data['Checkout'] as $c): ?>
                        <tr>
                            <td><?php echo $c['User']['name']; ?></td>
                            <td><?php echo $c['checkout']; ?></td>
                            <td><?php echo $c['checkin']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>