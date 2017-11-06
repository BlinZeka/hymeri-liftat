<script>
$("a[href='<?=base_url()?>index.php/clients']:first").find('.lm_box').attr("class", "lm_box_selected");
	// $("#title_1").text("<?=$breadcrumb?>");
	</script>

	<style>
	#feedback { font-size: 1.4em; }
	ol#selectable{width:995px;}
	li.ui-state-default{color:#2C567E;}
	li.paguar{background:#2A6496; color:white; font-family: 'Lato', sans-serif; }
	#selectable .ui-selecting { background: #FECA40; }
	#selectable .ui-selected { background: #F39814; color: white; }
	#selectable { list-style-type: none; margin: 0; padding: 0; width: 450px; }
	#selectable li { margin: 2px; padding: 1px; float: left; width: 74px; height: 80px; font-size: 1em; text-align: center; }
	.currentYear{
		font-size: 18px; 
		font-weight: bold;
	}
	.nextYear{
		font-size: 18px; 
		font-weight: bold;
	}

	.anch1 , .anch2 , .anch3 , .anch4, .anch5 , .anch6 , .anch7 , .anch8 , .anch9 , .anch10 , .anch11 , .anch12{ 
		line-height: 0px;
	}
	</style>


	<script type="text/javascript">
	$(document).ready(function(){

		$(".building").click(function(){
			$('.entry'+this.id).show();
		});


	});


	$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.entries').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"   
                $("div[class^='entry']").show();
            });
        }else{
            $('.entries').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});
	</script>


	<div class="content_main">
		<?php echo  $breadcrumb ?>
		<ul class="nav nav-tabs nav-justified" data-tabs="tabs" id="tabs">
			<li class="active"><a <?php if ($level == 4) { ?> style="display:none" <?php } ?> href="#view" id = "viewForm" data-toggle="tab">View</a></li>
			<?php if ($level == 2 || $level == 1 || $level == 3) { ?>
			<li><a href="#addAccessEntry" id = "addAccess" data-toggle="tab">Add Other Access</a></li>
			<?php }?>

			<li><a <?php if ($level == 4) { ?> style="display:none" <?php } ?> href="#add" id = "addForm" data-toggle="tab">Add Card</a></li>
		</ul>

		<div class="tab-content" style="padding-top: 20px;">
			<div id="view" class="tab-pane active">

				<table class="table table-striped">
					<thead>
						<tr>
							<td>Card No</td>
							<td>Site Code</td>
							<td>Site No</td>
							<td>VIP Floor</td>
							<td>Created by</td>
							<td>Updated by</td>
							<td>Expired Date</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<?php
				// echo $clientId;
						
						$status = array("0" => "Deactivated", "1" => "Activated");
						foreach ($cards as $card) {
							echo "<tr>
							<td>{$card->card_no}</td>
							<td>{$card->site_code}</td>
							<td>{$card->site_no}</td>
							<td>{$card->floor}</td>
							<td>{$card->created_by}</td>
							<td>{$card->updated_by}</td>
							<td>{$expired_date->p_to}</td>
							<td >
							<div class='pull-right'>";
							if ( $card->status == 0 ) {
								echo "<a class='btn btn-xs btn-danger status-data'  ' data-statusi = " .$card->status ." id='" . $card->elevator_card_id . "_".$card->status."'>".$status[$card->status]."</a>";
							} else {
								echo "<a class='btn btn-xs btn-primary status-data'  '  data-statusi = " .$card->status ." id='" . $card->elevator_card_id . "_".$card->status."'>".$status[$card->status]."</a>";
							}
							if($level != 4){
							echo "<a class='btn btn-xs btn-warning edit-data'  ' id='" . $card->id . "'><span class='glyphicon glyphicon-edit'></span> Edit</a>
							<a class='btn btn-xs btn-danger delete-data' id='" . $card->id . "'><span class='glyphicon glyphicon-remove'></span></a>";
							}
							echo "<button  id  = '" . $card->id . "'  class='btn btn-primary btn-xs cardIdAccess' data-toggle='modal' data-target='#accessModal'>View Access</button>
							<!--Give Access to one or more entries this card (works fine) ...  Warning:In edit Card dont show access floor cz once u change for one it will change for all access field, do better add it within this part in checkbox add another icon to edit access field-->
							<!--<a class='btn btn-xs btn-primary access-data'  ' id='" . $card->id . "'>access</span></a>-->



							</div>
							</td>
							</tr>";
					// redirect('./cards/index/1', 'refresh');
					// http://213.163.123.246/lift/index.php/cards/index/1
						}
						?>				
					</tbody>
				</table>

				<div style="float:right; margin: 20px 7px;">
					<a class='btn btn-sm btn-primary activateCards' id='<?=$clientId ?>'>Activate All</a>
					<a class='btn btn-sm btn-danger deActivateCards' id='<?=$clientId ?>'>Deactivate All</a>
				</div>

			</div>




			<div id ="addAccessEntry" class="tab-pane" >

				<div class="row">


					<div class="form-group">
						<label class="col-sm-1 control-label">Cards</label><br/><br/>
						<div style= "margin-left:-30px;margin-bottom:30px;"  id ="accessEntryCards" >
							<?php foreach ($cards as $key => $card): ?>
							<input type="checkbox" name="accessEntry[]" value="<?=$card->id?>"><?php  echo $card->site_code . '  '.$card->site_no?><br>
						<?php endforeach ?>
					</div>

					<div class="col-sm-2" >
						

						<label class="col-sm-1 control-label">Building</label>
						<select name="building_id" onChange ="return getEntries(this.value)" style = "margin-left:12px;width:200px;" id="buildingList">
							<option value = "0">Choose Building</option>
							<?php

							foreach ($buildingsList as $buildings) {

								echo '<option value='.$buildings['id'].'>'.$buildings['name'].'</option>';

							}

							?>

						</select>

					</div>

					
					
					<div class="col-sm-2">
						<label class="col-sm-1 control-label">Entry</label>
						<select name="entry_id" onClick="return showFloorAccess(this.value)" style = "margin-left:12px;width:200px;" id="entryList">

							<?php

								// foreach ($entriesList as $entries) {

								// 		echo '<option value='.$entries['id'].'>'.$entries['name'].'</option>';

								// }

							?>

						</select>

					</div>
					
					


					

				</div>	



			</div>
			<div class="row">

				

				<div class="col-sm-4" style="margin-top:30px;">
					<input type="checkbox" id="selecctall"/> Select All
					<hr>
					<!-- <label class="col-sm-6 control-label">Access floor</label> -->
					<div class="col-sm-12" style = "width:254px" id = "accessControl">


					</div>
				</div>
				
			</div>

			<button class = "btn btn-primary storeEntryAccess"  style = "float:left;margin-top:30px;" id = "">Save</button>
		</div>
		<div class= "row" style = "margin-top:100px">
			<div class="alert alert-success" id="accessControlSuccess" style="display:none">Access Controll has been succesfully given to the selected cards.</div>
		</div>


		<div id = "access_cards" style = "display:none;float:right;background:#C2C5BA">
			<button type="submit" id = "closeAccess" style="background:#F9473E;border:none;float:right" class="btn btn-primary">Close</button>
			<button class = "btn btn-danger access_cards" style="background:#009B27;border:none;float:right" id = "">Save</button>

			<br/><br/>	
			<span style=""><input type="checkbox" id="selecctall"/> Select All</span><br/>



			<?php 

			foreach ($companies as $company) {

								// echo '<input type="checkbox" class="checkbox">'.$company['name'].'</input>';

									      /* echo "<div >
										            <div ><strong>" .$company['name'] . "</strong></div>
										            </div>"; */
										            foreach ($buildings[$company['id']] as $building) {

									// echo '<input type="checkbox">'.$building['name'].'</input>';
										            	echo " <div  id ='".$building['id']."' class='building' style='margin-left:20px;cursor:pointer;color:#4B4E43'><strong>  " .$building['name'] . "</strong>  <img src= 'https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-down-b-16.png' >";

										            	foreach ($entries[$building['id']] as $entry) {
										            		echo "<div style='' class ='entry".$building['id'] . "'><input class = 'entries' id = " . $entry['elevatorID'] . " value= " . $entry['elevatorID'] . " name = 'entry' type='checkbox'>".$entry['name'] ."</input></div>";
										            	}
										            	echo "</div>";	
										            }

										        }
										        ?>
										    </div>



										    <div id="add" class="tab-pane">
										    	<form class="form-horizontal col-md-7" id="elevator_cards_insert" role="form" action="<?=base_url()?>index.php/cards/insert">
										    		<input type="hidden" name="client_id" value="<?=$client_id?>" /> 
										    		<input type="hidden" name="id" value="-1" />

										    		<input type="hidden" name="access" id="accessField" value = "" class="form-control" >
										    		<div class="form-group">
										    			<label class="col-sm-2 control-label">Site Code</label>
										    			<div class="col-sm-10">
										    				<input type="text" name="site_code" id = "site_code" onchange="handleChange(this);" class="form-control" maxlength="3">
										    			</div>
										    		</div>
										    		<div class="form-group">
										    			<label class="col-sm-2 control-label">Site No</label>
										    			<div class="col-sm-10">
										    				<input type="text" name="site_no" id = "site_no" onchange="handleChange2(this);" class="form-control" maxlength="5">
										    			</div>
										    		</div>

			<!-- 	<div class="form-group">
					<label class="col-sm-2 control-label">Vip Floor</label>
					<div class="col-sm-10">
						<select name="floors" id = "companies" onChange ="return getBuildings(this.value)" class="selection" style="width: 210px;">
							<OPTION value = "1">Lift</OPTION>
							<OPTION value = "2">Dera Hyrjes</OPTION>
							<OPTION value = "3">Lift, Dera Hyrjes</OPTION>
							<OPTION value = "4">Lift, Vip,Dera Hyrjes</OPTION>
							<OPTION value = "5">Lift, Vip,Dera Hyrjes,Dera Garazhes</OPTION>
							<OPTION value = "6">Lift, Vip,Dera Hyrjes,Dera Garazhes,Kati -1</OPTION>
						</select>	
					</div>
				</div> -->

				

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10" style='width: 170px; float: right;'>
						<button type = "submit" class="btn btn-primary"  id ="accessCardBtn">Save</button>
						<button id="cancel" class="btn btn-warning" >Pastro</button>
					</div>
				</div>



				<div class="form-group">

					<div class=" control-label">Access</div><br/>

					<input type="checkbox" id = "checkAll"  value="1">Select All<br>
					<div class="" id = "accessCard" style='width: 600px;float:left'>
						
						<hr>
						<div style="float:left;width: 300px;" >
							<?php 

							$relayNames = array('20' =>'Hyrje',  '21' =>'Garazhde',  '22' =>'Kabina',  '23' =>'Kati -2',  '24' =>'Kati -1',  '0' =>'Kati 0',  '1' =>'Kati 1',  '2' =>'Kati 2',  '3' =>'Kati 3',  '4' =>'Kati 4',  '5' =>'Kati 5',  '6' =>'Kati 6',  '7' =>'Kati 7',  '8' =>'Kati 8',  '9' =>'Kati 9',  '10' =>'Kati 10',  '11' =>'Kati 11',  '12' =>'Kati 12',  '13' =>'Kati 13',  '14' =>'Kati 14',  '15' =>'Kati 15',  '16' =>'Kati 16',  '17' =>'Vip 1',  '18' =>'Vip 2',  '19' =>'None');
							$configurimi = "";
							if(!empty($floors)){

								for ($i = 1 ; $i<=16; $i++) { 
									$field = 'Relay'.$i.'_Name'; 
									if( $floors[0]->$field != 19){ ?>
									<input type="checkbox" name="accessi[]" class = "accessi" value="1"><?php echo $relayNames[$floors[0]->$field];?><br>
									<?php $configurimi .="1"; ?>
									<?php }else{ ?>
									<div style = "display:none">
										<input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br>
										<?php echo  $configurimi .="0"; ?>
									</div>
									<? }?>
									
									<?php } ?>

									<?php }else{
										echo " <div style = 'color:red'>This Elevator is not configured yet. Please configure first the elevator.</div>";
									} ?>

									<input type = "hidden" name="conf" value ="<?php echo strrev($configurimi) ;?>">
								</div>

							</div>
							<!-- <a  class="btn btn-primary" id ="accessCardBtn">Calculate</a> -->

						</div>


					</form>

				</div>


			</div>



			<div class="table-responsive">
				<table class="table">
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>


			<div id = "pagesatVjetore" >



			</div>

			<div id="payment_cancel" style = "display:none" title="Cancel Payment">
				<br/><br/>
				<label>Why you Canceling the payment?</label>
				<textarea class="form-control" rows="8" id = "cancel_pay"  name = "comment" style = "width:380px"> </textarea>
			</div>

			<form action="../insertNotes/<?=$this->uri->segment(3)?>" method="post">
				<div class="panel panel-default" id = "notes" style = "width:600px;">
					<div class="panel-heading" style = "margin:10px;">Notes</div>
					<div class="panel-body">
						<div style = "margin-left:10px;">


							<?php foreach ($notes as $key => $note): ?>
							<div class="alert alert-danger ">

								<?php if ($note->created_by == $user_id || $user_id == 3): ?>
								<div style = "float:right;margin:5px;" ><strong><a class="deleteNote" onClick = "return deleteNote(<?=$note->id ?>)"  href="">x</a></strong></div>
							<?php endif ?>
							<h5><?=$note->admin ?>:</h5> <?= nl2br($note->comment) ?>.
						</div>
					<?php endforeach ?>


				</div>


				<textarea class="form-control" rows="3" name = "comment" style = "width:530px"> </textarea>
				<button type="submit" class="btn btn-primary" style = "margin: 9px 9px;">Comment</button>


			</div>
		</div>
	</form>

	<div class="content_main2"  style = "margin: 40px -5px; width: 99%;">
		<input type="hidden" value = "<?=$clientName;?>" id="clientNamePrint" >
		<input type="hidden" value = "<?=$clientBuilding;?>" id="clientBuildingPrint" >
		<input type="hidden" value = "<?=$clientEntry;?>" id="clientEntryPrint" >

		<ul class="nav nav-tabs nav-justified" data-tabs="tabs" >
			<!-- <li class="active"><a href="#viewPayment" data-toggle="tab">Payments</a></li> -->
			<li><a href="#addPayment" data-toggle="tab">Payment</a></li>
		</ul>

		<div class="tab-content" style="padding-top: 20px;">



			<div style = "border-bottom:1px solid black;width:150px;">
				<label id = "total" style = "margin-top:20px;">Total: <span class="price"></span></label>
			</div>
		</div>

		<div id="addPayment" class="tab-pane  active">

			<div class="payments-table" style='width: 50%;'>

				<div class="form-group">

					<div class="form-group">

						

						<div class="col-sm-10">

							<input type="hidden" id="client_id_payment" value = "<?php echo $client_id; ?>" name="client_id" class="form-control">

						</div>

					</div>

				</div>


				<?php if ($ClientNotefromEntry[0]->notes != '0') {
					echo "<label style = 'color:#D9120D' >". $ClientNotefromEntry[0]->notes . "</label><br/><br/>";
				} else {
					echo "";
				}
				?>

				
				<div id = "paymentHolder">

					<div class="form-group" id = "currentYearHolder">
						<div class="col-sm-12">
							<div>
							<select style="" id="currentYear" name="currentYear">
									<option selected><?php $date =  strtotime(date("Y"));  $currentYear = (int)date('Y', $date)-1; echo $currentYear;?></option>
<!-- 									<option><?php $date =  strtotime(date("Y"));  $currentYear = (int)date('Y', $date); echo $currentYear;?></option> -->
								</select>
								<input type="hidden" id="h_value" name="h_value" value="<?php echo $client_id; ?>">
							</div>

							<table >
								<thead>
									<tr>
										<td align="center" class="anch1">
											
											January
										</td>
										<td align="center" class="anch2">
										  
											February
										</td>
										<td align="center" class="anch3">
											March
										</td>
										<td align="center" class="anch4">
											Aprill
										</td>
										<td align="center" class="anch5">
											May
										</td>
										<td align="center" class="anch6">
											June
										</td>
										<td align="center" class="anch7">
											July
										</td>

										<td align="center" class="anch8">
											August
										</td>

										<td align="center" class="anch9">
											September
										</td>

										<td align="center" class="anch10">
											October
										</td>

										<td align="center" class="anch11">
											November
										</td>

										<td align="center" class="anch12">
											December
										</td>

									</tr>
								</thead>
								<tbody>
									<tr>
										<?php
										$muajt = array();
										$muajt[1] = "";
										$muajt[2] = "";
										$muajt[3] = "";
										$muajt[4] = "";
										$muajt[5] = "";
										$muajt[6] = "";
										$muajt[7] = "";
										$muajt[8] = "";
										$muajt[9] = "";
										$muajt[10] = "";
										$muajt[11] = "";
										$muajt[12] = "";

										$paymentDate = array();
										$paymentDate[1] = "";
										$paymentDate[2] = "";
										$paymentDate[3] = "";
										$paymentDate[4] = "";
										$paymentDate[5] = "";
										$paymentDate[6] = "";
										$paymentDate[7] = "";
										$paymentDate[8] = "";
										$paymentDate[9] = "";
										$paymentDate[10] = "";
										$paymentDate[11] = "";
										$paymentDate[12] = "";

										
										foreach ($getPaymentsCurrentYear as $key => $value) {
											$muajt[$value['month']] = $value['paid'];
											$paymentDate[$value['month']] = $value['date'];

										}

										for ($i=1; $i <= count($muajt) ; $i++) { ?>
										<td> <?php $currentYear = (int)date('Y', $date)-1; ?>
											<?php if($muajt[$i] != ""){ ?><span style="margin-left:65px"><a style="cursor: pointer;" class="delete_payment-data" yeardelete="<?php echo $currentYear; ?>" id="<?php echo $i; ?>"><?php if($level == 2 || $level == 1){ echo "x"; } ?></a></span><?php } else{?> <span style = "color:white"> x </span><?php }?> <input type= "text"  <?php if($muajt[$i] != ""){ ?> disabled="true" <?php }else{echo "";}?>  value = "<?=$muajt[$i]?>" style = "height:75px;width:60px; font-size:14px" class = "<?php echo $currentYear; ?>" name="" id = "month<?=$i?>" data-month="<?=$i?>" data-year="<?php $date =  strtotime(date("Y")); echo $currentYear;?>">
										</td>
										<?php }
										?>

									</tr>

									<tr>

										<td class="month1"></td>
										<td class="month2"></td>
										<td class="month3"></td>
										<td class="month4"></td>
										<td class="month5"></td>
										<td class="month6"></td>
										<td class="month7"></td>
										<td class="month8"></td>
										<td class="month9"></td>
										<td class="month10"></td>
										<td class="month11"></td>
										<td class="month12"></td>


									</tr>
									<tr>
										<?php
										for ($i=1; $i <= count($paymentDate)  ; $i++) { ?>
										<td><?=$paymentDate[$i]?></td>
										<?php }
										?>

									</tr>

								</tbody>


							</table>

						</div>
					</div>


					
					<div class="form-group"  id = "nextYearHolder">
						<div class="col-sm-12" style="margin-top:60px;">
							<div><?php $nextYear = $currentYear+1; ?>
								<select style="" id = "nextYear">
									<option><?php $date =  strtotime(date("Y"));  $currentYear = (int)date('Y', $date); echo $currentYear;?></option>
								</select>
							</div>

							<table >
								<thead>
									<tr> 
										<td align="center">
											January
										</td> 
										<td align="center">
											February
										</td> 
										<td align="center">
											March
										</td> 
										<td align="center">
											Aprill
										</td> 
										<td align="center">
											May
										</td> 
										<td align="center">
											June
										</td> 
										<td align="center">
											July
										</td> 

										<td align="center">
											August
										</td> 

										<td align="center">
											September
										</td> 

										<td align="center">
											October
										</td> 

										<td align="center">
											November
										</td> 

										<td align="center">
											December
										</td> 

									</tr>
								</thead>
								<tbody>
									<tr>
										<?php  
										$muajt = array();
										$muajt[1] = "";
										$muajt[2] = "";
										$muajt[3] = "";
										$muajt[4] = "";
										$muajt[5] = "";
										$muajt[6] = "";
										$muajt[7] = "";
										$muajt[8] = "";
										$muajt[9] = "";
										$muajt[10] = "";
										$muajt[11] = "";
										$muajt[12] = "";

										$paymentDate = array();
										$paymentDate[1] = "";
										$paymentDate[2] = "";
										$paymentDate[3] = "";
										$paymentDate[4] = "";
										$paymentDate[5] = "";
										$paymentDate[6] = "";
										$paymentDate[7] = "";
										$paymentDate[8] = "";
										$paymentDate[9] = "";
										$paymentDate[10] = "";
										$paymentDate[11] = "";
										$paymentDate[12] = "";

										foreach ($getPaymentsNextYear as $key => $value) {
											$muajt[$value['month']] = $value['paid'];
											$paymentDate[$value['month']] = $value['date'];
										}

										for ($i=1; $i <= count($muajt) ; $i++) {  ?>
										<td>	
											<?php $currentYear = (int)date('Y', $date); ?> 
											<?php if($muajt[$i] != ""){ ?><span style="margin-left:65px">
<!-- 											<a href="<?=base_url()?>index.php/payments/deletePayment/<?=$currentYear+1?>/<?=$i?>/<?=$clientId?>"> <?php if($level == 2){ echo "x"; } ?></a> -->
												<a style="cursor: pointer;" class="delete_payment-data" yeardelete="<?php echo $currentYear; ?>" id="<?php echo $i; ?>"><?php if($level == 2 || $level == 1){ echo "x"; } ?></a>
											</span><?php } else{ ?> <span style = "color:white"> x </span><?php }?> <input type= "text"  <?php if($muajt[$i] != ""){ echo "disabled";}else{echo "";}?>  value = "<?=$muajt[$i]?>" style = "height:75px;width:60px;font-size:14px" class = "<?php echo $currentYear; ?>" name="" id = "month<?=$i?>" data-month="<?=$i?>" data-year="<?php $date =  strtotime(date("Y")); echo $currentYear;?>">
										</td>	
										<?php }
										?>

									</tr>
									<tr>
										<?php
										for ($i=1; $i <= count($paymentDate)  ; $i++) { ?>
										<td><?=$paymentDate[$i]?></td>
										<?php }
										?>

									</tr>


								</tbody>
								<tfoot>

								</tfoot>


							</table>

						</div>
					</div>

				</div>
				

				

				<div class="form-group" style = "margin-bottom:20px">
					<label class="col-sm-2 control-label" style='margin: 3px 2px;width:360px;margin-top:30px;'>Card Validity</label>
					<div class="col-sm-3">

						<label class="col-sm-6 control-label" style='margin: 1px 2px; float:left;margin-top:20px'>From</label>
						<input type="text" id="fromDate2" name="date" class="form-control">

					</div>

					<div class="col-sm-3">
						<label class="col-sm-6 control-label" style='margin: 1px 2px; float:left;margin-top:20px'>To</label>
						<input type="text" id="toDate2" name="date" class="form-control">

					</div>

				</div>



				<div class="form-group" >

					<label class="col-sm-2 control-label" style='margin: 1px 12px; width: 200px;'>Payments Note</label>

					<div class="col-sm-10">

						<input type="text" style = "width: 278px;" id = "faturuar" disabled value= "<?php echo $monthly_price[0]['monthly_price']; ?>" name="faturuar" class="form-control">

					</div>

				</div>

				<div class="form-group"  style = "margin-left:10px;">

					<label class="col-sm-2 control-label" style='margin: 3px 2px;width:360px;margin-top:30px;'>Payment Valute</label>

					<div class="col-sm-3" name= "valute" >
						<select id="valute">
							<option value="1">EUR</option>
							<option value="2">LEK</option>
						</select>

					</div>

				</div>


				<div class="col-sm-offset-2 col-sm-10" style='style="float: right; width: 6%;'>

					<button style = "margin-left: -32px;margin-top: 10px;" id="submit" type="submit" onClick="return paguaj()" class="btn btn-primary">Ruaje</button>

				</div>

			</div>

			<div class="form-group">

				<div class="col-sm-10">

					<div class="alert alert-success" id="pagesa_sukses" style="display:none">Payment has been made sucessfully.</div>

				</div>

			</div>

			<div class="form-group">

				<div class="col-sm-10">

					<div class="alert alert-danger" id="pagesa_josukses" style="display:none">Payment has not been sucessfully.</div>

				</div>

			</div>


		</div>
		<div class="alert alert-success" id="pagesa_sukses" style="display:none">Pagesa u kry me sukses</div>

		<!-- Modal -->
		<div class="modal fade" id="accessModal" data-backdrop = "false" tabindex="-1" role="dialog" style = "margin-top:50px" aria-labelledby="accessModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="accessModalLabel">Entry Access</h4>
					</div>
					<div class="modal-body" >

						<div style="width:480px;margin-top:30px;margin-left:14px">
							<ul class="media-list accessCardEntryList"></ul>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

	</div>




</div>


<script>
var cardID = null;
$(document).ready(function($) {

	$('.cardIdAccess').click(function(event) {

		cardID = this.id;
		$('.accessCardEntryList').empty();
		var flag = true;
		$.ajax({
			type: "POST",
			async: false,
			url: '<?=base_url()?>index.php/cards/getCardAccess/'+cardID+'',
			data: '',
			success: function (result) {
				var arr = JSON.parse(result);
				$.each(arr, function(index, val) {
					if (flag) {
						$('.accessCardEntryList').append('<li class="list-group-item">'+val.buildingName+' -> '+val.entryName+' </li>');
					} else{
						$('.accessCardEntryList').append('<li class="list-group-item">'+val.buildingName+' -> '+val.entryName+' <a href = "#"><span id = "'+val.entryId+'" class="glyphicon glyphicon-remove removeAccessCardEntryList"  onClick="return deleteAccessCard(this.id)"  style = "float:right"></span></a></li>');

					};
					flag = false;
				});

			}
		});
	});

	
	
});


function deleteAccessCard(id){
	var entryID = id;
	$('.accessCardEntryList').empty();
	var flag = true;
	$.ajax({
		type: "POST",
		async: false,
		url: '<?=base_url()?>index.php/cards/deleteCardAccess/'+entryID+'/'+cardID+' ',
		data: '',
		success: function (result) {
			var arr = JSON.parse(result);
			$.each(arr, function(index, val) {
				if (flag) {
					$('.accessCardEntryList').append('<li class="list-group-item">'+val.buildingName+' -> '+val.entryName+' </li>');
				} else{
					$('.accessCardEntryList').append('<li class="list-group-item">'+val.buildingName+' -> '+val.entryName+' <a href = "#"><span id = "'+val.entryId+'" class="glyphicon glyphicon-remove removeAccessCardEntryList"  onClick="return deleteAccessCard(this.id)"  style = "float:right"></span></a></li>');
					
				};
				flag = false;
			});

		}
	});
}

function paguaj(){

	var fromDate = $('#fromDate2').val().length;
	var toDate = $('#toDate2').val().length;

	if(fromDate > 5 && toDate > 5) {
		
		$("#paymentHolder :text:not(:disabled)").each(function(){

			if ($(this).val() != '') {
				
				

				var whichYear = $(this).attr("class");
/*
				if (whichYear == 'currentYear') {
					var yearSelected = <?php echo $currentYear; ?>;
				}
				if(whichYear == 'nextYear') {
					var yearSelected = <?php echo $nextYear; ?>;
				}
*/

				
				
				console.log(whichYear);
				var payment_attribute = { paid: $(this).val(),client_id:$('#client_id_payment').val(), from:$('#fromDate2').val(),to:$('#toDate2').val(), month: $(this).attr('data-month') ,year: whichYear, valute: $('#valute').val() }

	
	

				$.ajax({
					type: "POST",
					async: false,
					url: '<?=base_url()?>index.php/payments/addPayment/',
					data: payment_attribute, 
					success: function (result) {
						$('#pagesa_sukses').fadeTo('slow/400/fast', 1, function() {
	
						});
						window.location.reload(1);
/*
						setTimeout(function(){
							window.location.reload(1);
						}, 2000);
*/
	
					}
				});

	
	
			} 


	});
	}
	else {
				alert("Please fill out the Dates");
				return false;
	}
	

}

$(function() {
	
	$('#fromDate2').val("");
	$('#toDate2').val("");
	
	$( "#fromDate2" ).datepicker({
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
        $( "#toDate2" ).datepicker( "option", "minDate", selectedDate );
      }
	});
	$( "#toDate2" ).datepicker({
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
        $( "#fromDate2" ).datepicker( "option", "maxDate", selectedDate );
      }
	});
});
</script>


<script type="text/javascript">
$(document).ready(function () {

		    $('#checkAll').click(function(event) {  //on click 
		        if(this.checked) { // check select status
		            $('.accessi').each(function() { //loop through each checkbox
		            	if (!this.disabled) {
		            		  this.checked = true;  //select all checkboxes with class "checkbox1"         
		            		}
		            	});
		        }else{
		            $('.accessi').each(function() { //loop through each checkbox
		                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
		            });         
		        }
		    });




		    var rez = "";	
		    $('#accessCardBtn').click(function(event) {
		    	/* Act on the event */
		    	rez = "";	
		    	$('#accessCard input:checkbox').each(function () {

		    		if( $(this).is(":checked") ){
		    			rez +='1';
		    		}else{
		    			rez +='0';
		    		}

		    	});

		    	rez =   rez.split("").reverse().join("");

		    });

		    $('#elevator_cards_insert').submit(function()
		    {
		    	$('#accessField').val(rez);
			 // console.log("final sent: "  + rez);
			 // return false;

			});


		 //attach keypress to input
		 $('.form-group').keydown(function(event) {
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


		 $('.status-data').click(function(event) {
		 	var id = $(this).attr('data-statusi');
		 	if (id == 0) { $(this).attr('data-statusi','1') ;$(this).css("background-color",'#357EBD');}
		 	else if  (id == 1) {  $(this).attr('data-statusi','0'); $(this).css("background-color",'#d2322d');}
		 });

		 $('#tabs').tab();

		 var status = {"1": "Activated", "0": "Deactivated"};

		 $('#cancel').click(function(event){
		 	event.preventDefault();
		 	$('#add').find('input, select, textarea').val("");
		 	$('#add').find('id').val("-1");
		 	$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/cards/insert");
		 });

		 $('.status-data').click(function(){
		 	var bid = this.id;
		 	var id = this.id.split("_")[0];
		 	var st = this.id.split("_")[1] == "1" ? "0" : "1";

		 	$.post("<?=base_url()?>index.php/cards/status/" + id + "/" + st, function(data){
		 		$('#' + bid).text(status[st]).attr("id", id + "_" + st);
		 	});
		 });

		 $('#viewForm').click(function(event) {
		 	$('#pagesatVjetore').show();
		 	$('#notes').show('slow/400/fast', function() {

		 	});		
		 	$('.content_main2').show('slow/400/fast', function() {

		 	});
		 });

		 $('#addForm').click(function(event) {
		 	$('#pagesatVjetore').hide();
		 	$('#notes').hide('slow/400/fast', function() {

		 	});	
		 	$('.content_main2').hide('slow/400/fast', function() {

		 	});
// 		 	console.log("asdasdasd");

		 });

		 $('#addAccess').click(function(event) {
		 	$('#pagesatVjetore').hide();
		 	$('#notes').hide('slow/400/fast', function() {

		 	});	
		 	$('.content_main2').hide('slow/400/fast', function() {

		 	});
		 });


		 $('.edit-data').click(function() {




		 	$('#accessCard').find(':checked').each(function() {
		 		$(this).removeAttr('checked');
		 	});


		 	$('#pagesatVjetore').hide();
		 	$.post('<?=base_url()?>index.php/cards/ajax/' + this.id, function(data){
		 		$('a[href=#add]:first').attr('data-toggle', 'tab');
		 		$('a[href=#add]').tab('show');


		 		$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/cards/edit");
		 		$.each(data, function(key, value) {
		 			$('#add').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);
		 		});      	
		 	}, 'json');

		 	$.ajax({
		 		type: "POST",
		 		async: false,
		 		url: '<?=base_url()?>index.php/cards/getAccess/' + this.id,
		 		data: '',
		 		success: function (result) {
		 			var data = $.parseJSON(result);
		 			console.log(data);

		 			for (var i = 0, len =data[0].access.length; i < len; i++) {
		 				if (data[0].access[i] == 1) {
		 					$('.accessi').eq(i).prop('checked', true);
		 				};
		 			}           		
		 		}
		 	});

		 });

$('.delete-data').click(function() {

	var r=confirm("Are you sure you want to delete this record?");
	if (r==true) {
// 	console.log(this.id);

		$.ajax({
			type: "POST",
			async: false,
			url: '<?=base_url()?>index.php/cards/deleteClientUpdate/' + this.id,
			data: '',
			success: function (result) {
				location.reload();	
			}
		});


	}
	else  {

	}

});

$('.delete_payment-data').click(function() {
	var id = this.id;
// 	var yearID = <?php echo $currentYear; ?>;
	var yearID = $(this).attr('yeardelete');
	var clientID = <?php echo $clientId; ?>;
	
	$( "#payment_cancel" ).dialog({
		resizable: false,
		height:340,
		width:440,
		modal: true,
		buttons: {
			"Confirm": function() {
				var len = $('#cancel_pay').val().length;
				if(len > 4) {
					
				$.ajax({
					"dataType": "text",
					"type": "POST",
					"data": {"coment":$('#cancel_pay').val()},
					"url": "<?=base_url()?>index.php/payments/deletePayment/" + yearID +"/"+id+"/"+clientID,
					"beforeSend": function (msg) {
						console.log(id+" "+yearID+" "+clientID);
					},
					"success": function (msg) {

						$('#cancel_pay').val('');
						window.location.reload();
						
					},
					"error": function (msg) {
						$('#cancel_pay').val('');
						//console.log("1-error!");
					}
				}).done(function (msg) {
					$('#cancel_pay').val('');
					//console.log("1-done!");
				});
					
					
					
				}				

			

			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});






$('.activateCards').click(function() {


	$.ajax({
		"dataType": "text",
		"type": "POST",
		"data":  "asd" ,
		"url": "<?=base_url()?>index.php/cards/activateAll/"+this.id+" ",
		"beforeSend": function (msg) {
			console.log("1-sending...");
		},
		"success": function (msg) {
			console.log("1-success!");
			document.location.reload(true);
		},
		"error": function (msg) {
			console.log("1-error!");
		}
	}).done(function (msg) {
		console.log("1-done!");
	});

});

$('.deActivateCards').click(function() {



	$.ajax({
		"dataType": "text",
		"type": "POST",
		"data":  "asd" ,
		"url": "<?=base_url()?>index.php/cards/deActivateAll/"+this.id+" ",
		"beforeSend": function (msg) {
			console.log("1-sending...");
		},
		"success": function (msg) {
			console.log("1-success!");
			document.location.reload(true);
		},
		"error": function (msg) {
			console.log("1-error!");
		}
	}).done(function (msg) {
		console.log("1-done!");
	});



});


$('#add').find('form').first().validate({
	rules: {
		site_code: {required: true, minlength:1},
		site_no: {required: true, minlength:1}
	}
});     
});

$('#site_code').jStepper({minValue:0, maxValue:255});
$('#site_no').jStepper({minValue:0, maxValue:65535});




</script>

<script>
$(function() {
	var months = [];

	$( "#selectable" ).selectable({
		stop: function() {
			months.length = 0;
			$( ".ui-selected", this ).each(function() {
				var index = $( "#selectable li" ).index( this );
				months.push(index + 1);
			});
		}

	});

	$('#print').click(function(event) {

		for (var i = months.length - 1; i >= 0; i--) {


			$.ajax({
				"dataType": "text",
				"type": "POST",
				"data": {client_id:<?php echo $client_id; ?>,month: months[i]} ,
				"url": "<?=base_url()?>index.php/payments/addPayment",
				"beforeSend": function (msg) {
				                    // console.log("1-sending...");
				                },
				                "success": function (msg) {
				                  // console.log("1-success!");
				                  setTimeout(function() { document.location.reload(true);}, 2000);
				                  $('#pagesa_sukses').show('slow/400/fast', function() {
				                  	
				                  });
				                  // document.location.reload(true);
				              },
				              "error": function (msg) {
				              	console.log("1-error!");
				              }
				          }).done(function (msg) {
				              // console.log("1-done!");
				          });

				      };




				  });


});
</script>

<script>
function handleChange(input) {
	if (input.value < 0) input.value = 0;
	if (input.value > 255) input.value = 255;
}

function handleChange2(input) {
	if (input.value < 0) input.value = 0;
	if (input.value > 65535) input.value = 65535;
}

</script>


<script>

$(function() {

	$( "#fromDate2" ).datepicker();
	$( "#toDate2" ).datepicker();
});
</script>


<script type="text/javascript">

$(document).ready(function () {


	$(document).ready(function() {
	    $('#selecctall').click(function(event) {  //on click 
	        if(this.checked) { // check select status
	            $('.accessi').each(function() { //loop through each checkbox
	                this.checked = true;  //select all checkboxes with class "checkbox1"               
	            });
	        }else{
	            $('.accessi').each(function() { //loop through each checkbox
	                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	            });         
	        }
	    });
	    
	});


	$('#tabs').tab();

	$('#cancel').click(function(event) {

		event.preventDefault();

		$('#add').find('input, select, textarea').val("");

		$('#add').find('id').val("-1");

		$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/buildings/insert");

	});

	$('.edit-data').click(function() {
  	// console.log(this.id);
  	$('#client_id_payment').val(this.id);
    	// $.post('<?=base_url()?>index.php/payments/addPayment/' + this.id, function(data){

      	// $('a[href=#add]:first').attr('data-toggle', 'tab');

      	$('a[href=#add]').tab('show');

      	// $('#add').find('form').first().attr('action', "<?=base_url()?>index.php/buildings/edit");


      	// $.each(data, function(key, value) {

       //  	$('#add').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);

       //  });      	

    	// }, 'json');

});

	$('#add').find('form').first().validate({

		rules: {

			name: {required: true, minlength:3}

		}

	});    

});


function deleteNote(id){
	

	$.ajax({
		"dataType": "text",
		"type": "POST",
		"data":  "asd" ,
		"url": "<?=base_url()?>index.php/cards/deleteNote/"+id+" ",
		"beforeSend": function (msg) {

		},
		"success": function (msg) {


		},
		"error": function (msg) {
			console.log("1-error!");
		}
	}).done(function (msg) {
		console.log("1-done!");
	});

}


$('#closeAccess').click(function(event) {
	$('#access_cards').hide('slow/200/fast', function() {
		
	});
});

$('.access-data').click(function() {
	// console.log(this.id);
	// $(":checkbox[class='entries']").attr("checked", false);
	// $('input:checkbox[class=entries]').attr('checked',false);

	$('#access_cards').hide('slow/200/fast', function() {
		
	});
	$('#access_cards').show('slow/400/fast', function() {
		
	});

	$('.access_cards').attr('id', this.id);
	var cardID = this.id;
	$("input:checkbox[name=entry]:unchecked").each(function(){	
		var  checkboxvalue = this.value;
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>index.php/cards/checkIfExists/" + cardID + "/"+ this.value+"",
			success: function(result){
			                       	// console.log(result);
			                       	if (result == 1) { $('input:checkbox[id='+checkboxvalue+']').attr('checked',true); } else{};
			                       	

			                       }
			                   });
	});

});

$('.access_cards').click(function(event) {
	/* Act on the event */
	// console.log("card ID: " + this.id);
	var cardID = this.id;

	$.ajax({
		type: "POST",
		url: "<?=base_url()?>index.php/cards/deleteCardsEmployer/" + cardID + "",
		success: function(result){
			$('#loading').show();
			var  arr = [];
			$("input:checkbox[name=entry]:checked").each(function(){
				arr.push({
					card_id: cardID,
					elevator_id: this.value
				});

			});
			var myjson = JSON.stringify(arr);

			$.ajax({
				type: "POST",
				url: "<?=base_url()?>index.php/cards/insertCardsEmployer/",
				data: {myjson: myjson},
				success: function(result){
					$('#loading').hide('slow/2000/fast', function() {

					});
				}
			});

		                        	// console.log(arr);
		                        	$('#loading').hide('slow/2000/fast', function() {

		                        	});
		                        }
		                    });

	
	

	
});

function getEntries(buildingID){

	document.getElementById("entryList").innerHTML = "";

	$.ajax({
		type: "GET",
		url: "<?=base_url()?>index.php/reports/getEntriesByBuildingId/"+buildingID+"",
		                       // data: "emp_Id =" + id,
		                       success: function(result){
		                       	var arr = JSON.parse(result);
		                       	$('<option></option>', {text:"Choose Entry"}).attr('value', "").appendTo('#entryList');	
		                       	$.each(arr, function(i, value) {  
		                       		$('<option></option>', {text:value.name}).attr('value', value.id).appendTo('#entryList');
				           // console.log(value);
				       });
		                       }
		                   });

}
var elevator_id = null;
function showFloorAccess(entry_id){

	var relayNames  = { '20': 'Hyrje',  '21': 'Garazhde',  '22': 'Kabina',  '23': 'Kati -2',  '24': 'Kati -1',  '0': 'Kati 0',  '1': 'Kati 1',  '2': 'Kati 2',  '3': 'Kati 3',  '4': 'Kati 4',  '5': 'Kati 5',  '6': 'Kati 6',  '7': 'Kati 7',  '8': 'Kati 8',  '9': 'Kati 9',  '10': 'Kati 10',  '11': 'Kati 11',  '12': 'Kati 12',  '13': 'Kati 13',  '14': 'Kati 14',  '15': 'Kati 15',  '16': 'Kati 16',  '17': 'Vip 1',  '18': 'Vip 2',  '19': 'None' };


	var IMEI = null;

	$.ajax({
		type: "GET",
		async:false,
		url: "<?=base_url()?>index.php/cards/getImeiEntry/"+entry_id+"",
	               // data: "emp_Id =" + id,
	               success: function(result){
	               	var arr = JSON.parse(result);
	               	console.log();
	               	IMEI = arr[0].IMEI;
	               	elevator_id = arr[0].id;
	               }
	           });

	$.ajax({
		type: "GET",
		async:false,
		url: "<?=base_url()?>index.php/cards/getFloorsElevator/"+IMEI+"",
	               // data: "emp_Id =" + id,
	               success: function(result){
	               	var arr = JSON.parse(result);
	               	$("#accessControl").empty();
	               	if (arr[0].Relay1_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay1_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay2_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay2_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay3_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay3_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay4_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay4_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay5_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay5_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay6_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay6_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay7_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay7_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay8_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay8_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay9_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay9_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay10_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay10_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay11_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay11_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay12_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay12_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};if (arr[0].Relay13_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay13_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay14_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay14_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay15_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay15_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};
	               	if (arr[0].Relay16_Name != 19) {
	               		$('#accessControl').append('<input type="checkbox" name="accessi[]" class = "accessi" value="1">' + relayNames[arr[0].Relay16_Name] + '<br>');
	               	}else{
	               		$('#accessControl').append('<div style = "display:none"><input type="checkbox" disabled name="accessi[]" class = "accessi" value="1">null<br></div>'); 
	               	};


	               }
	           });


}

$('.storeEntryAccess').click(function(event) {
	
	var access = "";
	access = "";	
	$('#accessControl input:checkbox').each(function () {

		if( $(this).is(":checked") ){
			access +='1';
		}else{
			access +='0';
		}

	});
	access =   access.split("").reverse().join("");


	$('#accessEntryCards input:checkbox').each(function () {


		if( $(this).is(":checked") ){

			$.ajax({
				type: "POST",
				async: false,
				data: {elevator_id: elevator_id, card_id: $(this).val(), access: access},
				url: "<?=base_url()?>index.php/cards/cardOtherAccess",
		               // data: "emp_Id =" + id,
		               success: function(result){
		               	
		               	$('#accessControlSuccess').fadeIn('slow/2000/slow', function() {
		               		
		               	});

		               	setTimeout(function() {
		               		$("#accessControlSuccess").hide('blind', {}, 500)
		               	}, 3000);

		               	
		               }	
		           });


		}

	});



	 //if you want to do something specific for each check box
	 $("#accessControl :checkbox").each(function () {
				      //do it here
				      if (this.checked)
				      	this.click();
				  });

	 $("#accessEntryCards :checkbox").each(function () {
				      //do it here
				      if (this.checked)
				      	this.click();
				  });




	});

$('#currentYear').change(function(event) {

	$("#month1").val("");
	$("#month2").val("");
	$("#month3").val("");
	$("#month4").val("");
	$("#month5").val("");
	$("#month6").val("");
	$("#month7").val("");
	$("#month8").val("");
	$("#month9").val("");
	$("#month10").val("");
	$("#month11").val("");
	$("#month12").val("");

	$(".anch1").html("January");
	$(".anch2").html("February");
	$(".anch3").html("March");
	$(".anch4").html("April");
	$(".anch5").html("May");
	$(".anch6").html("June");
	$(".anch7").html("July");
	$(".anch8").html("August");
	$(".anch9").html("September");
	$(".anch10").html("October");
	$(".anch11").html("November");
	$(".anch12").html("December");








	var year =  $(this).val();
	var id = $("#h_value").val();
//	console.log(id);
	$.ajax({
		method:"GET",
		url:'../byYears/'+id+"/"+year,
		dataType : 'json',
		success:function(response) {
			var obj = response;


			var totali = 0;
			for (var i = 0; i < obj.length; i++) {

				var aaaa = parseFloat(obj[i].paid);
				totali += aaaa;

				if (obj[i].valute == 1) {
					$(".price").html(totali + ".00€");
				} else {
					$(".price").html(totali + ".00lek");
				}


				// returned values of month 1
				if (obj[i].month == 1) {
					$(".anch1").html("January<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/1/"+id+"' onClick='fshije(this.id)'>x</a></span>");
					if (obj[i].valute == 1) {
						$("#month1").val(obj[i].paid + "€");
					} else {
						$("#month1").val(obj[i].paid + "lek");
					}
						$("#month1").prop('disabled', true);
					
				}
				// returned values of month 2
				if (obj[i].month == 2) {
					$(".anch2").html("February<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/2/"+id+"' onClick='fshije(this.id)'>x</a></span>");
					if (obj[i].valute == 1) {
						$("#month2").val(obj[i].paid + "€");

					} else {
						$("#month2").val(obj[i].paid + "lek");
					}
						$("#month2").prop('disabled', true);
				}
				// returned values of month 3
				if (obj[i].month == 3) {
					$(".anch3").html("March<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/3/"+id+"' onClick='fshije(this.id)'>x</a></span>");
					if (obj[i].valute == 1) {
						$("#month3").val(obj[i].paid + "€");
					} else {
						$("#month3").val(obj[i].paid + "lek");
					}
						$("#month3").prop('disabled', true);
				}	
				
				// returned values of month 4
				if (obj[i].month == 4) {
					$(".anch4").html("April<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/4/"+id+"' onClick='fshije(this.id)'>x</a></span>");
					if (obj[i].valute == 1) {
						$("#month4").val(obj[i].paid + "€");
					} else {
						$("#month4").val(obj[i].paid + "lek");
					}
						$("#month4").prop('disabled', true);
				}
				// returned values of month 5
				if (obj[i].month == 5) {
					$(".anch5").html("May<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/5/"+id+"' onClick='fshije(this.id)'>x</a></span>");
					if (obj[i].valute == 1) {
						$("#month5").val(obj[i].paid + "€");
					} else {
						$("#month5").val(obj[i].paid + "lek");
					}
						$("#month5").prop('disabled', true);
				}

					// returned values of month 6
					if (obj[i].month == 6) {
						$(".anch6").html("June<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/6/"+id+"' onClick='fshije(this.id)'>x</a></span>");
						if (obj[i].valute == 1) {
							$("#month6").val(obj[i].paid + "€");
						} else {
							$("#month6").val(obj[i].paid + "lek");
						}
							$("#month6").prop('disabled', true);
					}
					// returned values of month 7
					if (obj[i].month == 7) {
						$(".anch7").html("July<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/7/"+id+"' onClick='fshije(this.id)'>x</a></span>");
						if (obj[i].valute == 1) {
							$("#month7").val(obj[i].paid + "€");
						} else {
							$("#month7").val(obj[i].paid + "lek");
						}
							$("#month7").prop('disabled', true);
					}
					// returned values of month 8
					if (obj[i].month == 8) {
						$(".anch8").html("August<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/8/"+id+"' onClick='fshije(this.id)'>x</a></span>");
						if (obj[i].valute == 1) {
							$("#month8").val(obj[i].paid + "€");
						} else {
							$("#month8").val(obj[i].paid + "lek");
						}
							$("#month8").prop('disabled', true);
					}
					// returned values of month 9
					if (obj[i].month == 9) {
						$(".anch9").html("September<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/9/"+id+"' onClick='fshije(this.id)'>x</a></span>");
						if (obj[i].valute == 1) {
							$("#month9").val(obj[i].paid + "€");
						} else {
							$("#month9").val(obj[i].paid + "lek");
						}
							$("#month9").prop('disabled', true);
					}
					// returned values of month 10
					if (obj[i].month == 10) {
						$(".anch10").html("October<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/10/"+id+"' onClick='fshije(this.id)'>x</a></span>");
						if (obj[i].valute == 1) {
							$("#month10").val(obj[i].paid + "€");
						} else {
							$("#month10").val(obj[i].paid + "lek");
						}
							$("#month10").prop('disabled', true);
					}
					// returned values of month 11
					if (obj[i].month == 11) {
						$(".anch11").html("November<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/11/"+id+"' onClick='fshije(this.id)' >x</a></span>");
						if (obj[i].valute == 1) {
							$("#month11").val(obj[i].paid + "€");
						} else {
							$("#month11").val(obj[i].paid + "lek");
						}
							$("#month11").prop('disabled', true);
					}
					// returned values of month 12

				if (obj[i].month == 12) {
					$(".anch12").html("December<br><span style='margin-left:65px'><a style='margin: 18px -10px;position: absolute;' id='http://213.163.123.246/lift_new/index.php/payments/deletePayment/"+year+"/12/"+id+"' onClick='fshije(this.id)'>x</a></span>");
					if (obj[i].valute == 1) {
						$("#month12").val(obj[i].paid + "€");
					} else {
						$("#month12").val(obj[i].paid + "lek");
					}
						$("#month12").prop('disabled', true);
				}


				}



	
}
});
});

function fshije(id){
	if(confirm("Do you really want to delete this field")){
	  var note = prompt("Shkruaj komentin perse doni ta fshini kete pagese");
	  $.ajax({
	  	type : "POST",
	  	url:id+"/"+note,
	  	success:function(){
	  		location.reload();
	  		
	  	}

	  });
	} 
}


</script>
