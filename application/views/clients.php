<script>

	$("a[href='<?=base_url()?>index.php/clients']:first").find('.lm_box').attr("class", "lm_box_selected");

	$("#title_1").text("<?=$breadcrumb?>");

</script>

 
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 


<script>

	


  $(function() {

	jQuery(function($){
	   // $("#date").mask("99/99/9999");
	   // $("#phone").mask("(999) 999-9999");
	   // $("#tin").mask("99-9999999");
	   // $("#ssn").mask("999-99-9999");
	});

	    // $( "#date" ).datepicker();
	    $( "#fromDate" ).datepicker();
	    $( "#toDate" ).datepicker();
  });

  //   $('#client-table').dataTable({
  	
  // 		"bJQueryUI": true,
		
		// "sDom": 'T<"clear">lfrtip',
		// "oTableTools": {
		// 	// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
		// 	"sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf"
		// }
  // });

  </script>


<div class="content_main">

	<ul class="nav nav-tabs nav-justified" data-tabs="tabs" id="tabs">

		<li class="active"><a href="#view" data-toggle="tab">View</a></li>

		<li><a href="#add" data-toggle="tab">Edit</a></li>

	</ul>

	<div class="tab-content" style="padding-top: 30px;">

		<div id="view" class="tab-pane active">

			<table class="table table-striped" id="client-table">

				<thead>

					<tr>

						<td  width="150">Building Name</td>

					<td  width="90">Entry</td>
					<td width="20">Flat Nr</td>

					<td width="120">Name</td>

					<td  width="90">Phone</td>

					<td  width="120">Create by</td>

					<td>Status</td>

					<td width="20">VIP Floor</td>

					<td  width="120">Street</td>

					<td width="120px">#</td>

					<td width="120">Card no</td>

						<td></td>
						<td></td>

					</tr>

				</thead>

				<tbody>

				</tbody>

			</table>

		</div>


		<div id="add" class="tab-pane">

			<form class="form-horizontal col-md-7" id = "myForm" role="form" action="<?=base_url()?>index.php/clients/insert">

				<input type="hidden" name="flat_id" value="" />

				<input type="hidden" name="id" value="-1" />

				<div class="form-group">

					<label class="col-sm-2 control-label">Flat Nr</label>

					<div class="col-sm-10">

						<select name="flat_id" style = "margin-left:12px;width:500px;" id="e1">

							<?php

								foreach ($flats as $flat) {

										echo '<option value="'.$flat['id'].'">'.$flat['name'].' --- '. $flat['entryName'].' --- '. $flat['buildingName'].'</option>';

								}

							?>

						</select>

					</div>

				</div>				

				<div class="form-group">

					<label class="col-sm-2 control-label">First Name</label>

					<div class="col-sm-10">

						<input type="text" name="first_name" class="form-control" placeholder="">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Last Name</label>

					<div class="col-sm-10">

						<input type="text" name="last_name" class="form-control">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Payments Note</label>

					<div class="col-sm-10">

						<input type="text" name="monthly_price"  class="form-control">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Phone 1</label>

					<div class="col-sm-10">

						<input type="text" name="phone_1" id = "phone_1" class="form-control">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Phone 2</label>

					<div class="col-sm-10">

						<input type="text" name="phone_2"  id = "phone_2" class="form-control">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Gender</label>

					<div class="col-sm-10">

						<select name="gender" class="gender-control">

							<option value="0">Female</option>

							<option value="1">Male</option>

						</select>

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Birthday</label>

					<div class="col-sm-10">

						<input type="text" id="date" name="birthday" class="form-control">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Email</label>

					<div class="col-sm-10">

						<input type="text" name="email" class="form-control">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Personal Id</label>

					<div class="col-sm-10">

						<input type="text" name="personal_id" id="personal_id" class="form-control">

					</div>

				</div>

				<!-- masaker -->

				<div id="cards" class="form-group">

				</div>

			<!-- 	<div class="form-group">

					<label class="col-sm-1_control-label_1">From</label>

					<div class="col-sm-3">

						<input type="text"  id="fromDate" name="from" class="form-control_1">

					</div>

					<label class="col-sm-1_control-label_1" style='float: left; margin: 10px -75px;'>To</label>

          <div class="col-sm-3">

            <input type="text"  id="toDate" name="to" class="form-control_1" style='float: left; margin: 33px -93px;'>

          </div>
				</div>	 -->			

				<div class="form-group">

					<div class="col-sm-offset-2 col-sm-10" style='float: right; margin-right: -235px;'>

						<button type="submit" class="btn btn-primary" >Ruaje</button>

						<button id="cancel" class="btn btn-warning" >Pastro</button>
						
						<!-- <button class="btn_btn-default_1" id="add-card" style=' padding: 6px 1px; margin: 1px 5px;'>Shto Kartele</button> -->

					</div>

				</div>

				<!-- fundi -->

			</form>

		</div>

	</div>

</div>

<div id="card_holder" style="display: none;">

	<!-- <label class="col-sm-2 control-label">Card No.</label> --> 

	<label class="col-sm-2_control-label1">Site Code</label> 

	<label class="col-sm-3_control-label2">Site Nr.</label>

	<div class="col-sm-12">

		<!-- <input type="text" name="card_no[]">  -->

		<input type="text" name="site_code[]"> 

		<input type="text" name="site_no[]">

	</div>

	<button class="btn_btn-default_2" id="remove">-</button>

</div>

<script type="text/javascript">

	$(document).ready(function () {

  	$('#tabs').tab();

		$('#remove').click(function(e){

			e.preventDefault();

			console.log(this.id);

			$(this).parent().remove();

		});

		$('#add-card').click(function(e){

			e.preventDefault();

			var copy = $('#card_holder').clone(true).css("display", "");

			$('#cards').append(copy);

		});

    $('#client-table').dataTable({

      "bPaginate": true,

   
		"aaSorting": [[ 6 , 'desc']],
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


      

      "bFilter": true,

      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

      "bProcessing": true,

      "sAjaxSource": "<?=base_url()?>index.php/clients/<?=$server?>",

      "bServerSide": false,

      "iDisplayLength":20,
		
		"aoColumnDefs": [{ "bVisible": false, "aTargets": [10] } , {"bVisible": false, "aTargets": [11]}],

			"aoColumns":

				//qitu jon fut te dhanat
				['building_name',

					{'fnRender' : function(obj) {


						return obj.aData[1];

					}},
					'phone_1',

					{'fnRender' : function(obj) {

						return "<a href='<?=base_url()?>index.php/cards/index/"+obj.aData[11]+"' style='color:#2C567E; text-decoration: underline;'>"+obj.aData[3]+"</a>";

					}},



					'flat_name',

					{'fnRender' : function(obj) {

						return obj.aData[5];

					}},

					{'fnRender' : function(obj) {

						if (obj.aData[9]>0) { return "";} else{return "";};


					}},

					{'fnRender' : function(obj) {

						return "/";

					}},

					{'fnRender' : function(obj) {

						return obj.aData[10];

					}},

					{'fnRender' : function(obj) {

						return "<a class='btn btn-xs btn-warning' onclick='edit("+obj.aData[11]+");'>Edit</a> <a class='btn btn-xs btn-danger' onclick='updateClient("+obj.aData[11]+");'><span class='glyphicon glyphicon-remove'></span></a>";

					}},

					{'fnRender' : function(obj) {

						return obj.aData[12];

					}},

					{'fnRender' : function(obj) {

						return obj.aData[13]+"-"+obj.aData[14];


					}},


          //    {'fnRender' : function(obj) {

          // 	return "<div style = 'display:none' id = 'searchCard' >"+ obj.aData[12] +"</div>";

          // }},

          //   {'fnRender' : function(obj) {

          // 	return "<div style = 'display:none' id = 'searchCard' >"+ obj.aData[13] +"</div>";

          // }},

         

        






        ]

    });

		$('#cancel').click(function(event) {

		  event.preventDefault();

		  $('#add').find('input, select, textarea').val("");

		  $('#add').find('id').val("-1");

		  $('#add').find('form').first().attr('action', "<?=base_url()?>index.php/clients/insert");

		  $('#cards').empty();

		});

 	 	$('#add').find('form').first().validate({

			rules: {

			  first_name: {required: true, minlength:3},

			  last_name: {required: true, minlength:3},

			  phone_1: {required: true, minlength:3},

			  birthday: {required: true, minlength:3},

			  email: {required: true, minlength:3},

			  personal_id: {required: true, minlength:3},

		  }

		}); 		

  });

  function deleteClient(id){
//   		alert(id);
  		var r=confirm("Are you sure you want to delete this record?");
		if (r==true) {

		    	    $.ajax({
			            type: "POST",
			            async: false,
			            url: '<?=base_url()?>index.php/clients/deleteClient/' + id,
			            data: '',
			            success: function (result) {
			           		location.reload(false);	
			            }
			        });
		 	
		  }
		else  {
		 
		  }

  }
  
    function updateClient(id){
//   		alert(id);
  		var r=confirm("1Are you sure you want to delete this record?");
		if (r==true) {

		    	    $.ajax({
			            type: "POST",
			            async: false,
			            url: '<?=base_url()?>index.php/clients/changeAllStatus/' + id,
			            data: '',
			            success: function (result) {
			           		location.reload(false);	
			            }
			        });
		 	
		  }
		else  {
		 
		  }

  }

  function edit(id) {

  	$.post('<?=base_url()?>index.php/clients/ajax/' + id, function(data) {

    	// $('a[href=#add]:first').attr('data-toggle', 'tab');

    	$('a[href=#add]').tab('show');

    	$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/clients/edit");

    	$.each(data, function(key, value) {

      	$('#add').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);

      });      	

  	}, 'json');

  	//card_no == todecimal(tohex(site_code) + tohex(site_no))

  }

  $('li').click(function(event) {

 	// $('#myForm').find('input:text').val(''); 
  });

   function isNumberKey(evt)
	       {
	          var charCode = (evt.which) ? evt.which : event.keyCode;
	          if (charCode != 46 && charCode > 31 
	            && (charCode < 48 || charCode > 57))
	             return false;

	          return true;
	       }


	              //attach keypress to input
	            $('#flat_id').keydown(function(event) {
	                // Allow special chars + arrows 
	                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
	                    || event.keyCode == 27 || event.keyCode == 13 
	                    || (event.keyCode == 65 && event.ctrlKey === true) 
	                    || (event.keyCode >= 35 && event.keyCode <= 39)){
	                        return;
	                }else {
	                    // If it's not a number stop the keypress
	                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	                        event.preventDefault(); 
	                    }   
	                }
	            });

	                  //attach keypress to input
	            $('#phone_1').keydown(function(event) {
	                // Allow special chars + arrows 
	                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
	                    || event.keyCode == 27 || event.keyCode == 13 
	                    || (event.keyCode == 65 && event.ctrlKey === true) 
	                    || (event.keyCode >= 35 && event.keyCode <= 39)){
	                        return;
	                }else {
	                    // If it's not a number stop the keypress
	                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	                        event.preventDefault(); 
	                    }   
	                }
	            });

	                  //attach keypress to input
	            $('#phone_2').keydown(function(event) {
	                // Allow special chars + arrows 
	                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
	                    || event.keyCode == 27 || event.keyCode == 13 
	                    || (event.keyCode == 65 && event.ctrlKey === true) 
	                    || (event.keyCode >= 35 && event.keyCode <= 39)){
	                        return;
	                }else {
	                    // If it's not a number stop the keypress
	                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	                        event.preventDefault(); 
	                    }   
	                }
	            });

	                     //attach keypress to input
	            $('#personal_id').keydown(function(event) {
	                // Allow special chars + arrows 
	                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
	                    || event.keyCode == 27 || event.keyCode == 13 
	                    || (event.keyCode == 65 && event.ctrlKey === true) 
	                    || (event.keyCode >= 35 && event.keyCode <= 39)){
	                        return;
	                }else {
	                    // If it's not a number stop the keypress
	                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	                        event.preventDefault(); 
	                    }   
	                }
	            });

</script>