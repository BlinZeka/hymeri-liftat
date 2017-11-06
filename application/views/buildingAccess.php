<script type="text/javascript">
		$(document).on('change','input[name="check_all"]',function() {
			$(".access").prop('checked' , this.checked);
		});




		$( document ).ready(function() {
 			var id = $('#accessId').val();
 			// $.ajax({
 			// 	url:'../test/' + id,
 			// 	type:'GET',
 			// 	success:function(response){
 			// 		var obj = response;
 			// 		console.log(JSON.stringify(obj[0].user_id));  
 			
 			// 	}
 			// });

			

			$.getJSON( "../test/" + id, function( data ) { 
				$.each(data , function (key , value){
					var a = value.building_id;
					$("."+ a).prop("checked" , true);
					if ( $("."+ a).prop( "checked" ) ){
						$("."+ a).prop("disabled" , true);
					}

				});
			});

		});
</script>
<div class="content_main" >

	<ul class="nav nav-tabs nav-justified" data-tabs="tabs" id="tabs">

		<li class="active"><a href="#users" data-toggle="tab">Access</a></li>
		<li><a href="#view" data-toggle="tab">Access informations</a></li>
	</ul>

	<div class="tab-content" style="padding-top: 30px;">

		<div id="users" class="tab-pane active">
						<table class="table table-striped">
				<input type="hidden" value="<?php echo $accessId; ?>" id="accessId">
				<form action="../choosen/<?php echo $accessId; ?>" method="POST">
				<input type="submit" value="Allow">
				<div style="float: right;height: auto;margin: 1px 60px;width: 100px;">
				<input type="checkbox" name="check_all" style="width: 23px;margin: 4px 5px;height: 15px;"> Check all
				</div>
				<thead>

					<tr>
						<td>Name</td>
						<td>Rruga</td>
						<td>Rajoni</td>
						<td>#</td>
					</tr>
				</thead>

				<tbody>
<!-- 					<?php foreach($checked as $check){ echo $check['building_id'].'<br>';
							?>
						
					<?php  } ?> -->
			<?php foreach($buildings as $build): ?>
			<tr>
				<td>
				  <a href="">
						<?php echo $build['bname']; ?>
				  </a>
				</td>
				<td>
					<a href="">
						<?php echo $build['street']; ?>
					</a>
				</td>
				<td>
					<a href="">
					<?php  echo $build['zname']; ?>
					</a>
				</td>				
				<td>
					<input type="checkbox" name="building_id[]>" value="<?php echo $build['id']; ?>" class="<?php echo $build['id']; ?>" ></a>
				   
			</tr>
			<?php endforeach; ?>
			</tbody>
				</form>
			</table>
		</div>
		<div id="view" class="tab-pane">
				<table class="table table-striped">
				<thead>

					<tr>
						<td>Name</td>
						<td>Rruga</td>
						<td>Rajoni</td>
						<td>#</td>
					</tr>
				</thead>

				<tbody>
<!-- 					<?php foreach($checked as $check){ echo $check['building_id'].'<br>';
							?>
						
					<?php  } ?> -->
			<?php foreach($buildingsid as $id): ?>
			<tr>
				<td>
				  <a href="">
						<?php echo $id['bname']; ?>
				  </a>
				</td>
				<td>
					<a href="">
						<?php echo $id['street']; ?>
					</a>
				</td>
				<td>
					<a href="">
					<?php  echo $id['zname']; ?>
					</a>
				</td>				
				<td>
					<form action="../delete_access/<?php echo $id['te_id'] ?>" method="POST">
					<input type="submit" value="x" style="width:30px"  class="btn btn-xs btn-danger delete-access">
				   
			</tr>
			<?php endforeach; ?>
			</tbody>
				</form>
			</table>
			
		</div>



	</div>
	

	
</div>

