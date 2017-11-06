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

function validateForm() {
    var employer_id = document.forms["submitForm"]["employer_id"].value;
    var site_code = document.forms["submitForm"]["side_code"].value;
    var site_no = document.forms["submitForm"]["site_no"].value;
    var exsist = 0;
     $.ajax({
		type: "POST",
		async: false,
		url: '<?=base_url()?>index.php/cards/checkCardExistsSC/' + site_code + '/'+site_no,
		data: '',
		success: function (result) {
			var results = result.split("+")
			console.log(results[2]+" "+results[3]);
				if(results[0] >= 1) {
					document.getElementById("personi").text = results[2]+" "+results[3];
					if(results[4] == 1) {
					document.getElementById("personi").href = "<?php base_url() ?>../../cards/index/"+results[1];	
					}
					else if(results[4] == 2) {
					document.getElementById("personi").href = "<?php base_url() ?>../../cardsEmployer/index/"+results[1];
						
					}
					
					document.getElementById("display_exit").style.display = "block";
					exsist = 1;
				}
		
		 	}
		});
    
    if(exsist == 1) {
	    return false;
    }
//     return false;
// 	console.log(employer_id+" "+site_code+" "+site_no);
	 
}



</script>

  <div class="content_main" style = "width:800px;">
  	<div id="loading" style = "display:none">Loading.... <img style = "width:20px;height:20px;" src="<?=base_url()?>assets/images/loading.gif"></div>
	<div id='loadingmessage' style='display:none'>
	  <img src='https://cdn1.iconfinder.com/data/icons/free-mobile-icon-kit/64/Loading_throbber.png'/>
	</div>	

	<ul class="nav nav-tabs nav-justified" data-tabs="tabs">

	<li class="active"><a href="#view" data-toggle="tab">View Cards</a></li>
	<li><a href="#addCard" data-toggle="tab">Add Card</a></li>

	</ul>

	<div class="tab-content" style="padding-top: 20px;">

		<div id="view" class="tab-pane active">

			<table class="table table-striped">
				<thead>
					<tr>
						<td>Card No</td>
						<td>Site Code</td>
						<td>Site No</td>
						<td>Created by</td>
						<td>Updated by</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
				<?php
				
				foreach ($cards as $card) {
					echo "<tr>
									<td>{$card->card_no}</td>
									<td>{$card->site_code}</td>
									<td>{$card->site_no}</td>
									
									<td>{$card->created_by}</td>
									<td>{$card->updated_by}</td>
									<td >
										<div class='pull-right'>";
										
										echo "<a class='btn btn-xs btn-primary access-data'  ' id='" . $card->id . "'><span class='glyphicon glyphicon-edit'></span> Access</a>
										            <a class='btn btn-xs btn-danger delete-data' id='" . $card->id . "'><span class='glyphicon glyphicon-remove'></span></a>



										</div>
									</td>
								</tr>";
					// redirect('./cards/index/1', 'refresh');
					// http://80.80.161.77/lift/index.php/cards/index/1
				}
				?>				
			</tbody>
			</table>

		</div>

		<div id="addCard" class="tab-pane">
			
			<form id="submitForm" class="form-horizontal col-md-7" role="form" method="post" action="<?=base_url()?>index.php/cards/insertEmployer" onsubmit="return validateForm()"><h5 style="color:red; display:none;" id="display_exit">This Cards EXISTS > <a id="personi" href="">Person</a></h5>
				<input type="hidden" id="employer_id" name="employer_id" value="<?=$employer_id?>" /> 
				<input type="hidden" id="id" name="id" value="-1" />
				<div class="form-group">
					<label class="col-sm-2 control-label">Site Code</label>
					<div class="col-sm-10">
						<input type="text" name="site_code" id="side_code" class="form-control" maxlength="3">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Site No</label>
					<div class="col-sm-10">
						<input type="text" name="site_no" id="site_no" class="form-control" maxlength="5">
					</div>
				</div>

<!--
				<div class="form-group">
					<label class="col-sm-2 control-label">Company</label>
					<div class="col-sm-10">
						<select name="floors" id = "companies" onChange ="return getBuildings(this.value)" class="selection" style="width: 210px;">
							<OPTION value = "1">Hymeri Kleemann</OPTION>
							<OPTION value = "2">Hy-Eco</OPTION>
							<OPTION value = "3">Tregtia</OPTION>
							<OPTION value = "4">Lesna</OPTION>
						</select>	
					</div>
				</div>
-->

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10" style='width: 170px; float: right;'>
						<button type="submit" class="btn btn-primary">Save</button>


						
					</div>
				</div>
			</form>
		</div>

		
		

</div>
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
<script type="text/javascript">

	// $('.delete-data').click(function() {

	//     	var r=confirm("Are you sure you want to delete this record?");
	// 	if (r==true) {
	// 	 	$.post('<?=base_url()?>index.php/cards/delete/' + this.id, function(data){
	// 	      	$('a[href=#add]:first').attr('data-toggle', 'tab');
	// 	      	$('a[href=#add]').tab('show');

	// 	      	$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/cards/edit");
	// 	      	$.each(data, function(key, value) {
	// 	        	$('#add').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);

	// 	        });      	
	// 	    	}, 'json');
	// 	    	window.location.reload();
	// 	  }
	// 	else  {
		 
	// 	  }

	//     });


    	$('.delete-data').click(function() {

	    	var r=confirm("Are you sure you want to delete this record?");
		if (r==true) {

		    	    $.ajax({
			            type: "POST",
			            async: false,
			            url: '<?=base_url()?>index.php/cards/deleteClientUpdate/' + this.id,
			            data: '',
			            success: function (result) {
// 			           		location.reload(false);	
			            }
			        });
		 	
		  }
		else  {
		 
		  }

	    });



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


$('#site_code').jStepper({minValue:0, maxValue:255});
$('#site_no').jStepper({minValue:0, maxValue:65535});


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


    </script>