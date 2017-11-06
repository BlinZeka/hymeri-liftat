<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<?php
	foreach ( $css_files as $file ) :
	?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body {
	font-family: Arial;
	font-size: 14px;
}

a {
	color: blue;
	text-decoration: none;
	font-size: 14px;
}

a:hover {
	text-decoration: underline;
}
</style>

<html lang="en">
<head>
<meta charset="utf-8">
<title>Main</title>
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
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

<!--Facebook Meta Tags-->
<meta property="og:title" content="Devolli | Princ Caffe">
<meta property="og:type" content="sport">
<meta property="og:url" content="">
<meta property="og:image" content="">
<meta property="og:site_name" content="">
<meta property="og:description" content="">

<!--jQuery-->
<script src="<?=base_url() ?>assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>

<!--Styles-->
<link rel='stylesheet' type='text/css' media='all' href="<?=base_url() ?>assets/css/global.css" />
<link rel='stylesheet' type='text/css' media='all' href="<?=base_url() ?>assets/css/entypo.css" />
<!-- ENTYPO FONTS -->

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<!--Google Font-->
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,100italic,300italic,400italic,700italic'
	rel='stylesheet' type='text/css'>


<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="<?=base_url() ?>assets/css/ylli_jqueryui.css" />
<script>
$(function() {
var availableTags = [
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"
			];
$( "#tags" ).autocomplete({
	source: availableTags
});
});
</script>
</head>
<body>
	
	<div class="header">
		<div class="header_back">
			<a href="#"><img class="logo_back" src="<?=base_url() ?>assets/images/hymeri_logo.png"></a>

			<div class="header_right_menu">
				<a href="#">
					<div class="rm_notification_box">
						<img class="rm_profile_pic" src="<?=base_url() ?>assets/images/profile_picture_default.png">
						<div class="rm_profile_name">Hymeri Kleemann</div>
					</div>
				</a>
				<!-- rm_notification_box :END -->

				<a href="#">
					<div class="rm_notification_box">
						<div class="rm_notification_box_inside">15</div>
					</div>
				</a>
				<!-- rm_notification_box :END -->

				<a href="#">
					<div class="rm_notification_box2">
						<div class="rm_settings gear icon"></div>
					</div>
				</a>
				<!-- rm_notification_box2 :END -->
			</div>
			<!-- header_right_menu :END -->

		</div>
		<!-- header_back :END -->
		<div class="header_bottom_line"></div>
	</div>
	<!-- header :END -->
	
	<div id="setting_box" class="settings_popup">
			<div class="sp_triangle_top"></div>
			<!-- <div class="np_title">Porositë e reja</div> -->
			<div class="sp_message_container">
			<div class="sp_message"><a href="<?=base_url()?>index.php/profile">Profili</a></div>
			<div class="sp_message"><a href="<?=base_url()?>index.php/settings">Settings</a></div>
			<div class="sp_message2"><a href="<?=base_url()?>index.php/main/logout">Log Out</a></div>
			</div> <!-- sp_message_container :END -->
			<!-- <div class="np_all_notifications"><a href="#">All notification</a></div> -->
	</div> <!-- settings_popup :END -->	

	<div class="left_menu">
		<!-- 	<div class="search_bar_min"></div> -->
		<div class="ui-widget">
			<input id="tags" />
		</div>
		<div class="search_bar_min">
			<div class="search_icon"></div>
		</div>

		<a href="<?=base_url()?>index.php/buildings">
			<div class="lm_box">
				<div class="usergroup_icon"></div>
				<div class="lm_text">Komplekset</div>
			</div>
		</a>
		<!-- lm_box :END -->

		<a href="<?=base_url()?>index.php/company">
			<div class="lm_box_selected">
				<div class="document_icon"></div>
				<div class="lm_text">Kompania</div>
			</div>
		</a>
		<!-- lm_box :END -->

		<a href="<?=base_url()?>index.php/clients">
			<div class="lm_box">
				<div class="attachment_icon"></div>
				<div class="lm_text">Banoret</div>
			</div>
		</a>
		<!-- lm_box :END -->

		<a href="<?=base_url()?>index.php/reports">
			<div class="lm_box">
				<div class="cancel_icon"></div>
				<div class="lm_text">Raporte</div>
			</div>
		</a>
		<!-- lm_box :END -->

		<a href="<?=base_url()?>index.php/payments">
			<div class="lm_box">
				<div class="map_icon"></div>
				<div class="lm_text">Payment</div>
			</div>
		</a>
		<!-- lm_box :END -->
		
		<a href="<?=base_url()?>index.php/payments">
			<div class="lm_box">
				<div class="mirembajtja_icon"></div>
				<div class="lm_text">Mirembajtja</div>
			</div>
		</a>
		<!-- lm_box :END -->
	</div>
	<!-- left_menu :END -->
		<div>
		<?php echo $output; ?>
    </div>
	
	
</body>
</html>