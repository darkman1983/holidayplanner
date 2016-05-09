<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php echo $viewModel->get('pageTitle'); ?></title>
<!-- Bootstrap -->
<link href="<?php echo $viewModel->get('AssetPath'); ?>css/bootstrap.min.css" rel="stylesheet">
<!-- FontAwesome -->
<link href="<?php echo $viewModel->get('AssetPath'); ?>css/font-awesome.min.css" rel="stylesheet">
<!-- DateTimePicker -->
<link href="<?php echo $viewModel->get('AssetPath'); ?>css/daterangepicker.min.css" rel="stylesheet">
<!-- InputLimiter -->
<link href="<?php echo $viewModel->get('AssetPath'); ?>css/inputlimiter.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?php echo $viewModel->get('AssetPath'); ?>css/default.css" rel="stylesheet">
<!-- PNotify -->
<link href="<?php echo $viewModel->get('AssetPath'); ?>css/pnotify.custom.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/jquery.min.js"></script>
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/jquery.wait.min.js"></script>
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/jquery.urlparam.min.js"></script>
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/jquery.periodic.min.js"></script>
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/jquery.inputlimiter.min.js"></script>
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/soundmanager2-nodebug-jsmin.js"></script>
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/pnotify.custom.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/bootstrap.min.js"></script>
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/moment.min.js"></script>
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/daterangepicker.min.js"></script>
<script src="<?php echo $viewModel->get('AssetPath'); ?>js/validator.min.js"></script>
<script>
PNotify.prototype.options.styling = "bootstrap3";
PNotify.prototype.options.styling = "fontawesome";

soundManager.setup({
    onready: function() {
    	soundManager.createSound({
        	  id: 'notify',
        	  url: '<?php echo $viewModel->get('AssetPath'); ?>sounds/notify1.mp3',
        	  autoLoad: true,
        	  autoPlay: false,
        	  debugMode: true,
        	  volume: 50
        	});
    }
});
</script>
</head>
<body>