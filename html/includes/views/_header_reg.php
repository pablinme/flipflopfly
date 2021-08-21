<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title ?></title>
		<!-- <meta name="description" content="<?php echo $description ?>"> -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- styles -->
		<link href="/assets/css/bootstrap.css" rel="stylesheet">
		<link href="/assets/css/style.css" rel="stylesheet">
		<link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="/assets/font/css/font-awesome.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="../assets/js/html5shiv.js"></script>
			<![endif]-->

		<!-- Fav and touch icons -->
		<!--[if IE 7]>
			<link rel="stylesheet" href="/assets/font/css/font-awesome-ie7.min.css">
		<![endif]-->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="/assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="/assets/ico/favicon.png">

	</head>

	<body>
	<!-- NAVBAR
    ================================================== -->
    <div class="navbar-wrapper">
      <!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
      <div class="container">
        <div class="navbar navbar-inverse">
          <div class="navbar-inner">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="brand active" href="#">flipflopfly</a>
            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
            <div class="nav-collapse collapse">
              <ul class="nav">
              	<li><a href="/"><?=$username ?></a></li>
			  	<li><a href="/logout">Logout</a></li>
			  	<li <?php if($about) echo 'class="active"'; ?>><a href="/about/">About</a></li>  
              </ul>
            <p class="navbar-text pull-right">
              <?php echo $head.' - '.$time; ?>
            </p>
            <ul class="nav">
            </div><!--/.nav-collapse -->
          </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->
		<?php render('breadcrumb',array('breadcrumbs' => $breadcrumbs)); ?>
      </div> <!-- /.container -->
      
    </div><!-- /.navbar-wrapper -->
	
	<div class="container">
	  <div class="row-fluid">
        
        <?php /* render('sidebar',array('sidebar' => $sidebar)); */ ?>
						  
	<div class="span10">
		<div id="alert" name="alert" class="alert alert-info" style="display: none;"> </div>

		<?php if($alertShow) { ?>
			<div id="alert" name="alert" class="alert alert-info"> <?php echo $body; ?> </div>
		<?php } ?>
