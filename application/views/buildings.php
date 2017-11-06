<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>


<script>


function noenter(e) {
    e = e || window.event;
    var key = e.keyCode || e.charCode;
    
    if(key == 13){
    	return key !== 13; 
    }
    
}

  $(function() {
  	

  $('#addCompany').click(function(event) {
  					
  			 $( "#dialog" ).dialog({
			      modal: true,
			      opacity:0.1,
			      height: 470,
			      width: 550,
			      buttons: {
			        "Add Company": function() {

			        	var company_attribute = { name : $('#cname').val(), owner : $('#cowner').val(), phone : $('#cphone').val() ,business_no : $('#cbusiness').val() , fiscal_no : $('#cfiscal').val(), city_id : $('#cityID').val()}
			        	 $.ajax({
			                       type: "POST",
			                       url: "<?=base_url()?>index.php/buildings/insertBuilding",
			                       data: company_attribute,
			                       success: function(result){

		  			 var arr = JSON.parse(result);
		  			 document.getElementById("companies").innerHTML = "";
			                       	 $.each(arr, function(i, value) {  
					           $('<option></option>', {text:value.name}).attr('value', value.id).appendTo('#companies');
					  });
			                       }
			             });

			          	
			          $( this ).dialog( "close" );
			        },
			          Cancel: function() {
			          $( this ).dialog( "close" );
			        }

			      }
			    });
  	});

$('#deleteCompany').click(function(event) {
	/* Act on the event */

		 $.ajax({
			                       type: "POST",
			                       url: "<?=base_url()?>index.php/buildings/deleteCompany/"+$('#companies').val()+"",
			                       async:false,
			                       success: function(result){

		  			 var arr = JSON.parse(result);
		  			 document.getElementById("companies").innerHTML = "";
			                       	 $.each(arr, function(i, value) {  
					           $('<option></option>', {text:value.name}).attr('value', value.id).appendTo('#companies');
					  });
			                       }
			             });

});


$('#editCompany').click(function(event) {

	$.post('<?=base_url()?>index.php/buildings/Company/' + $('#companies').val(), function(data){

      	// $('a[href=#add]:first').attr('data-toggle', 'tab');

      	// $('a[href=#add]').tab('show');

      	// $('#dialog_editCompany').find('form').first().attr('action', "<?=base_url()?>index.php/buildings/edit");

      	$.each(data, function(key, value) {
      	// console.log("KEY:"+key + '  VALUE:'+value);

        	$('#dialog_editCompany').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);

        });      	

    	}, 'json');


 		$( "#dialog_editCompany" ).dialog({
			      modal: true,
			      opacity:0.1,
			      height: 470,
			      width: 550,
			      buttons: {
			        "Save": function() {
			        
			          var company_attribute = { name : $('#edit_cname').val(), owner : $('#edit_cowner').val(), phone : $('#edit_cphone').val() ,business_no : $('#edit_cbusiness').val() , fiscal_no : $('#edit_cfiscal').val(), city_id : $('#edit_city_id').val()}
			        	 $.ajax({
			                       type: "POST",
			                       url: "<?=base_url()?>index.php/buildings/editCompany/"+$('#companies').val()+"",
			                       data: company_attribute,
			                       success: function(result){

		  			 var arr = JSON.parse(result);
		  			 document.getElementById("companies").innerHTML = "";
			                       	 $.each(arr, function(i, value) {  
					           $('<option></option>', {text:value.name}).attr('value', value.id).appendTo('#companies');
					  });
			                       }
			             });
			          	
			          $( this ).dialog( "close" );
			        },
			          Cancel: function() {
			          $( this ).dialog( "close" );
			        }

			      }
			    });


			

});


$('#addZone').click(function(event) {
  			
	

  			 $( "#dialog_addZone" ).dialog({
			      modal: true,
			      opacity:0.1,
			      height: 200,
			      width: 350,
			      buttons: {
			        "Add Zone": function() {
			        	var myKeyVals = { name : $('#name').val(), cityID : $('#city').val() }
			    
			        	 $.ajax({
			                       type: "POST",
			                       url: "<?=base_url()?>index.php/buildings/insertZone",
			                       data: myKeyVals,
			                       success: function(result){
		  			var arr = JSON.parse(result);
		  			 document.getElementById("zone_id").innerHTML = "";
			                       	 $.each(arr, function(i, value) {  
					           $('<option></option>', {text:value.zoneName}).attr('value', value.zoneID).appendTo('#zone_id');
					           // console.log(value);
					  });
			                       }
			             });
			          	
			          $( this ).dialog( "close" );
			        },
			          Cancel: function() {
			          $( this ).dialog( "close" );
			        }

			      }
			    });
  	});


    


  });
  </script>

<script>

	$("a[href='<?=base_url()?>index.php/buildings']:first").find('.lm_box').attr("class", "lm_box_selected");

	$("#title_1").text("<?=$breadcrumb?>");

	function getCities(countryID){

		document.getElementById("city").innerHTML = "";

		 $.ajax({
	                       type: "GET",
	                       url: "<?=base_url()?>index.php/buildings/getCitiesJson/"+countryID+"",
	                       // data: "emp_Id =" + id,
	                       success: function(result){
  			var arr = JSON.parse(result);
	                       	 $.each(arr, function(i, value) {  
			           $('<option></option>', {text:value.cityName}).attr('value', value.cityID).appendTo('#city');
			           //console.log(value);
			  });
	                       }
	                     });

	}

	function getZones(cityID){

		 document.getElementById("zone_id").innerHTML = "";
		 $.ajax({
	                       type: "GET",
	                       url: "<?=base_url()?>index.php/buildings/getZonesJson/"+cityID+"",
	                       // data: "emp_Id =" + id,
	                       success: function(result){
  			var arr = JSON.parse(result);
	                       	 $.each(arr, function(i, value) {  
			           $('<option></option>', {text:value.zoneName}).attr('value', value.zoneID).appendTo('#zone_id');
			           //console.log(value);
			  });
	                       }
	               });
	}
</script>

<div class="content_main">

	<ul class="nav nav-tabs nav-justified" data-tabs="tabs">

		<li class="active"><a href="#view" data-toggle="tab">View</a></li>
		<?php if ($level == 2  || $level == 1 || $level == 3) { ?>
			<li><a href="#add" data-toggle="tab">Add New</a></li>
		<?php }?>
		

	</ul>

	<div class="tab-content" style="padding-top: 20px;">

		<div id="view" class="tab-pane active">

			<table class="table table-striped datatable">

				<thead>

					<tr>

						<td>Company</td>

						<td>Buildings</td>

						<td>Zone Id</td>

						<td>Street</td>

						<td>Created By</td>

						<td>Create Date</td>

						<td>Updated By</td>

						<td>Update Date</td>

						<td width="120px">#</td>

					</tr>

				</thead>

				<tbody>

				<?php

				foreach ( $buildings as $building ) {

					echo "<tr>			<td> {$building->cname}</td>

									  <td><a href='".base_url()."index.php/entries/index/".$building->id."' style='color:#2C567E; text-decoration: underline;'>{$building->name}</a></td>

									 	<td>{$building->zone}</td>

									 	<td>{$building->street}</td>

										<td>{$building->created_by}</td>

										<td>{$building->create_date}</td>

										<td>{$building->updated_by}</td>

										<td>{$building->update_date}</td>

										<td>";
											echo "<a class='btn btn-xs btn-warning edit-data' id='".$building->id."'>Edit</a>";
// 										 if ($level == 2) {  echo "<a class='btn btn-xs btn-warning edit-data' id='".$building->id."'>Edit</a>";} 
										
										  if ($level == 2) { echo "<a class='btn btn-xs btn-danger deleteBuilding' onClick = 'return deleteBuilding(".$building->id.")' id='".$building->id."'>Del</a>";} 
	               							 echo "  </td>

									</tr>";

				}

				?>				

			</tbody>

			</table>

		</div>

		<div id="add" class="tab-pane">

			<form class="form-horizontal col-md-7" role="form"  method = "post" action="<?=base_url()?>index.php/buildings/insert">

				<input type="hidden" name="id" value="-1" />

				<input type="hidden" name="lat" value="0" /> 

				<input type="hidden" name="lon" value="0" />

				<div class="form-group">

					<label class="col-sm-2 control-label">Building Name</label>

					<div class="col-sm-10">

						<input type="text" name="name" class="form-control" placeholder="Building Name">

					</div>

				</div>
				<label class=" control-label">Location</label>
				<input type = "hidden" id = "lat"  value = "" name = "lat">
				<input type = "hidden" id = "lon" value = ""  name = "lon">
				<div id="map" style = "height: 300px; width:534px; margin:10px;"></div>

				<div class="form-group">

					<label class="col-sm-2 control-label" style=" width: 110px;" >Company Name</label>

					<div class="col-sm-10">

						<select name="company_id" id = "companies" class="selection" style="width: 425px;">
							
							<?php

								foreach ($companies as $company) {

									echo '<option value="'.$company['id'].'">'.$company['name'].'</option>';

								} 

							?>

						</select>
						<?php 
							
							if ($user_level == 2) {
								echo "
								<a id=\"addCompany\"  class=\"btn btn-default\" style=\"border: 1px solid grey; float: right; margin: -34px 38px;\">+</a>
								
								<a id=\"editCompany\"  class=\"btn btn-default\" style=\"border: 1px solid grey; float: right; margin: -34px 0px;\"><img width = \"10x\"src=\"http://www.fancyicons.com/download/?id=5901&t=png&s=16\"> </a>
								";
							} else {
								//<a id=\"deleteCompany\"  class=\"btn btn-default\" style=\"border: 1px solid grey; float: right; margin: -34px 4px;\">-</a>
							}
							
						?>					
						
					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Country</label>

					<div class="col-sm-10">

						<select name="country" id = "country" onChange ="return getCities(this.value)" class="selection">
							<option>Choose Country</option>
							<?php

								foreach ($countries as $country) {

									echo '<option value="'.$country['id'].'">'.$country['name'].'</option>';

								} 

							?>

						</select>					

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">City</label>

					<div class="col-sm-10">

						<select name="city" id = "city" onChange ="return getZones(this.value)" class="selection">

						</select>					

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Zone</label>

					<div class="col-sm-10">

						<select name="zone_id" id = "zone_id" style="width: 490px;" class="selection">

						</select>
						<a id="addZone"  class="btn btn-default" style="border: 1px solid grey; float: right; margin: -34px -35px;">+</a>

					</div>

				</div>

				<div class="form-group">

					<label class="col-sm-2 control-label">Street Name</label>

					<div class="col-sm-10">

						<input type="text" name="street" class="form-control" placeholder="Street Name">

					</div>

				</div>

				

				<div class="form-group">

					<div class="col-sm-offset-2 col-sm-10" style='float: right; width: 177px;'>

						<button id="submit" type="submit" class="btn btn-primary">Ruaje</button>

						<button id="cancel" class="btn btn-warning" >Pastro</button>

					</div>

				</div>

			</form>

		</div>

		<div id="dialog" style = "display:none;" title="Add Company">
		  <div id="addCompany" >

			<form class="form-horizontal col-md-7" role="form"  method = "post" action="<?=base_url()?>index.php/buildings/insertBuilding">

				<div class="form-group">

					<label class="col-sm-2 control-label" style="width: 100px;">Company Name</label>

					<div class="col-sm-10">

						<input type="text" name="name" id = "cname" class="form-control" placeholder="Company Name">

					</div>

					<label class="col-sm-2 control-label">Owner</label>

					<div class="col-sm-10">

						<input type="text" name="owner"  id = "cowner" class="form-control" placeholder="Owner">

					</div>

					<label class="col-sm-2 control-label">Phone</label>

					<div class="col-sm-10">

						<input type="text" name="phone" id = "cphone" class="form-control" placeholder="Phone">

					</div>

					<label class="col-sm-2 control-label" style="width: 100px;">Business No</label>

					<div class="col-sm-10" id="numbersOnly">

						<input type="text" name="business_no" id="cbusiness" class="form-control" placeholder="Business No">

					</div>


					<label class="col-sm-2 control-label">Fiscal No</label>

					<div class="col-sm-10"  id="numbersOnly" >

						<input type="text" name="fiscal_no" id="cfiscal" class="form-control" placeholder="Fiscal No">

					</div>

					<label class="col-sm-2 control-label">City</label>
					<select name="cityID" id = "cityID"  class="selection" style="width: 308px; margin: 1px 24px;">
							
							<?php

								foreach ($cities as $city) {

									echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';

								} 

							?>

					</select>	


					
				</div>
			</form>
		</div>
		</div>

		<div id="dialog_editCompany" style = "display:none;" title="Edit Company">
		  <div id="editCompany" >

			<form class="form-horizontal col-md-7" role="form"  method = "post" action="<?=base_url()?>index.php/buildings/insertBuilding">

				<div class="form-group">

					<label class="col-sm-2 control-label" style="width: 100px;">Company Name</label>

					<div class="col-sm-10">

						<input type="text" name="name" id = "edit_cname" class="form-control" placeholder="Company Name">

					</div>

					<label class="col-sm-2 control-label">Owner</label>

					<div class="col-sm-10">

						<input type="text" name="owner"  id = "edit_cowner" class="form-control" placeholder="Owner">

					</div>

					<label class="col-sm-2 control-label">Phone</label>

					<div class="col-sm-10">

						<input type="text" name="phone" id = "edit_cphone" class="form-control" placeholder="Phone">

					</div>

					<label class="col-sm-2 control-label" style="width: 100px;">Business No</label>

					<div class="col-sm-10" id="numbersOnly">

						<input type="text" name="business_no" id="edit_cbusiness" class="form-control" placeholder="Business No">

					</div>


					<label class="col-sm-2 control-label">Fiscal No</label>

					<div class="col-sm-10"  id="numbersOnly" >

						<input type="text" name="fiscal_no" id="edit_cfiscal" class="form-control" placeholder="Fiscal No">

					</div>

					<label class="col-sm-2 control-label">City</label>
					<select name="city_id" id = "edit_city_id"  class="selection" style="width: 308px; margin: 1px 24px;">
							
							<?php

								foreach ($cities as $city) {

									echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';

								} 

							?>

					</select>	


					
				</div>
			</form>
		</div>
		</div>

		<div id="dialog_addZone" style = "display:none;" title="Add Zone">
		  <div id="addZone" >

			<form class="form-horizontal col-md-7" role="form"  method = "post" action="<?=base_url()?>index.php/buildings/insertZone">

				<div class="form-group">

					<label class="col-sm-2 control-label" style="width: 100px;">Zone Name</label>

					<div class="col-sm-10">

						<input type="text" name="name" id = "name" class="form-control addzoneName"onkeypress="return noenter(event)" placeholder="Zone Name" >

					</div>
					
				</div>
			</form>
		</div>
		</div>

		

	</div>

</div>

<script type="text/javascript">

var lat = 42.6556;
var lon = 21.1597;

	$(document).ready(function () {

	

  	$('#tabs').tab();

		$('#cancel').click(function(event) {

		  event.preventDefault();

		  $('#add').find('input, select, textarea').val("");

		  $('#add').find('id').val("-1");

		  $('#add').find('form').first().attr('action', "<?=base_url()?>index.php/buildings/insert");

		});

  	$('.edit-data').click(function() {

  	document.getElementById("city").innerHTML = "";
  	document.getElementById("zone_id").innerHTML = "";

	 $.ajax({
                   type: "GET",
                   url: "<?=base_url()?>index.php/buildings/getZoneJson",
                   // data: "emp_Id =" + id,
                   success: function(result){
		var arr = JSON.parse(result);
                   	 $.each(arr, function(i, value) {  
	           $('<option></option>', {text:value.name}).attr('value', value.id).appendTo('#zone_id');
	           //console.log(value);
	  });
                   }
           });

	

 	$.ajax({
                   type: "GET",
                   url: "<?=base_url()?>index.php/buildings/getCityJson/",
                   // data: "emp_Id =" + id,
                   success: function(result){
		var arr = JSON.parse(result);
                   	 $.each(arr, function(i, value) {  
	           $('<option></option>', {text:value.name}).attr('value', value.id).appendTo('#city');
	  });
                   }
                 });

  	

    	$.post('<?=base_url()?>index.php/buildings/ajax/' + this.id, function(data){

      	$('a[href=#add]:first').attr('data-toggle', 'tab');

      	$('a[href=#add]').tab('show');

      	$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/buildings/edit");

      	$.each(data, function(key, value) {
      	 console.log("KEY:"+key + '  VALUE:'+value);
      	 if(key == 'lat') {
	      	 lat = value;
      	 }
      	 if(key == 'lon') {
	      	 lon = value;
      	 }
	  	 	
        	$('#add').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);
        	callMap();
        });      	

    	}, 'json');

    });

 	 	$('#add').find('form').first().validate({

			rules: {

		    name: {required: true, minlength:3}

		  }

		});    

  });

</script>


<script type="text/javascript">

		 //attach keypress to input
	            $('#numbersOnly').keydown(function(event) {
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


// window.onload = function() {

function callMap() {
    var latlng = new google.maps.LatLng(lat, lon);
    console.log(latlng);
    var iconBase = '<?=base_url()?>assets/images/';
    var map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 11,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: 'Set lat/lon values for this property',
        draggable: true,
        icon: iconBase + 'elevator.png'
    });

    google.maps.event.addListener(marker, 'dragend', function(a) {
        // console.log(a);
        $('#lat').val(a.latLng.lat().toFixed(4));
        $('#lon').val(a.latLng.lng().toFixed(4));

    });

     google.maps.event.addListener(map, 'mousemove', function (event) {
     google.maps.event.trigger(map, 'resize');
    });
    }
// };

</script>

 <script>
 function deleteBuilding(building_id){
 	   $(document).on("click", ".deleteBuilding", function(e) {
	            bootbox.confirm("<h4>Are you sure you want to delete this building ?</h4> <br/>By deleting this building all the entries and flat that are in this building will be deleted.", function(result) {
	           		if (result) {

				$.ajax({
			                       type: "POST",
			                       async: false,
			                       url: "<?=base_url()?>index.php/buildings/deleteBuilding/"+building_id+"",
			                       success: function(result){
						location.reload(false);
			                       }
			             }).done(function() {
					
				});

	           		} else{

	           		};		
	        
	            });
        });
 }
     
</script>