<?php 
	$this->load->helper('language');
	$this->lang->load('en', 'english');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo lang('title'); ?></title>
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
<meta property="og:title" content="Hymeri Kleemann">
<meta property="og:type" content="sport">
<meta property="og:url" content="">
<meta property="og:image" content="">
<meta property="og:site_name" content="">
<meta property="og:description" content="">

<style type="text/css" media="screen">
			@import "<?=base_url() ?>assets/css/TableTools.css";
			div.dataTables_wrapper { font-size: 13px; }
			table.display thead th, table.display td { font-size: 13px; }
			
</style>

<link href="<?=base_url() ?>assets/js/select2/select2.css" rel="stylesheet"/>
<link href="<?=base_url() ?>assets/js/select2/pnotify.custom.min.css" rel="stylesheet"/>


  

<!--jQuery-->

<script src="<?=base_url() ?>assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?=base_url() ?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url() ?>assets/js/TableTools.min.js" type="text/javascript"></script>
<script src="<?=base_url() ?>assets/js/ZeroClipboard.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url() ?>assets/js/libs/FileSaver.js/FileSaver.js"></script>
<script src="<?=base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?=base_url() ?>assets/js/pnotify.custom.min.js" type="text/javascript"></script>
<script src="<?=base_url() ?>assets/js/jquery.jstepper.js" type="text/javascript"></script>


<!-- Code editor -->

<script src="http://d1n0x3qji82z53.cloudfront.net/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>

<!-- Angular script-->
	<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/sorting.js"></script>
	<script srr="<?php echo base_url() ?>assets/js/filter.js"></script>
	<script src="<?php echo base_url() ?>assets/js/userSort.js"></script>
	<script srr="<?php echo base_url() ?>assets/js/clientSorting.js"></script>
<!-- end of angular script -->



<!-- Editor -->
<script type="text/javascript" src="<?=base_url() ?>assets/js/examples/js/editor.js"></script>
 
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?=base_url()?>assets/bootstrap/css/bootstrap.css">
<!-- Latest compiled and minified JavaScript -->
<script src="<?=base_url()?>assets/bootstrap/js/bootstrap.js"></script>
<script src="<?=base_url() ?>assets/js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="<?=base_url() ?>assets/js/bootbox.js" type="text/javascript"></script>
<script src="<?=base_url() ?>assets/js/select2/select2.min.js" type="text/javascript"></script>


  <script src="<?=base_url() ?>assets/js/select2/select2.js"></script>
    <script>
        $(document).ready(function() { 
        $("#e1").select2({
	    placeholder: "Select a State",
	    allowClear: false
	});

        $("#buildingList").select2({
	    placeholder: "Select Building",
	    allowClear: false
	});

          $("#buildingList2").select2({
	    placeholder: "Select Building",
	    allowClear: false
	});

          $("#entryList").select2({
	    placeholder: "Select  Entry",
	    allowClear: false
	});

        });
    </script>



<!--Styles-->

<link rel='stylesheet' type='text/css' media='all' href="<?=base_url() ?>assets/css/global.css" />
<link rel='stylesheet' type='text/css' media='all' href="<?=base_url() ?>assets/css/entypo.css" />
<!-- ENTYPO FONTS -->

<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script> -->

<!--Google Font-->
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,100italic,300italic,400italic,700italic'
	rel='stylesheet' type='text/css'>



<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <link rel="stylesheet" href="<?=base_url() ?>assets/css/redmond/jquery-ui-1.10.4.custom.css">

<script>
jQuery(document).ready(function($){
   // Check the initial Poistion of the Sticky Header
   var stickyHeaderTop = $('.left_menu').offset().top;

   $(window).scroll(function(){
           if( $(window).scrollTop() > stickyHeaderTop ) {
                   $('.left_menu').css({position: 'fixed', top: '-63px'});
               } else {
                   $('.left_menu').css({position: 'absolute', top: '0'});
           }
   });

       
    
});

</script>

</head>
<body>

	<div class="header">
		<div class="header_back">
			<a href="<?=base_url() ?>index.php/main"><img class="logo_back" src="<?=base_url() ?>assets/images/hymeri_logo.png"></a>

			<div class="header_right_menu">
				<a href="#">
					<div class="rm_notification_box">
						<!-- <img class="rm_profile_pic" src="<?=base_url() ?>assets/images/profile_picture_default.png"> -->
						<div class="rm_profile_name"><?=$username?></div>
					</div>
				</a>
				<!-- rm_notification_box :END -->

				<!-- <a href="#">
					<div class="rm_notification_box">
						<div class="rm_notification_box_inside">15</div>
					</div>
				</a> -->
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

	<div class="message_box_container" style="position: relative; z-index: 99999">
		<div id="message_box" class="notification_popup popup">
			<div class="triangle_top"></div>
			<div class="np_title">Porositë e reja</div>
			<div class="np_message_container"></div>
			<!-- np_message_container :END -->
			<div class="np_all_notifications">
				<a href="<?php echo base_url();?>index.php/main/clients/6">All notification</a>
			</div>
		</div>
		<!-- notification_popup :END -->
	</div>
	<script type="text/javascript">
/* 
        // create a new websocket
        var socket = io.connect('http://webi.dev:8000');
        // on message received we print all the data inside the #container div
        socket.on('notification', function (data) {
       	var count;
        var usersList = "";
        $.each(data.notif_count,function(index,notif){
            usersList += "<div class='np_message'><a href='#' title='porosi e re'>" + notif.comp_name + " ka bere porosi te re" +"</a></div>\n";       
			count = notif.rowCount;        
        })


        //alert(usersList);
       $('.np_message_container').html(usersList);
       $('.rm_notification_box_inside').html(count);
   
      }); */
    </script>

	<div id="setting_box" class="settings_popup popup">
		<div class="sp_triangle_top"></div>
		<!-- <div class="np_title">Porositë e reja</div> -->
		<div class="sp_message_container">
			<div class="sp_message">
				<a href="<?=base_url()?>index.php/settings">Profili</a>
			</div>
			<div class="sp_message">
				<a href="<?=base_url()?>index.php/settings">Settings</a>
			</div>
			<div class="sp_message2">
				<a href="<?=base_url()?>index.php/main/logout">Log Out</a>
			</div>
		</div>
		<!-- sp_message_container :END -->
		<!-- <div class="np_all_notifications"><a href="#">All notification</a></div> -->
	</div>
	<!-- settings_popup :END -->

	<div class="left_menu">
		<!-- 	<div class="search_bar_min"></div> -->
		<div class="ui-widget">
			
		</div>
		

		<?php if($level == 4){ ?>
		<a href="<?=base_url()?>index.php/main" style="display:none;">
			<div class="lm_box">
				<span class="glyphicon glyphicon-home" style="float: left; margin: 5px;"></span>
				<div class="lm_text">Main</div>
			</div>
		</a>
		<?php } ?>

		<a href="<?=base_url()?>index.php/buildings"  >
			<div class="lm_box">
				<span class="glyphicon glyphicon-calendar" style="float: left; margin: 5px;"></span>
				<div class="lm_text">Buildings</div>
			</div>
		</a>
		<!-- lm_box :END -->

		

		<a href="<?=base_url()?>index.php/clients" <?php if($level == 4) { ?> style="display:none" <?php } ?>>
			<div class="lm_box">
				<span class="glyphicon glyphicon-user" style="float: left; margin: 5px;"></span>
				<div class="lm_text">Clients</div>
			</div>
		</a>

		<?php if ($level == 2) { ?>
		<a href="<?=base_url()?>index.php/users">
			<div class="lm_box">
				<span class="glyphicon glyphicon-wrench" style="float: left; margin: 5px;"></span>
							<div class="lm_text">Users</div>
				</div>
		</a>	
		<?php } ?>


		<?php if ($level == 2) { ?>
		<a href="<?=base_url()?>index.php/access">
			<div class="lm_box">
				<span class="glyphicon glyphicon-user" style="float: left; margin: 5px;"></span>
				<div class="lm_text">Employees</div>
			</div>
		</a>
		<?php } ?>
		<!-- lm_box :END -->

		
		<!-- lm_box :END -->
		<?php if ($level == 2 || $level == 1) { ?>
		<a href="<?=base_url()?>index.php/reports">
			<div class="lm_box">
				<span class="glyphicon glyphicon-euro" style="float: left; margin: 5px;"></span>
				<div class="lm_text">Payments</div>
			</div>
		</a>
		<?php } ?>

		<?php if ($level == 2) { ?>
		<a href="<?=base_url()?>index.php/payments">
			<div class="lm_box">
				<span class="glyphicon glyphicon-signal" style="float: left; margin: 5px;"></span>
				<div class="lm_text">Raports</div>
			</div>
		</a>
		<?php } ?>
		<!-- lm_box :END -->

			<?php if ($level == 2) { ?>
					<a href="<?=base_url()?>index.php/maintaining/users">
						<div class="lm_box">
							<span class="glyphicon glyphicon-wrench" style="float: left; margin: 5px;"></span>
							<div class="lm_text">Maintenance</div>
						</div>
					</a>
					
					<a href="<?=base_url()?>index.php/companies">
						<div class="lm_box">
							<span class="glyphicon glyphicon-asterisk" style="float: left; margin: 5px;"></span>
							<div class="lm_text">Companies</div>
						</div>
					</a>
					
			<?php } ?>

		
		<!-- lm_box :END -->
	</div>
	<!-- left_menu :END -->
	<div class='title'>
	  <div id='title_1'></div>
	  </div>
  <?php
    echo $output; 
  ?>
</body>

<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $('.rm_notification_box2').click(function() {
    if ( $(".settings_popup").is(":visible") ) {
      $('.popup').hide();
      $(".settings_popup").hide();
	  } else { 
	    $('.popup').hide();
	    $(".settings_popup").show(); 
	  }
  });
  
  $('.rm_notification_box_inside').click(function() {
    if ( $(".notification_popup").is(":visible") ) {
      $('.popup').hide();
      $(".notification_popup").hide();
	  } else { 
	    $('.popup').hide();
	    $(".notification_popup").show(); 
	  }		  
  });





$("#clientsentry").dataTable({
      "bFilter": true,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      "bServerSide": false,
      "iDisplayLength":5000,
      "bRetrieve":true,
      "bDestroy": true
});




  $('.datatables').dataTable({
  	
  		
		"aaSorting": [[ 5 , 'desc']],
		"sDom": 'T<"clear">lfrtip',
		    "oTableTools": {
			// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
			"sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf",
			"aButtons": ["pdf","csv",
				                {
				                    "sExtends": "collection",
				                    "sButtonText": "More",
				                    "aButtons": [
				                        {"sExtends": "copy", "bSelectedOnly": true},
				                        {"sExtends": "csv", "bSelectedOnly": true},
				                        {"sExtends": "xls", "bSelectedOnly": true},
				                        {"sExtends": "pdf", "bSelectedOnly": true},
				                        "print"
				                    ]
				                }
				            ]
			},
  });


  $('.datatable').dataTable({
  	
  		
		"sDom": 'T<"clear">lfrtip',
		    "oTableTools": {
			// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
			"sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf",
			"aButtons": ["pdf","csv",
				                {
				                    "sExtends": "collection",
				                    "sButtonText": "More",
				                    "aButtons": [
				                        {"sExtends": "copy", "bSelectedOnly": true},
				                        {"sExtends": "csv", "bSelectedOnly": true},
				                        {"sExtends": "xls", "bSelectedOnly": true},
				                        {"sExtends": "pdf", "bSelectedOnly": true},
				                        "print"
				                    ]
				                }
				            ]
			},
  });


   $('.pending').dataTable({
  	
  		
		"aaSorting": [[ 6 , 'asc']],
		"sDom": 'T<"clear">lfrtip',
		    "oTableTools": {
			// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
			"sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf",
			"aButtons": ["pdf","csv",
				                {
				                    "sExtends": "collection",
				                    "sButtonText": "More",
				                    "aButtons": [
				                       
				                        {"sExtends": "xls", "bSelectedOnly": true},
				                        {"sExtends": "pdf", "bSelectedOnly": true},
				                        "print"
				                    ]
				                }
				            ]
			},
  });


  $('#clients_report').dataTable({
  	
  		
		"sDom": 'T<"clear">lfrtip',
		    "oTableTools": {
			// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
			"sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf",
			"aButtons": ["pdf","csv",
				                {
				                    "sExtends": "collection",
				                    "sButtonText": "More",
				                    "aButtons": [
				                        {"sExtends": "copy", "bSelectedOnly": true},
				                        {"sExtends": "csv", "bSelectedOnly": true},
				                        {"sExtends": "xls", "bSelectedOnly": true},
				                        {"sExtends": "pdf", "bSelectedOnly": true},
				                        "print"
				                    ]
				                }
				            ]
			},
  });

    $('.datatable_pagesat').dataTable({
  	
  		
		"sDom": 'T<"clear">lfrtip',
		'Title':'test',
		"aaSorting": [[ 0, 'desc']],
		     "oTableTools": {
				// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
				"sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf",
					"aButtons": [
					
					"xls",
					{
						"sExtends": "pdf",
						// "sPdfOrientation": "landscape",

						"sPdfMessage": "Client Name: " + $('#clientNamePrint').val() + "       Building: " + $('#clientBuildingPrint').val() +"       Entry: "  + $('#clientEntryPrint').val(),
					},
					"print"
				]
				},
  });

});
</script>




</html>