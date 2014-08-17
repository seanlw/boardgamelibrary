<?php
    $active_checkout = ($this->params['action'] == 'checkout');
    $active_checkin = ($this->params['action'] == 'checkin');
    $active_users = ($this->params['action'] == 'users');
    $active_browse = ($this->params['action'] == 'browse');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap.min.css');
	    echo $this->Html->css('bglib.min');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    <script>
        var base_url = '<?php echo $this->webroot; ?>';
    </script>
	<nav class="navbar navbar-static-top navbar-default navbar-top" role="navigation">
	    <div class="container-fluid">
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
	            <?php echo $this->Html->link('BoardGame Library', '/', array('class' => "navbar-brand")); ?>
	        </div>
	        <div class="collapse navbar-collapse" id="main-navigation">
                <ul class="nav navbar-nav">
                    <li class="<?php echo $active_checkout ? 'active' : ''; ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-open"></span>  Check Out', array('controller' => 'library', 'action' => 'checkout'), array('escape' => false)); ?></li>
                    <li class="<?php echo $active_checkin ? 'active' : ''; ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-save"></span> Check In', array('controller' => 'library', 'action' => 'checkin'), array('escape' => false)); ?></li>
                    <li class="<?php echo $active_users ? 'active' : ''; ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> Users', array('controller' => 'library', 'action' => 'users'), array('escape' => false)); ?></li>
                    <li class="<?php echo $active_browse ? 'active' : ''; ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-tower"></span> Library', array('controller' => 'library', 'action' => 'browse'), array('escape' => false)); ?></li>
                </ul>
            </div>
	    </div>
	</nav>
    <div class="container-fluid main-content">
        <?php echo $this->Session->flash(); ?>

        <?php echo $this->fetch('content'); ?>
	</div>
	<?php echo $this->Html->script('jquery.min.js') ?>
    <?php echo $this->Html->script('bootstrap.min.js'); ?>
    <?php echo $this->Html->script('bglib.min.js'); ?>
</body>
</html>
