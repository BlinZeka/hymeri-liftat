<script>
	$("a[href='<?=base_url()?>index.php/companies']:first").find('.lm_box').attr("class", "lm_box_selected");
	$("#title_1").text("<?=$breadcrumb?>");
	 $(function() {
    

	    $( "#dateFrom" ).datepicker({
	    	dateFormat: 'yy-mm-dd'
	    });
	    $( "#dateTo" ).datepicker({
	    	dateFormat: 'yy-mm-dd'
	    });

	       $( "#dateFrom_checkin" ).datepicker({
	    	dateFormat: 'yy-mm-dd'
	    });
	    $( "#dateTo_checkin" ).datepicker({
	    	dateFormat: 'yy-mm-dd'
	    });

	  });

</script>


<div class="content_main">
	<ul class="nav nav-tabs nav-justified" data-tabs="tabs" id="tabs">
		<li class="active"><a href="#view" data-toggle="tab">View</a></li>
		
		<?php if($level != 1){ ?> 
		<li><a href="#add" data-toggle="tab">Add</a></li>
		<?php } ?>


	</ul>
	<div class="alert alert-success" id="pagesa_sukses" style="display:none">All Cards have been deactivated for this Entry</div>
	<div class="tab-content" style="padding-top: 20px;">
		<div id="view" class="tab-pane active">
			<table class="table table-striped datatable">
				<thead>
					<tr>
						<td>Name</td>
						<td>Created By</td>
						<td>Updated By</td>
						<td>Acs</td>
						<td<?php if($level == 4){ ?> style="display:none" <?php } ?>>#</td>
						<td<?php if($level == 4){ ?> style="display:none" <?php } ?>>#</td>
						<td<?php if($level == 4){ ?> style="display:none" <?php } ?>>#</td>
						<td<?php if($level == 4){ ?> style="display:none" <?php } ?>>#</td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ( $entries as $entry ) {


					?>
						<tr>
							<td><a style='color:#2C567E; text-decoration: underline;' href='<?=base_url();?>index.php/clients/flatsByEntry/<?=$entry->id ?>' ><?php echo $entry->name; ?></td>
							<td><?php echo $entry->created_by; ?></td>
							<td><?php echo $entry->updated_by; ?></td>
							<td><?php if ($entry->acs > 0) { ?>
								<img src = '<?=base_url()?>assets/images/active.png'>
								<?php
							} else { ?>
								<img src = '<?=base_url()?>assets/images/inactive.png'>
							<?php }
							 ?></td>

							<td><a href='#monitor' <?php if($level == 4){ ?> style="display:none" <?php } ?> data-toggle='tab' class='btn btn-xs btn-primary monitoro-data' id="<?php echo $entry->id; ?>">Monitor</a></td>
							<td><a <?php if($level == 4){ ?> style="display:none" <?php } ?> href='#checkin' data-toggle='tab' class='btn btn-xs btn-primary checkin-data' id="<?php echo $entry->id; ?>">Check in</a></td>
							<td><?php if ($level == 2 || $level == 3) { ?> <a class='btn btn-xs btn-warning edit-data' id='<?php echo $entry->id; ?>'>Edit</a> <?php } ?> </td>
							<td><?php if ($level == 2) { ?> <a class='btn btn-xs btn-danger delete-data' id='<?php echo $entry->id; ?>'>Delete</a> <?php } ?></td>
							<td><a class='btn btn-xs btn-primary deactivate-data' id='<?php echo $entry->id; ?>'>Deactivate All Cards</a></td>
								
						</tr>
				<?php }
				?>
			</tbody>
			</table>
		</div>

		<div id="add" class="tab-pane" >

			<div class="row">
			        <div class="col-md-6">

			<form class="form-horizontal col-md-7" role="form" action="<?=base_url()?>index.php/entries/insert" method="post" id = "registerIMEI" name ="registerIMEI">
				<input type="hidden" name="id" value="-1" />
				<input type="hidden" id = "buildingID" name="building_id" value="<?=$building_id?>" />
				<label style  = "color:red" id = "imeiExist"></label><br/>
				<label style  = "color:silver" id = "imeiiNFO"></label>
				<label style  = "color:red" id = "EntryExist"></label>

				
 				<div class="form-group">
					<label class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
						<input type="text" name="name" id= "EntryName" class="form-control" placeholder="Entry Name">
						
					</div>
					<label class="col-sm-2 control-label">IMEI</label>
					<div class="col-sm-10">
						<input type="text" id = "imei" name="imei"  class="form-control" placeholder="IMEI "> 
						
					</div>
					<label class="col-sm-3 control-label">Elevator Tel:</label>
					<div class="col-sm-10">
						<input type="text" name="phone_no"  class="form-control" placeholder="Tel Number "> 
						
					</div>
					<label class="col-sm-3 control-label">Notes:</label>
					<div class="col-sm-10">
						
						 <textarea class="form-control" rows="3" name = "notes" style = ""> </textarea>
					</div>
					
				</div>
				<!-- masaker -->
				<div id="elevators" class="form-group">

				</div>				
				<div class="form-group" >
					<div class="col-sm-offset-4 col-sm-10" >
						<button type="submit" class="btn btn-primary" style='margin: 1px 64px;' id = "saveEntriesConfiguration">Save</button>
						<button id="cancel" class="btn btn-warning" style='margin: 1px -45px;'>Clear</button>
					</div>
				</div>

			        </div>

			        <div class="col-md-5">
			        	<!-- <div class="row"><a class="btn btn-primary" id = "saveRelays" style='margin: 1px 60px;'>Save Relays</a></div> -->
			        	
			        	<?php if ($level == 2) { ?>
			        			<div class="panel-group" id="accordion">
						<?php  $rfid = 1;
						           for($i=1 ;$i<=16;$i++) {  ?>

							<div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#relay-<?=$i;?>" >
							          Relay <?=$i?>
							        </a>
							      </h4>
							    </div>
							    <div id="relay-<?=$i;?>" class="panel-collapse collapse">
							      <div class="col-md-4 panel-body ">
							      	<label>Emri: </label>
							      	<select class="form-control relayNr" name = "rfidName<?=$i?>"  id = "rfidName<?=$i?>"  style = "margin-left:10px;height:35px;" data-relayNr = "<?=$i?>">
							      		<option value = "20">Hyrje</option>
							      		<option value = "21">Garazhde</option>
							      		<option value = "22">Kabina</option>
							      		<option value = "23">Kati -2</option>
							      		<option value = "24">Kati -1</option>
							      		<option value = "0">Kati 0</option>
							      		<option value = "1">Kati 1</option>
							      		<option value = "2">Kati 2</option>
							      		<option value = "3">Kati 3</option>
							      		<option value = "4">Kati 4</option>
							      		<option value = "5">Kati 5</option>
							      		<option value = "6">Kati 6</option>
							      		<option value = "7">Kati 7</option>
							      		<option value = "8">Kati 8</option>
							      		<option value = "9">Kati 9</option>
							      		<option value = "10">Kati 10</option>
							      		<option value = "11">Kati 11</option>
							      		<option value = "12">Kati 12</option>
							      		<option value = "13">Kati 13</option>
							      		<option value = "14">Kati 14</option>
							      		<option value = "15">Kati 15</option>
							      		<option value = "16">Kati 16</option>
							      		<option value = "17">Vip 1</option>
							      		<option value = "18">Vip 2</option>
							      		<option value = "19" selected>None</option>

								</select>
								<br/>
							      	<div><label>Pulse Time: </label>  </div><span><input type="text" value = "3" name = "rfidPulse<?=$i?>" style = "width:50px;" id = "rfidPulse<?=$i?>" class="form-control pulseTime"/></span><span style="font-size:20px">sec</span> <br/> <br/><br/>
							      	<label><br>RFIDs: </label> <br/>
							      	<div>
							      		<div style="float:left;width: 300px;" >
										<input type="checkbox" name="rfid[]"  <?php if( $i==1 && $rfid == 1 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "1" >RFID 1<br>
										<input type="checkbox" name="rfid[]"  <?php if( $i==2 && $rfid == 2 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "2" >RFID 2<br>
										<input type="checkbox" name="rfid[]"  <?php if( $i==3 && $rfid == 3 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "3" >RFID 3<br>
										<input type="checkbox" name="rfid[]"  <?php if( $i==4 && $rfid == 4 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "4" >RFID 4<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==5 && $rfid == 5 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "5" >RFID 5<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==6 && $rfid == 6 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "6" >RFID 6<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==7 && $rfid == 7 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "7" >RFID 7<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==8 && $rfid == 8 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "8" >RFID 8<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==9 && $rfid == 9 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "9" >RFID 9<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==10 && $rfid == 10 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "10" >RFID 10<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==11 && $rfid == 11 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "11" >RFID 11<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==12 && $rfid == 12 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "12" >RFID 12<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==13 && $rfid == 13 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "13" >RFID 13<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==14 && $rfid == 14 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "14" >RFID 14<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==15 && $rfid == 15 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "15" >RFID 15<br>
										<input type="checkbox" name="rfid[]"   <?php if( $i==16 && $rfid == 16 ){ ?> checked <?php } ?> value="<?=$i?>" data-rfid = "16" >RFID 16<br>
									</div>
							      	</div>	
							      </div>
							    </div>
							  </div>

							<?php $rfid++;  ?>
						<?php }?>

						</div>
			        	<?php }?>
			        	
			        </div>
			        </form>
			</div>

		

		</div>
		




		<div id="monitor" class="tab-pane">
			<form class="form-horizontal col-md-7" role="form" action="<?=base_url()?>index.php/entries/insert" method="post">
				<input type="hidden" name="id" value="-1" />
				<input type="hidden" name="building_id" value="<?=$building_id?>" />
 				<div class="form-group">
					
					<label class="col-sm-2 control-label">IMEI</label>
					<div class="col-sm-10">
						<input type="text" name="imei" style="width:150px"  id= "imei_monitor" class="form-control imeiEntry" > 
					</div>

					<label class="col-sm-2 control-label" style=" width: 60px; margin: 3px 10px;">From</label>
				           <div class="col-sm-10">
				            	<input type="text" id="dateFrom" name="date" class="form-control"  style="width: 90px;">
				           </div>

				           <label class="col-sm-2 control-label" style=" width: 60px; margin: 3px 10px;">To</label>
				           <div class="col-sm-10">
				            	<input type="text" id="dateTo" name="date" class="form-control"  style="width: 90px;">
				           </div>

					
				</div>
				<!-- masaker -->
				<div id="elevators" class="form-group">

				</div>				
				<div class="form-group" >
					<div class="col-sm-offset-2 col-sm-10"  style="float:left;margin: 0px;">
						
						<input type= "button"  onClick = "return listCardsbyImei();" value = "Check" class="btn btn-primary" style=" width: 90px">
						<button href='#view' data-toggle='tab'  id="cancel" class="btn btn-warning" style='margin: 1px 15px;'>Cancel</button>
					</div>
				</div>
			</form>

			<div id="elevator_dataa" class="tab-pane active">

				<table class="table table-striped" id="elevator_data">

					<thead>

						<tr>

							<td>Time</td>

							<td >Cards</td>

						</tr>

					</thead>
					<tbody>

					</tbody>

					
				</table>

			</div>

		</div>


		<div id="checkin" class="tab-pane">
			<form class="form-horizontal col-md-7" role="form" action="<?=base_url()?>index.php/entries/insert" method="post">
				<input type="hidden" name="id" value="-1" />
				<input type="hidden" name="building_id" value="<?=$building_id?>" />
 				<div class="form-group">
					
					<label class="col-sm-2 control-label">IMEI</label>
					<div class="col-sm-10">
						<input type="text" name="imei" style="width:150px"  id= "imei_checkin" class="form-control imeiEntry" > 
					</div>

					<label class="col-sm-2 control-label" style=" width: 60px; margin: 3px 10px;">From</label>
				           <div class="col-sm-10">
				            	<input type="text" id="dateFrom_checkin" name="date" class="form-control"  style="width: 90px;">
				           </div>

				           <label class="col-sm-2 control-label" style=" width: 60px; margin: 3px 10px;">To</label>
				           <div class="col-sm-10">
				            	<input type="text" id="dateTo_checkin" name="date" class="form-control"  style="width: 90px;">
				           </div>

					
				</div>
				<!-- masaker -->
				<div id="elevators" class="form-group">

				</div>				
				<div class="form-group" >
					<div class="col-sm-offset-2 col-sm-10"  style="float:left;margin: 0px;">
						
						<input type= "button"  onClick = "return listCheckins();" value = "Check" class="btn btn-primary" style=" width: 90px">
						<button href='#view' data-toggle='tab'  id="cancel" class="btn btn-warning" style='margin: 1px 15px;'>Cancel</button>
					</div>
				</div>
			</form>

			<div id="elevator_dataa" class="tab-pane active">

				<table class="table table-striped" id="elevator_data_checkin">

					<thead>
						
						<tr>
							<td>Site Code</td>
							<td>Site Number</td>
							<td>Floor</td>
							<td >Time</td>
							<td >Validity</td>
						</tr>

						

					</thead>
					<tbody>
						
					</tbody>

					<tfoot>
					<!-- <tr>
							<th>Rendering engine</th>
							<th>Browser</th>
							<th>Platform(s)</th>
							<th>Engine version</th>
							<th>CSS grade</th>
						</tr> -->
					</tfoot>
				</table>

			</div>

		</div>


		


	</div>
</div>

<div id="elevator_holder" style="display: none;">
	<!-- <label class="col-sm-2 control-label">Card No.</label> --> 
	<label class="col-sm-2_control-label1">Imei</label> 

	<button class="btn_btn-default_2" id="remove" style='margin: -40px 230px; float: left;'>-</button>
</div>

<script type="text/javascript">
	


	function listCardsbyImei(){

		$.ajax({
		    type: 'POST',
		    url: "<?=base_url()?>index.php/entries/get_monitor/"+ $('#imei_monitor').val() +"/"+ $('#dateFrom').val() +"/"+ $('#dateTo').val() +"",
		    data: '',
		    dataType: "json",
		    success: function(resultData) {
		        $('#elevator_data').dataTable({
		            "aaData":  resultData,
		            aoColumns: [ { mData: 'time' },{ mData: 'description' } ],
		            "bDestroy": true,
		            "bJQueryUI": true,
		              "sDom": 'T<"clear">lfrtip',
		              "oTableTools": {
			// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
			"sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf"
		},
		            "bDeferRender": true,
		         
		        });
		    }
		});
	}

	function listCheckins(){

		var floor;
		$.ajax({
		    type: 'POST',
		    url: "<?=base_url()?>index.php/entries/get_checkins/"+ $('#imei_checkin').val() +"/"+ $('#dateFrom_checkin').val() +"/"+ $('#dateTo_checkin').val() +"",
		    data: '',
		    dataType: "json",
		    success: function(resultData) {
		        $('#elevator_data_checkin').dataTable({
		            "aaData":  resultData,
		         

		            aoColumns: [ { mData: 'siteCode' },{ mData: 'siteNo' } , 
		                  { mData: "floor",
		              	   "fnRender": function (oObj) {
			               var floor;
			                switch (oObj.aData.floor) {
					    case '20':
					        floor = "Hyrje";
					        break;
					    case '21':
					        floor = "Garazhde";
					        break;
					    case '22':
					        floor = "Kabina";
					        break;
					    case '23':
					        floor = "Kati -2";
					        break;
					    case '24':
					        floor = "Kati -1";
					        break;
					    case '0':
					        floor = "Kati 0";
					        break;
					    case '1':
					        floor = "Kati 1";
					        break;
					    case '2':
					        floor = "Kati 2";
					        break;
					        case '3':
					        floor = "Kati 3";
					        break;    
					        case '4':
					        floor = "Kati 4";
					        break;
					        case '5':
					        floor = "Kati 5";
					        break;
					        case '6':
					        floor = "Kati 6";
					        break;
					        case '7':
					        floor = "Kati 7";
					        break;
					        case '8':
					        floor = "Kati 8";
					        break;
					        case '9':
					        floor = "Kati 9";
					        break;
					        case '10':
					        floor = "Kati 10";
					        break;
					        case '11':
					        floor = "Kati 11";
					        break;
					        case '12':
					        floor = "Kati 12";
					        break;
					        case '13':
					        floor = "Kati 13";
					        break;
					        case '14':
					        floor = "Kati 14";
					        break;
					        case '15':
					        floor = "Kati 15";
					        break;
					        case '16':
					        floor = "Kati 16";
					        break;
					        case '17':
					        floor = "Vip 1";
					        break;
					        case '18':
					        floor = "Vip 2";
					        break;
					        case '19':
					        floor = "None";
					        break;

					}
			                    
			             	return floor;
		                }
		             },
		                  { mData: 'time' },
		                  { mData: "Valid" ,
		                 "fnRender": function (oObj) {
			                if(oObj.aData.Valid == 1){
			                	return "<img src = 'http://png-1.findicons.com/files/icons/1156/fugue/16/status.png'>";
			                }
			                    
			                else{
			                	var note = oObj.aData.note;
			                	// console.log(oObj.aData.note);
			                	 return "<img src = 'http://png-4.findicons.com/files/icons/1156/fugue/16/status_busy.png'>";   
			                }
		                }

		            }, ],
		            
		            "bDestroy": true,


		            
		            // "bJQueryUI": true,
		              // "sDom": 'T<"clear">lfrtip',
		              // "oTableTools": {
			// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
			// "sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf"
		// },
		            // "bDeferRender": true,
		         
		        });
		    }
		});
	}


	$(document).ready(function () {

		$('#registerIMEI').submit(function() {

			$form = $(this);

    			// alert('the action is: ' + $form.attr('action'));

    			var lastPart = $form.attr('action').split("/").pop();


    			if (lastPart == 'edit' ) {

    			} else{

	    			var flag = false;

		 		 $.ajax({
			                       type: "POST",
			                       async: false,
			                       url: "<?=base_url()?>index.php/entries/checkIMEI/"+$('#imei').val()+"",
			                       data: { building_id: $('#buildingID').val(), entry_name: $('#EntryName').val()},
			                       success: function(result){
			                       		var data  = JSON.parse(result);
			                       	

			                       		$('#imeiExist').html("");
			                       		$('#imeiiNFO').html("");
			                       		$('#EntryExist').html("");
			                       		if (data.statusi == 1) {
			                       			flag = true;
			                       			$('#imeiExist').html("This IMEI already exist.<br/>");
			                       			$('#imeiiNFO').html("Building : "+data.info[0].building+" </br>Entry: "+data.info[0].entry+"");
			                       		}  

			                       		if(data.statusi == 2){
			                       			flag = true;
			                       			$('#EntryExist').html("This entry already exist on this building.<br/>");	
			                       		}
			                       		if(data.statusi == 0){
			                       			flag = false;
			                       		};
// 			                       		console.log(data.statusi+" "+flag);
			                       		
			                       		
			                       }
			             });
		 		// return false;
		 		
			 	if(flag){
			 		return false;
			 	}

    			};
		 	
		});

		
		// $('.pulseTime').

		$('.pulseTime').on('change',function(){
		    if($(this).val()>99){
		    //put error span with nice css
		    alert("Accepted values from 1 to 99.");
		    $('.pulseTime').val("5");
		    return false;
		    }
		    });


		$('#relay-1')

		$('.myCheckbox').prop('checked', true);  

		$('#registerIMEI').submit(function(event) {
					var IMEI = $('#imei').val();

					var rfid1Name = $('#rfidName1').val();
					var rfid2Name = $('#rfidName2').val();
					var rfid3Name = $('#rfidName3').val();
					var rfid4Name = $('#rfidName4').val();
					var rfid5Name = $('#rfidName5').val();
					var rfid6Name = $('#rfidName6').val();
					var rfid7Name = $('#rfidName7').val();
					var rfid8Name = $('#rfidName8').val();
					var rfid9Name = $('#rfidName9').val();
					var rfid10Name = $('#rfidName10').val();
					var rfid11Name = $('#rfidName11').val();
					var rfid12Name = $('#rfidName12').val();
					var rfid13Name = $('#rfidName13').val();
					var rfid14Name = $('#rfidName14').val();
					var rfid15Name = $('#rfidName15').val();
					var rfid16Name = $('#rfidName16').val();

					var rfid1Pulse = $('#rfidPulse1').val();
					var rfid2Pulse =  $('#rfidPulse2').val();
					var rfid3Pulse = $('#rfidPulse3').val();
					var rfid4Pulse =  $('#rfidPulse4').val();
					var rfid5Pulse =  $('#rfidPulse5').val();
					var rfid6Pulse =  $('#rfidPulse6').val();
					var rfid7Pulse =  $('#rfidPulse7').val();
					var rfid8Pulse =  $('#rfidPulse8').val();
					var rfid9Pulse =  $('#rfidPulse9').val();
					var rfid10Pulse =  $('#rfidPulse10').val();
					var rfid11Pulse =  $('#rfidPulse11').val();
					var rfid12Pulse =  $('#rfidPulse12').val();
					var rfid13Pulse =  $('#rfidPulse13').val();
					var rfid14Pulse =  $('#rfidPulse14').val();
					var rfid15Pulse =  $('#rfidPulse15').val();
					var rfid16Pulse =  $('#rfidPulse16').val();


					var RFID1 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID2 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID3 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID4 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID5 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID6 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID7 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID8 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID9 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID10 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID11 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID12 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID13 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID14 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID15 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 
			  		var RFID16 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; 

			  $('#accordion input:checkbox').each(function () {
			  	
				   	if( $(this).is(":checked") ){
				   		// rez +='1';
				   		console.log("Relay: " + $(this).val() + " RFID: " +  $(this).attr("data-rfid") );
				   		console.log();
				   		if($(this).attr("data-rfid") == 1){
				   			RFID1[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 2){
				   			RFID2[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 3){
				   			RFID3[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 4){
				   			RFID4[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 5){
				   			RFID5[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 6){
				   			RFID6[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 7){
				   			RFID7[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 8){
				   			RFID8[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 9){
				   			RFID9[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 10){
				   			RFID10[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 11){
				   			RFID11[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 12){
				   			RFID12[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 13){
				   			RFID13[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 14){
				   			RFID14[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 15){
				   			RFID15[$(this).val()-1]  = 1;	
				   		}
				   		else if($(this).attr("data-rfid") == 16){
				   			RFID16[$(this).val()-1]  = 1;	
				   		}
				   		
				   	}else{
				   		// rez +='0';
				   	}

				  });
					
					

					RFID1.reverse();
					RFID2.reverse();
					RFID3.reverse();
					RFID4.reverse();
					RFID5.reverse();
					RFID6.reverse();
					RFID7.reverse();
					RFID8.reverse();
					RFID9.reverse();
					RFID10.reverse();
					RFID11.reverse();
					RFID12.reverse();
					RFID13.reverse();
					RFID14.reverse();
					RFID15.reverse();
					RFID16.reverse();

			   		 $.ajax({
				                       type: "POST",
				                       async:false,
				                       url: "<?=base_url()?>index.php/entries/configuration",
				                       data: {imei:IMEI, rfid1ToRelays:RFID1.join(""), rfid2ToRelays:RFID2.join(""), rfid3ToRelays:RFID3.join(""), rfid4ToRelays:RFID4.join(""), rfid5ToRelays:RFID5.join(""), rfid6ToRelays:RFID6.join(""), rfid7ToRelays:RFID7.join(""), rfid8ToRelays:RFID8.join(""), rfid9ToRelays:RFID9.join(""), rfid10ToRelays:RFID10.join(""), rfid11ToRelays:RFID11.join(""), rfid12ToRelays:RFID12.join(""), rfid13ToRelays:RFID13.join(""), rfid14ToRelays:RFID14.join(""), rfid15ToRelays:RFID15.join(""), rfid16ToRelays:RFID16.join(""), RFID1_Name: rfid1Name, RFID2_Name: rfid2Name, RFID3_Name: rfid3Name, RFID4_Name: rfid4Name, RFID5_Name: rfid5Name, RFID6_Name: rfid6Name, RFID7_Name: rfid7Name, RFID8_Name: rfid8Name, RFID9_Name: rfid9Name, RFID10_Name: rfid10Name, RFID11_Name: rfid11Name, RFID12_Name: rfid12Name, RFID13_Name: rfid13Name, RFID14_Name: rfid14Name, RFID15_Name: rfid15Name, RFID16_Name: rfid16Name, RFID1_tmr: rfid1Pulse, RFID2_tmr: rfid2Pulse, RFID3_tmr: rfid3Pulse, RFID4_tmr: rfid4Pulse, RFID5_tmr: rfid5Pulse, RFID6_tmr: rfid6Pulse, RFID7_tmr: rfid7Pulse, RFID8_tmr: rfid8Pulse, RFID9_tmr: rfid9Pulse, RFID10_tmr: rfid10Pulse, RFID11_tmr: rfid11Pulse, RFID12_tmr: rfid12Pulse, RFID13_tmr: rfid13Pulse,  RFID14_tmr: rfid14Pulse,  RFID15_tmr: rfid15Pulse,  RFID16_tmr: rfid16Pulse,  },
				                       success: function(result){
			  			console.log("success");
				                       	 
				                       }

					 });
			    });

		$('.monitoro-data').click(function(event) {
			
			 $.ajax({
			                       type: "POST",
			                       async:false,
			                       url: "<?=base_url()?>index.php/entries/getIMEI/"+ this.id +"",
			                       success: function(result){
		  			 var arr = JSON.parse(result);
		  			 $('.imeiEntry').val(arr[0].IMEI);
			                       	 
			                       }

			 });
		
		});

		$('.checkin-data').click(function(event) {
			
			 $.ajax({
			                       type: "POST",
			                       async:false,
			                       url: "<?=base_url()?>index.php/entries/getIMEI/"+ this.id +"",
			                       success: function(result){
		  			 var arr = JSON.parse(result);
		  			 $('.imeiEntry').val(arr[0].IMEI);
			                       	 
			                       }

			 });
		
		});



  	$('#tabs').tab();

		$('#remove').click(function(e){
			e.preventDefault();
			console.log(this.id);
			$(this).parent().remove();
		});
		
		$('#add-elevator').click(function(e){
			e.preventDefault();
			var copy = $('#elevator_holder').clone(true).css("display", "");
			$('#elevators').append(copy);
		});
  	
		$('#cancel').click(function(event){
		  event.preventDefault();
		  $('#add').find('input, select, textarea').val("");
		  $('#add').find('id').val("-1");
		  $('#add').find('form').first().attr('action', "<?=base_url()?>index.php/entries/insert");
		});
  	
	  	$('.edit-data').click(function() {
	    	// console.log(this.id);


	    				


	    		
	    		

		    	$.post('<?=base_url()?>index.php/entries/ajax/' + this.id, function(data){

				$.ajax({
			                       type: "POST",
			                       async:false,
			                       url: "<?=base_url()?>index.php/entries/getImeiConfiguration/"+data.IMEI+"",
			                       success: function(result){
		  			 var arr = JSON.parse(result);
		  			 console.log(arr);
		  			$('#rfidName1').val(arr[0].Relay1_Name);
		  			$('#rfidName2').val(arr[0].Relay2_Name);
		  			$('#rfidName3').val(arr[0].Relay3_Name);
		  			$('#rfidName4').val(arr[0].Relay4_Name);
		  			$('#rfidName5').val(arr[0].Relay5_Name);
		  			$('#rfidName6').val(arr[0].Relay6_Name);
		  			$('#rfidName7').val(arr[0].Relay7_Name);
		  			$('#rfidName8').val(arr[0].Relay8_Name);
		  			$('#rfidName9').val(arr[0].Relay9_Name);
		  			$('#rfidName10').val(arr[0].Relay10_Name);
		  			$('#rfidName11').val(arr[0].Relay11_Name);
		  			$('#rfidName12').val(arr[0].Relay12_Name);
		  			$('#rfidName13').val(arr[0].Relay13_Name);
		  			$('#rfidName14').val(arr[0].Relay14_Name);
		  			$('#rfidName15').val(arr[0].Relay15_Name);
		  			$('#rfidName16').val(arr[0].Relay16_Name);
		  		
		  			 

		  	// 		 var array = $.map(arr, function(value, index) {
					//     $('#rfidPulse'+i).val(value/10);
					// });

			                       	 
			                    	   }

		 		});

		      	$('#imei').val(data.IMEI);
		      	$.ajax({
				                       type: "POST",
				                       async:false,
				                       url: "<?=base_url()?>index.php/entries/getRelayTimer/1/"+data.IMEI+"",
				                       success: function(result){
			  			 var arr = JSON.parse(result);
			  			 // console.log(arr);
			  			 			  			 
				  			 var counter = 1;
				  			 	$.each(arr, function(key, value) { 
					  			 	$('#rfidPulse'+counter).val(value/10);
					  			 	counter++;
				  			 	});

				                       	 
				                       }

				 	});
		      	
		      	
		      	
		      	
		      		
/*				OLD KODE
		      		for (i = 1; i < 17; i++) { 
				   	 $.ajax({
				                       type: "POST",
				                       async:false,
				                       url: "<?=base_url()?>index.php/entries/getRelayTimer/"+i+"/"+data.IMEI+"",
				                       success: function(result){
			  			 var arr = JSON.parse(result);
			  			 // console.log(arr);

			  			 var array = $.map(arr, function(value, index) {
						    $('#rfidPulse'+i).val(value/10);
						});

				                       	 
				                       }

				 	});
				}
*/
		      		

		      	$('a[href=#add]:first').attr('data-toggle', 'tab');
		      	$('a[href=#add]').tab('show');

		      	$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/entries/edit");

		      	$.each(data, function(key, value) {
		      		// console.log(key + '->' + value.IMEI);
		        	$('#add').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);


		        });      	
		    	}, 'json');

	    		
	   	});

	    	$('.delete-data').click(function() {
	    		var id = this.id;
		    	bootbox.confirm("Are you sure you want to delete this entry? (Deleting this entry will delete all client  and cards which belongs to this entry).", function(result) {
					if(result){
						$.post('<?=base_url()?>index.php/entries/updateEntry/' + id, function(data){
					    	}, 'json');
					    	setTimeout(function() { document.location.reload(true);}, 1500);	
					}else{

					}
				  	
				}); 	
	    	
	 	  });

	    	$('.deactivate-data').click(function() {
	    	var id = this.id;
	    	bootbox.confirm("Are you sure you want to deactivate all cards on this entry?", function(result) {
					if(result){
						$.post('<?=base_url()?>index.php/entries/deactivateCardsForEntry/' + id, function(data){	
	    					}, 'json');
					    	$("#pagesa_sukses").show().delay(3000).fadeOut();	
					}else{

					}
				  	
				}); 	

	    	

	    	
	    	// setTimeout(function() { document.location.reload(true);}, 2000);	
	    	
	   	});


    
 	 	$('#add').find('form').first().validate({
			rules: {
			    name: {required: true, minlength:1},
			    imei: {required: true, minlength:13}
			  }
		});     
  });		
 		var toRelayNr = null;
 		var fromRelayNr = null;
		// Replacing relays access
		 $(".relayNr").change(function(){

		             floorValue = this.value;

		             toRelayNr = $(this).attr('data-relayNr');
		         
		            var flag = false;
		            for (var i = 1; i <=16; i++) {
		            	if(toRelayNr != i){
		            		var x = $("#rfidName"+i+" option:selected[value="+floorValue+"]").length > 0;
		            		if(x){
		            			console.log("RELAY: "+ i + " contains this value" + " from " + toRelayNr);
		            			fromRelayNr = i;
		            			flag = true;
		            		}
		            	}
		            };

		        });
	
	$('#registerIMEI').submit(function(e) { 
		console.log("toRelay "+toRelayNr);
		console.log("fromRelay "+fromRelayNr);
		var flag1 = 0;
		   $.ajax({
		                       type: "GET",
		                       async: false,
		                       url: "<?=base_url()?>index.php/cards/changeAccessConfigForAllCards/"+$('#imei').val()+"",
		                       success: function(result){
	  			 var arr = JSON.parse(result);
	  			 var newAccessConfig = [];
// 	  			 console.log(result);
	  			 $.each(arr, function(index, val) {
	  			 	// console.log("vlera 0 ne string eshte: "+val.access.charAt(0));
	  			 	if( val.access.charAt(16-fromRelayNr) == "1"){
	  			 		val.access = replaceAt(val.access, 16 - toRelayNr ,'1');
	  			 		newAccessConfig.push(val);
	  			 	}
	  			 	
	  			 	
	  			 });

// 		                      	console.log("accessconfigiarray: "+newAccessConfig);
		                       $.each(newAccessConfig, function(index, val) {
		                        		 $.ajax({
					                       type: "POST",
					                       async:false,
					                       url: "<?=base_url()?>index.php/cards/updateAccessConfig/"+val.id+"/"+val.access+"",
					                       success: function(result){
				  			
					                       }
				 		});
		                        	});
		                        	
// 		                        	console.log("1");
		                        	

		             if(arr.length < 1) { 
		  			 	 $('#imeiExist').html("This IMEI already exist.<br/>");
		  			 flag1
		  			 
		  			  setTimeout(function(){
		  			  	 location.reload();
		  			  	 
		  			  	 //do what you need here
				    	}, 10000);
		  			
		  			  } 
	
		            } // Result

			});
// 			return false; 

			
			if(flag1 == 1) {

				flag = 0;
				return false; 
			}

   
	});

	function replaceAt(s, n, t) {
	    return s.substring(0, n) + t + s.substring(n + 1);
	}

</script>