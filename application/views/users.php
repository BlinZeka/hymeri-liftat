<div class="content_main" ng-app="UserSort">
	<div class="tab-content" style="padding-top: 20px;" ng-controller="UserController">

		<div id="view" class="tab-pane active">
			<table class="table table-striped">
				<input type="text" placeholder="Search" data-ng-model="searchTeam">
				<thead>

					<tr>

						<td>
							<a href="#" data-ng-click="orderByField='fname'; reverseSort=!reverseSort">
							Name<span data-ng-show="orderByField == 'fname'"><span data-ng-show="!reverseSort" style="margin: 7px 5px;"><i class="fa fa-sort-asc"></i></span><span data-ng-show="reverseSort"  style="margin: 7px 5px;"><i class="fa fa-sort-desc"></i></span></span>
							</a>
						</td>
						<td>Surname</td>
						<td>Username</td>
						<td>#</td>
						

					</tr>

				</thead>

				<tbody>

			<tr ng-repeat="x in datas | filter:searchTeam ">
				<td>
				  <a href="">
						{{x.first_name}}
				  </a>
				</td>
				<td>
					<a href="">
						{{x.last_name}}
					</a>
				</td>
				<td>
					<a href="">
						{{x.username}}
					</a>
				</td>				
				<td><a class='btn btn-xs btn-warning edit-data' href="users/buildaccess/{{x.id}}" data-id="{{ x.id }}" id="{{ x.id }}"  name="editbutton" data-ng-model="edit"><span class='glyphicon glyphicon-edit'></span> Building access</a>
				<a class='btn btn-xs btn-danger delete-employer' id="{{ x.id }}" data-ng-click="delete(x.id)"><span class='glyphicon glyphicon-remove'></span></a> </td>
			</tr>
			</tbody>

			</table>

		</div>
</div>
</div>






