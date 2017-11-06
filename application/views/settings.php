<div class="content_main" >
	<h2>Settings</h2>

	<?php $this->load->library('form_validation'); echo validation_errors(); ?>
	<form  role="form"  method = "post" action="<?=base_url()?>index.php/settings/editUser">

		<!-- <div class="form-group" style=" width: 230px; ">

				<label class="col-sm-2 control-label" style=" width: 110px; margin: 3px 10px;" >First Name:</label>

				<div class="col-sm-10">					
					<input type="text" value = "<?php echo $admin_info[0]['first_name'];?>" class="form-control" name="first_name">
				</div>

		</div>

		<div class="form-group" style=" width: 230px;">

				<label class="col-sm-2 control-label" style=" width: 110px; margin: 3px 10px;" >Last Name:</label>

				<div class="col-sm-10">					
					<input type="text" value = "<?php echo $admin_info[0]['last_name'];?>"  class="form-control" name="last_name">
				</div>

		</div> -->

		<div class="form-group" style=" width: 230px; ">

				<label class="col-sm-2 control-label" style=" width: 110px; margin: 3px 10px;" >New Password:</label>

				<div class="col-sm-10">					
					<input type="password" value = "" name = "password" class="form-control" id="pass">
				</div>

		</div>
		
		<input type="hidden" name= "id"  value = "<?php echo $admin_info[0]['id'];?>">
		
		<div class="form-group" style=" width: 230px; ">
			<input type= "submit"   value = "Submit" class="btn btn-primary" style=" width: 90px">
		</div>
	</form>
</div>