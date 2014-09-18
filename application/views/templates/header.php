<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?=base_url();?>/assets/images/favicon.ico">

    <title><?=TITLE;?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url();?>assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/global.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>

  <body>
      
      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">-->
            <!--<span class="sr-only">Toggle navigation</span>-->
            <!--<span class="icon-bar"></span>-->
            <!--<span class="icon-bar"></span>-->
            <!--<span class="icon-bar"></span>-->
          <!--</button>-->
          <a class="navbar-brand"><?=TITLE?><small style="color: #1d9ce5;">&nbsp;&nbsp;&nbsp;<?=BIRD_BUILD;?></small></a>
          
        </div>
        <div class="">
          <ul class="nav navbar-nav">
            <!--<li class="active"><a href="#">Home</a></li>-->
            <!--<li><a href="#about">About</a></li>-->
            <!--<li><a href="#contact">Contact</a></li>-->
          </ul>
        </div><!--/.nav-collapse -->
        
        <!--<div id="support-div">-->
          <a id="support-link" href="https://github.com/bobdesaunois/Project-Falcon-Storm/issues" target="_blank">Support</a>
          <!--</div>-->
        
      </div>
    </div>


    <div class="container">

      <!--content-->
      <div id="content">
          
        <?php
        $userdata = $this->session->userdata("warning");
        if($userdata) { 
        ?>

        <div class="alert alert-info" role="alert">

            <span class="glyphicon glyphicon-info-sign"></span>  <strong>Info </strong><?php echo $this->session->userdata("warning"); ?>

        </div>

        <?php
            $this->session->unset_userdata("warning");
        } 
        ?>