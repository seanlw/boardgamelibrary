<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default panel-primary">
                <div class="panel-heading">Add Board Game</div>
                <div class="panel-body">
                    <?php echo $this->Form->create('Bgg', array(
                        'inputDefaults' => array(
                            'label' => false,
                            'div' => false,
                            'class' => 'form-control'
                        ),
                        'role' => 'form',
                        'id' => 'addBG'
                    )); ?>
                    <?php echo $this->Form->input('id', array('placeholder' => 'Add by BGG id')); ?>
                    <div class="center">OR</div>
                    <?php echo $this->Form->input('title', array('placeholder' => 'Search by title')); ?>
                    <div class="center">
                        <?php echo $this->Form->button('Submit', array('class' => 'btn btn-default btn-primary')); ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div id="results" class="row" style="display:none;">
        <div class="panel panel-default">
            <div class="panel-heading">Results</div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Year Published</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>
    </div>
</div>