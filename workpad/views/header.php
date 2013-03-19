<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Emplopad</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo css_dir('bootstrap.css');?>" rel="stylesheet">
	  <link href="<?php echo css_dir('style.css');?>" rel="stylesheet">
    <link href="<?php echo css_dir('bootstrap-responsive.css');?>" rel="stylesheet">

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  	<script>window.jQuery || document.write('<script src="<?php echo js_dir('libs/jquery-1.7.1.min.js')?>"><\/script>')</script>    
    
    <link type="text/css" href="<?php echo css_dir('custom-theme/jquery-ui-1.8.16.custom.css');?>" rel="stylesheet" />

    <!-- http://addyosmani.github.com/jquery-ui-bootstrap/ -->
    <link href="<?php echo css_dir('ui.daterangepicker.css');?>" media="screen" rel="Stylesheet" type="text/css" />
	
    <?php load_css();?>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="7x72" href="../apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../apple-touch-icon-57-precomposed.png">

    <script type="text/javascript">
      <?php if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
          || $_SERVER['SERVER_PORT'] == 443) { ?>
        var BASE_URL = '<?php echo $this->config->item("secure_base_url");?>';
      <?php } else { ?>
        var BASE_URL = '<?php echo site_url();?>';
      <?php } ?>

      var SECURE_BASE_URL = '<?php echo $this->config->item("secure_base_url");?>';
    </script> 
  </head>

  <body>

