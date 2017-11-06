<?php 
	$this->load->helper('language');
	$this->lang->load('en', 'english');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title><?php echo lang('login_title'); ?></title>
<meta name="description" content="description..." />
<meta name="keywords" content="keywordss......" />
<meta name="copyright" content="Company" />
<meta name="author" content="Bbros" />
<meta name="email" content="" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Distribution" content="Global" />
<meta name="Rating" content="General" />
<meta name="Robots" content="INDEX,FOLLOW" />
<meta name="Revisit-after" content="1 Day" />
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />

<meta property="og:title" content="" />
<meta property="og:image" content="" />
<meta property="og:site_name" content="" />
<meta property="og:description" content="" />

<!-- Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Styles -->
<link rel='stylesheet' type='text/css' media='all' href="<?=base_url();?>assets/css/login.css" />
<link href="<?=base_url();?>/assets/css/application.css" media="screen" rel="stylesheet" type="text/css" />



<!-- Favicons-->
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png" />
<!--iPhone homescreen icon-->

<!-- Google Font (Lato) -->
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,100italic,300italic,400italic,700italic'
	rel='stylesheet' type='text/css'>
<!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css'> -->

<!-- Apple Devices tweaks -->
<meta name="viewport" content="width=device-width; initial-scale=0.343; maximum-scale=3.0; minimum-scale=0.7;" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png" />
<!--iPhone homescreen icon-->
<link rel="apple-touch-startup-image" href="images/startup.png" />


</head>

<body>
	<?php echo validation_errors(); ?>
	<form method="post" action="<?=base_url();?>/index.php/verifylogin">
		<div class="login_container">
			<div class="header_logo">
				<img src="<?=base_url();?>assets/images/hymer_logo_bardh.png"
					style="max-width: 200px; max-height: 200px; margin: 45px 8px;">
			</div>
			<div class="login_info">Please use the correct login credentials to log in.</div>
			<div class="usern_pass_container">
				<input id="source_url" name="source_url" type="hidden" /> <input id="application_id" name="application_id"
					type="hidden" value="1" /> <input autocapitalize="off" autocorrect="off" id="login" name="username"
					placeholder="Përdoruesi" type="text" /> <input id="password" name="password" placeholder="Fjalëkalimi"
					type="password" />

				<div class="remember_me_forget">
					<input checked="checked" id="remember_me" name="remember_me" type="checkbox" value="remember_me" /> <label
						for="remember_me">Më mbaj të lidhur&nbsp;</label>

					<div class="reset_pass">
						<!-- <a href="reset_password/reset.html">Harrova fjalëkalimin!</a> -->
					</div>
				</div>
				<!-- remember_me_forget :END -->
				<button id="signIn" type="submit" class="large yellow button">Lidhu &raquo;</button>
			</div>
			<!-- usern_pass_container :END -->
		</div>
		<!-- login_container :END -->
	</form>
	<div class="copyright">Copyright &copy; 2014 Hymeri Kleemann.</div>

</body>
</html>