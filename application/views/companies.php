<script>
	$("a[href='<?=base_url()?>index.php/companies']:first").find('.lm_box').attr("class", "lm_box_selected");
	$("#title_1").text("Home > Companies");
</script>
<div class="content_main">
<ul class="nav nav-tabs nav-justified" data-tabs="tabs" id="tabs">
	<li class="active"><a href="#view" data-toggle="tab">View</a></li>
	<li><a href="#add" data-toggle="tab">Add</a></li>
</ul>



<div class="tab-content" style="padding-top: 20px;">
	<div id="view" class="tab-pane active">
		<table class="table table-striped datatable">
			<thead>
				<tr>
					<td>Name</td>
					<td>City</td>
					<td>Created By</td>
					<td>Create Date</td>
					<td>Updated By</td>
					<td>Update Date</td>
					<td>#</td>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $companies as $company ) {
					echo "<tr>
									<td>{$company->name}</td>
									<td>{$company->city}</td>
									<td>{$company->created_by}</td>
									<td>{$company->create_date}</td>
									<td>{$company->updated_by}</td>
									<td>{$company->update_date}</td>
									<td>
									  
									  <a class='btn btn-xs btn-warning edit-data' id='".$company->id."'>Edit</a>
									  <a class='btn btn-xs btn-danger delete-data' id='".$company->id."'>Fshij</a>
                  </td>
								</tr>";
				}
				?>				
			</tbody>
		</table>
	</div>

	<div id="add" class="tab-pane">
		<form class="form-horizontal col-md-7" role="form" action="<?=base_url()?>index.php/companies/insert"> 
			<input type="hidden" name="id" value="-1" />
		  <div class="form-group">
		    <label class="col-sm-2 control-label">Name</label>
		    <div class="col-sm-10">
		      <input type="text" name="name" class="form-control" placeholder="Building Name">
		    </div>
		  </div>
		  <div class="form-group">
		  	<label class="col-sm-2 control-label">Fiscal No</label>
		  	<div class="col-sm-10">
		  		<input type="text" name="fiscal_no" class="form-control">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<label class="col-sm-2 control-label">Business No</label>
		  	<div class="col-sm-10">
		  		<input type="text" name="business_no" class="form-control">
		  	</div>
		  </div>
		  <div class="form-group">
		  	<label class="col-sm-2 control-label">Owner</label>
		  	<div class="col-sm-10">
		  		<input type="text" name="owner" class="form-control">
		  	</div>
		  </div>	
		  <div class="form-group">
		  	<label class="col-sm-2 control-label">Phone</label>
		  	<div class="col-sm-10">
		  		<input type="text" name="phone" class="form-control">
		  	</div>
		  </div>		  	  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">City</label>
		    <div class="col-sm-10">
		    	<select name="city_id" class="city">
		    		<?php
		    			foreach($cities as $city) {
								echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
							} 
		    		?>
		    	</select>
		    </div>
		  </div>		 	 		   
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-default">Ruaje</button>
		      <button id="cancel" class="btn btn-default">Pastro</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
  	$('#tabs').tab();

		$('#cancel').click(function(event){
		  event.preventDefault();
		  $('#add').find('input, select, textarea').val("");
		  $('#add').find('id').val("-1");
		  $('#add').find('form').first().attr('action', "<?=base_url()?>index.php/companies/insert");
		});
  	
  	$('.edit-data').click(function() {
    	$.post('<?=base_url()?>index.php/companies/ajax', {id: this.id}, function(data){
      	$('a[href=#add]:first').attr('data-toggle', 'tab');
      	$('a[href=#add]').tab('show');
      	$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/companies/edit");
      	$.each(data, function(key, value) {
        	$('#add').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);
        });      	
    	}, 'json');
    });
    
      $('.delete-data').click(function() {
    	$.post('<?=base_url()?>index.php/companies/delete/'+this.id, {id: this.id}, function(data){
           		
    	}, 'json');
    	setTimeout(function() { document.location.reload(true);}, 1500);
    });

 	 	$('#add').find('form').first().validate({
			rules: {
		    name: {required: true, minlength:3},
		    fiscal_no: {required: true, minlength:3},
		    business_no: {required: true, minlength:3},
		    owner: {required: true, minlength:3},
		    phone: {required: true, minlength:3}
		  }
		});    
  });
</script>
