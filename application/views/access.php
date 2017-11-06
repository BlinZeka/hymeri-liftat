<script type="text/javascript">

$(document).ready(function(){

//    	$('.delete-employer').click(function() {
//
//		var r=confirm("Are you sure you want to delete this record?");
//			if (r==true) {
//
//				$.ajax({
//					type: "POST",
//					async: false,
//					url: '<?//=base_url()?>//index.php/cardsEmployer/deleteEmployer/' + this.id,
//					data: '',
//					success: function (result) {
//						location.reload(false);
//					}
//				});
//
//			}
//			else  {
//
//			}
//
//	});


 $(".building").click(function(){
    $('.entry'+this.id).show();
});


});
    
</script>

  <div class="content_main" >
		
	<ul class="nav nav-tabs nav-justified" data-tabs="tabs">

	<li class="active"><a href="#view" data-toggle="tab">Employers</a></li>
	<li><a href="#addEmployer" id="adds" data-toggle="tab" >Add Employer</a></li>

	</ul>

	<div class="tab-content" style="padding-top: 20px;" ng-app="SortingApp" ng-controller="MainControler">

		<div id="view" class="tab-pane active">
			<input type="text" placeholder="Search" data-ng-model="searchTeam">
			<table class="table table-striped">

				<thead>

					<tr>

						<td>
							<a href="#" data-ng-click="orderByField='fname'; reverseSort=!reverseSort">
							Name<span data-ng-show="orderByField == 'fname'"><span data-ng-show="!reverseSort" style="margin: 7px 5px;"><i class="fa fa-sort-asc"></i></span><span data-ng-show="reverseSort"  style="margin: 7px 5px;"><i class="fa fa-sort-desc"></i></span></span>
							</a>
						</td>
						<td>Tel</td>
						<td>#</td>
						

					</tr>

				</thead>

				<tbody>

			<tr ng-repeat="x in names | filter:searchTeam | orderBy:orderByField:reverseSort">
				<td>
				  <a href="<?php echo base_url() ?>index.php/cardsEmployer/index/{{ x.id }}">
						{{x.fname}} {{ x.lname }}
				  </a>
				</td>
				<td>{{x.tel}}</td>
				<td><a class='btn btn-xs btn-warning edit-data' data-id="{{ x.id }}" id="{{ x.id }}" data-ng-click="go(x.id)" name="editbutton" data-ng-model="edit"><span class='glyphicon glyphicon-edit'></span> Edit</a></td>
				<td><a class='btn btn-xs btn-danger delete-employer' id="{{ x.id }}" data-ng-click="delete(x.id)"><span class='glyphicon glyphicon-remove'></span></a> </td>
			</tr>
			</tbody>

			</table>

		</div>

		<div id="addEmployer" class="tab-pane">
			<form class="form-horizontal col-md-7" id = "myForm" role="form">
				

				<div class="form-group">
						<label>First Name</label><br/>
				
						<input type="text" id="fname" name="fname" value="" ng-model="emp.fname"/>
				</div>
				<div class="form-group">
						<label>Last Name</label><br/>
						<input type="text" id="lname" name="lname" value="" ng-model="emp.lname"/>
				</div>
				<div class="form-group">
						<label>Tel</label><br/>
						<input type="text" name="tel" value="" ng-model="emp.tel"/>
				</div>
					<div class="form-group">
						<label>Company</label><br/>
						<select name="companies" id = "companies" class="selection" style="width: 210px;" ng-model="emp.companies">
							<OPTION value = "1">Hymeri Kleemann</OPTION>
							<OPTION value = "2">Hy-Eco</OPTION>
							<OPTION value = "3">Tregtia</OPTION>
							<OPTION value = "4">Lesna</OPTION>
						</select>	
				</div>
				
				<div class="form-group">

			

						<button ng-click="action(emp)" class="btn btn-primary" >Ruaje</button>

						<button id="cancel" class="btn btn-warning" >Pastro</button>
						
						<!-- <button class="btn_btn-default_1" id="add-card" style=' padding: 6px 1px; margin: 1px 5px;'>Shto Kartele</button> -->

				

				</div>
			</form>
		</div>

		
		

</div>
</div>

<script type="text/javascript">
$(document).ready(function() {

//	$('.edit-data').click(function() {
//		var employerID = this.id;
//		$.post('<?//=base_url()?>//index.php/access/editEmployer/' + this.id, function(data){
//	      	$('a[href=#addEmployer]:first').attr('data-toggle', 'tab');
//	      	$('a[href=#addEmployer]').tab('show');
//
//
//	      	$('#addEmployer').find('form').first().attr('action', "<?//=base_url()?>//index.php/access/editEmployerAction/"+employerID+"");
//	$.each(data, function(key, value) {
//		$('#addEmployer').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);
//	});
//}, 'json');
//
//});


});



</script>
