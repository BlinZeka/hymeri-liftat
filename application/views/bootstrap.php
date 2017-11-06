
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-fixed-top nopadding" role="navigation" style="min-height: 70px; border-bottom:  solid #ffcb08;">
      <div class="container">
        <div class="navbar-header nopadding">      
          <a href="#">
          	<img class="logo_back" src="<?=base_url()?>assets/images/hymeri_logo.png" style="max-height: 67px;">
          </a>
        </div>
        <div class="collapse navbar-collapse nopadding">
          <ul class="nav navbar-nav pull-right">
            <li class="active"><a href="#">Map</a></li>
            <li><a href="#about">Notifications</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Notif</a></li>
              </ul>
            </li>            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
              <ul class="dropdown-menu" style="background: #2C567E; min-height: 35px;">
                <li><a href="#" style="color: #ffffff">Profile</a></li>
                <li><a href="#" style="color: #ffffff">Settings</a></li>
                <li><a href="#" style="color: #ffffff">Logout</a></li>
              </ul>
            </li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container col-md-12" style="padding-left: 0px; padding-right: 0px; padding-top: 70px;">
      <div class="col-md-2" role="navigation" style="padding-left: 0px;">
        <div class="list-group">
          <a href="<?=base_url()?>index.php/buildings" class="list-group-item">Komplekset</a>
          <a href="<?=base_url()?>index.php/company" class="list-group-item">Kompania</a>
          <a href="<?=base_url()?>index.php/clients" class="list-group-item">Banoret</a>
          <a href="<?=base_url()?>index.php/reports" class="list-group-item">Raporte</a>
          <a href="<?=base_url()?>index.php/payments" class="list-group-item">Payment</a>
          <a href="<?=base_url()?>index.php/payments" class="list-group-item">Mirembajtja</a>
        </div>
      </div>
      <div class="col-md-10">
      	<?php
					echo $output; 
				?>
      </div>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
  </body>
</html>
