
<div class="content_main" >

	<ul class="nav nav-tabs nav-justified" data-tabs="tabs" id="tabs">

		<li class="active"><a href="#users" data-toggle="tab">Edit Users</a></li>
		<li><a href="#buildingAccess" data-toggle="tab">Add Building Access</a></li>
		<li><a href="#view" data-toggle="tab">Show all IMEI / Entry</a></li>

	</ul>

	<div class="tab-content" style="padding-top: 30px;">

		<div id="users" class="tab-pane active">
			<?php 
			
			foreach ($library->css_files as $key => $value) { ?>
				
				 <link type="text/css" rel="stylesheet" href="<?php echo $value; ?>" />
			<?php }?>
			
			
			
			<?php foreach($library->js_files as $file): ?>
			    <script src="<?php echo $file; ?>"></script>
			<?php endforeach; ?>
			 

			    <div style='height:20px;'></div>  
			    <div>
			        <?php echo $library->output; ?>
			    </div>
		</div>

		<script src="<?=base_url() ?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
		<script src="<?=base_url() ?>assets/js/TableTools.min.js" type="text/javascript"></script>
		<script src="<?=base_url() ?>assets/js/ZeroClipboard.js" type="text/javascript"></script>
		<script src="<?=base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
		<div id="view" class="tab-pane">

			<table class="table table-striped datatable">

				<thead>

					<tr>
						<td>Company</td>

						<td>Building</td>

						<td>Entry</td>

						<td>Street</td>

						<td>IMEI</td>

						<td>Phone</td>

					</tr>
				</thead>
				<tbody>
					<?php foreach ($liftet as $key => $value): ?>
							<tr>			
								<td><?=$value->company?></td>

							 	<td><?=$value->buildingName?></td>

								<td><?=$value->entry?></td>

								<td><?=$value->street?></td>

								<td><?=$value->imei?></td>

								<td><?=$value->phone?></td>

							</tr>
							
					<?php endforeach ?>
				</tbody>

			</table>
			
		</div>

		<div id="buildingAccess" class="tab-pane">

			<table class="table table-striped datatable">

				<thead>

					<tr>
						<td>Client</td>
						<td>Email</td>
						<td>#</td>

					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $key => $value): ?>
							<tr>			
								<td><?=$value['first_name']?></td>
								<td><?=$value['email']?></td>
								<td><button  id  = "<?=$value['id']?>"  class="btn btn-primary btn-lg clientIdAccess" data-toggle="modal" data-target="#myModal">Add Bulding Access</button></td>
							</tr>
							
					<?php endforeach ?>
				</tbody>

			</table>
			
		</div>

	</div>
	

	
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Building Access</h4>
      </div>
      <div class="modal-body" >
      	<select name="building_id" class="form-control"  style = "margin-left:12px;height:32px;width:200px;" id="buildingList2">
      		<?php foreach ($buildings as $key => $value): ?>
      			<option value="<?=$value['id']?>"><?=$value['name']?></option>
      		<?php endforeach ?>
      	</select>
      	<div style="width:480px;margin-top:30px;margin-left:14px">
      		<ul class="media-list accessetBuildingList"></ul>
      	</div>
     	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button"  class="btn btn-primary saveBuildingAccess">Add</button>
      </div>
    </div>
  </div>


</div>


<script type="text/javascript">
var clientID = null;


$(document).ready(function() {
	
	$(".DTTT_container").attr("style", "display: none !important");

	$('.clientIdAccess').click(function(event) {
		 clientID = this.id;
		 $('.accessetBuildingList').empty();
		 $.ajax({
		            type: "POST",
		            async: false,
		            url: '<?=base_url()?>index.php/maintaining/getClientsAccess/'+clientID+'',
		            data: '',
		            success: function (result) {
		           		var arr = JSON.parse(result);
				$.each(arr, function(index, val) {
					$('.accessetBuildingList').append('<li class="list-group-item">'+val.name+' <a href = "#"><span id = "'+val.access_id+'" class="glyphicon glyphicon-remove removeBuildingAccess" style = "float:right"></span></a></li>');
				});
		           		
		            }
		});
	});	


	$('.saveBuildingAccess').click(function(event) {
		 $.ajax({
		            type: "POST",
		            async: false,
		            url: '<?=base_url()?>index.php/maintaining/clientAccessBuilding/'+clientID+'/'+$('#buildingList2').val()+' ',
		            data: '',
		            success: function (result) {
		           		var arr = JSON.parse(result);
				lastRecord = arr.length;
		           		$('.accessetBuildingList').append('<li class="list-group-item">'+arr[lastRecord-1].name+' <a href = "#"><span id = "'+arr[lastRecord-1].access_id+'" class="glyphicon glyphicon-remove removeBuildingAccess" style = "float:right"></span></a></li>');
		            }
		});

	});

	$('.removeBuildingAccess').live('click', function(event) {
		
		 $('.accessetBuildingList').empty();
		 $.ajax({
		            type: "POST",
		            async: false,
		            url: '<?=base_url()?>index.php/maintaining/deleteClientsAccess/'+this.id+'/'+clientID+' ',
		            data: '',
		            success: function (result) {
		           		var arr = JSON.parse(result);
				$.each(arr, function(index, val) {
					$('.accessetBuildingList').append('<li class="list-group-item">'+val.name+' <a href = "#"><span id = "'+val.access_id+'" class="glyphicon glyphicon-remove removeBuildingAccess" style = "float:right"></span></a></li>');
				});
		           		
		            }
		});
	});
	
});


</script>