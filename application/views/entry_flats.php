<script>

	$("a[href='<?=base_url()?>index.php/buildings']:first").find('.lm_box').attr("class", "lm_box_selected");

	// $("#title_1").text("<?=$breadcrumb?>");

</script>

<script>
  $(function() {
	jQuery(function($){
	   $("#date").mask("99/99/9999");
	});

	    // $( "#date" ).datepicker();
	    $( "#fromDate" ).datepicker();
	    $( "#toDate" ).datepicker();
  });


  
  </script>
<input type ="hidden" id= "entry_id" value="<?php echo $entry_id; ?>">
<div class="content_main">
	<?php echo  $breadcrumb ?>
	<ul class="nav nav-tabs nav-justified" data-tabs="tabs">

		<li id = "LiViewClient" class="active"><a href="#view" data-toggle="tab">View</a></li>
		<li id = "LiAddClient" <?php if($level == 4){ ?> style="display:none" <?php } ?>><a href="#addClient" id ="addClientLabel" data-toggle="tab">Add Client</a></li>

		

	</ul>
			
	<div style = "margin:20px;margin-left:7px;margin-bottom:-40px;margin-bottom:20px;" id = "notesEntry"><h5 style = "color:#E00707"><?php  if($entryDetail[0]['entryNote'] == "0"){ echo "";  }else{ echo "<br/>".nl2br($entryDetail[0]['entryNote']);} ?></h5></div>
	<div class="tab-content" style="padding-top: 40px;">

			
		<div id="view" class="tab-pane active">
			
			
			<table class="table table-striped" id = "clientsentry">

				<thead>

					<tr>

						
						<td>Floor</td>
						
						<td>Flat Nr</td>

						<td>Name</td>

						<td>Phone</td>

						<td>Created By</td>

						<td>VIP Floor</td>

						<td>Status</td>

						<td>#</td>


					</tr>

				</thead>

				<tbody>

				<?php

				foreach ( $clients as $clients ) {
						if ($clients->status>0) { $td =  "<img src = '". base_url() . "assets/images/active.png'>";} else{ $td =  "<img src = '". base_url() . "assets/images/inactive.png'>"; }
											echo "<tr>			

									 	
									 	<td>{$clients->floor}</td>
									 	<td>{$clients->fnumber}</td>
									 	 <td><a href='".base_url()."index.php/cards/index/".$clients->id."' style='color:#2C567E; text-decoration: underline;'> {$clients->name}</a></td>

										<td>{$clients->phone_1}</td>

										<td>{$clients->created_by}</td>

										<td>/</td>

										<td>".$td."</td>" ;
										
										if($level == 2 || $level == 1){
										echo "<td><a class='btn btn-xs btn-warning' onclick='edit({$clients->id});'>Edit</a> <a class='btn btn-xs btn-danger' onclick='updateClient($clients->id);'><span class='glyphicon glyphicon-remove'></span></a></td>";
									    }
										

								echo	"</tr>";

				}

				?>				

			</tbody>

			</table>

		</div>



		<div id="addClient" class="tab-pane">

			<form class="form-horizontal col-md-7" role="form" id = "myForm" action="<?=base_url()?>index.php/clients/insert">

				<input type="hidden" name="flat_id" value="" />

				<input type="hidden" name="id" value="-1" />

				<div  id = "flat_id" class="form-group">

					<label class="col-sm-2 control-label">Flat Number</label>

					<div class="col-sm-10">

						<!-- <select name="flat_id" class="gender-control"> -->
							
							<?php

								// foreach ($showAllFlatsByEntry as $entry) { ?>

									<!-- <option value="<?php echo$entry->id; ?>"><?php echo$entry->name; ?></option> -->

								<?php 
								// }

							?>

						<!-- </select> -->

						<!-- Hidding this when it comes to Edit this field as this is the id of flat and not number of flat,  so by hiding this they wont be able to screw up the program-->
						<input type="text" name="flat_id"  id = "flat_id" class="form-control" placeholder="">


					</div>

				</div>	


				<div id = "flat_number" style = "" display="none" class="form-group">

					<label class="col-sm-2 control-label">Flat Number</label>

					<div class="col-sm-10">

						<input type="text" name="number" id = "flat_number" class="form-control">

					</div>

				</div>

				<div id = "floor_no" style = "" display="none" class="form-group">

					<label class="col-sm-2 control-label">Floor</label>

					<div class="col-sm-10">

						<input type="text" name="floor" id = "floor_no" class="form-control">

					</div>

				</div>

				<div id = "entry_id" style = "display:none"  class="form-group">

					<label class="col-sm-2 control-label">Entry</label>

					<div class="col-sm-10">

						<input type="text" name="entry_id" id = "entry_id" class="form-control">

					</div>

				</div>

				
				<div class="form-group">

					<label class="col-sm-2 control-label">Personal Id</label>

					<div class="col-sm-10">

						<input type="text" name="personal_id" id = "personal_id" class="form-control">

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

					<label class="col-sm-2 control-label">Payment Note</label>

					<div class="col-sm-10">

						<input type="text" name="monthly_price"  id="monthly_price"  class="form-control">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Phone 1</label>

					<div class="col-sm-10">

						<input type="text" name="phone_1" id= "phone_1" class="form-control">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Phone 2</label>

					<div class="col-sm-10">

						<input type="text" name="phone_2" id= "phone_2" class="form-control">

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

						<input type="text" id="date"  placeholder = "dd/mm/yyyy" name="birthday" class="form-control">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Email</label>

					<div class="col-sm-10">

						<input type="text" name="email" class="form-control">

					</div>

				</div>

				

				<!-- masaker -->

				<div id="cards" class="form-group">

				</div>

				<!-- <div class="form-group">

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

		<div id="add" class="tab-pane">

			<form class="form-horizontal col-md-7" role="form" action="<?=base_url()?>index.php/buildings/insert">

				<input type="hidden" name="id" value="-1" />

				<input type="hidden" name="lat" value="0" /> 

				<input type="hidden" name="lon" value="0" />

				<div class="form-group">

					<label class="col-sm-2 control-label">Name</label>

					<div class="col-sm-10">

						<input type="text" name="name" class="form-control" placeholder="Building Name">

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Zone</label>

					<div class="col-sm-10">

						<select name="zone_id" class="selection">

							<?php

								foreach ($zones as $zone) {

									echo '<option value="'.$zone['id'].'">'.$zone['name'].'</option>';

								} 

							?>

						</select>

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Company</label>

					<div class="col-sm-10">

						<select name="company_id" class="selection">

							<?php

								foreach ($companies as $company) {

									echo '<option value="'.$company['id'].'">'.$company['name'].'</option>';

								} 

							?>

						</select>					

					</div>

				</div>

				<div class="form-group">

					<div class="col-sm-offset-2 col-sm-10">

						<button id="submit" type="submit" class="btn btn-default">Ruaje</button>

						<button id="cancel" class="btn btn-default" style='margin: 1px -55px;'>Pastro</button>

					</div>

				</div>

			</form>

		</div>

	</div>

</div>

<script type="text/javascript">

	$(document).ready(function () {

		$('#LiAddClient').click(function(event) {

			$('#flat_number').hide();
			$('#entry_id').hide();
			$('#addClient').find('form').first().attr('action', "<?=base_url()?>index.php/clients/insert");
		});

		$('#LiViewClient').click(function(event) {

			$('#addClientLabel').text('Add Client');
		});


  	$('#tabs').tab();

		$('#cancel').click(function(event) {

		  event.preventDefault();

		  $('#add').find('input, select, textarea').val("");

		  $('#add').find('id').val("-1");

		  $('#add').find('form').first().attr('action', "<?=base_url()?>index.php/buildings/insert");

		});

  	$('.edit-data').click(function() {

    	$.post('<?=base_url()?>index.php/buildings/ajax/' + this.id, function(data){

      	$('a[href=#add]:first').attr('data-toggle', 'tab');

      	$('a[href=#add]').tab('show');

      	$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/buildings/edit");

      	$.each(data, function(key, value) {

        	$('#add').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);

        });      	

    	}, 'json');

    });

 	 	 $('#addClient').find('form').first().validate({

			rules: {

			  flat_id: {required: true, minlength:1},

			  first_name: {required: true, minlength:3},

			  last_name: {required: true, minlength:3},

			  phone_1: {required: true, minlength:3},

			  birthday: {required: true, minlength:3},

			  email: {required: true, minlength:3},

			  personal_id: {required: true, minlength:3},

		  }

		}); 

  });



 function edit(id) {
 	
 	$('#addClientLabel').text('Edit Client');
 	$('#flat_id').hide();

 	$('#flat_number').show();
 	$('#entry_id').show();


  	$.post('<?=base_url()?>index.php/clients/ajax/' + id, function(data) {
  		console.log(data);
    	$('a[href=#addClient]:first').attr('data-toggle', 'tab');

    	$('a[href=#addClient]').tab('show');

    	$('#addClient').find('form').first().attr('action', "<?=base_url()?>index.php/clients/editFromEntries/"+$('#entry_id').val()+"");

    	$.each(data, function(key, value) {
    	// console.log(key +'->' +value);
      	$('#addClient').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);

      });      	

  	}, 'json');

  	//card_no == todecimal(tohex(site_code) + tohex(site_no))

  }

    function deleteClient(id){
  		var r=confirm("Are you sure you want to delete this record?");
		if (r==true) {

		    	    $.ajax({
			            type: "POST",
			            async: false,
			            url: '<?=base_url()?>index.php/clients/deleteClientUpdate/' + id,
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
  		var r=confirm("Are you sure you want to delete this record?");
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


  $('li').click(function(event) {
  	$('#flat_id').show('slow/100/fast', function() {
 	});


 	$('#myForm').find('input:text').val(''); 
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