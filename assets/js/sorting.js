"use strict";
var app = angular.module('SortingApp', []);


app.controller("MainControler" , function($scope, $rootScope, $http){

   $scope.orderByField = "fname";
   $scope.reverseSort = false;

   $scope.go =  function(id) {
	   

 	$('a[href=#addEmployer]:first').attr('data-toggle', 'tab');
 	$('a[href=#addEmployer]').tab('show');
 	
 	if(id == undefined){

 	}else{
// 	 	document.getElementById('lname').disabled = true;
// 	 	document.getElementById('fname').disabled = true;
 	}
 	
 	
 	return $http({
	 	type: 'GET',
	 	url: 'access/editEmployer/' + id
 	}).success(function (response) {
	 	$scope.emp = {
		 	id: response.id,
		 	fname: response.fname,
		 	lname: response.lname,
		 	tel: response.tel
	 	}


	 	$rootScope.id = response.id;
	 	console.log($rootScope.id);
 	});
 	
 
 	
 	$scope.action(id);


		


   }
   
   $scope.action = function (emp) {
   		if ($rootScope.id == undefined) {
	   		$.ajax({
		   		type: 'POST',
		   		url: 'clients/insertEmployer',
		   		data: emp,
		   		success: function (result) {
                    location.reload(true);
                }
	   		});
   		} else {
	   		$.ajax({
		   		type: 'POST',
		   		url: 'access/editEmployerAction/' + $rootScope.id,
		   		data: emp,
		   		success: function (result) {
                    location.reload(true);
                }
	   		});
   		}
	 
	
	   
	   
   }   
   var addEmployer = angular.element("#adds");
   
   addEmployer.click(function () {
	   document.getElementById("myForm").reset();
	   $rootScope.id = undefined; 
	  $scope.go($rootScope.id); 
   });

    $scope.delete = function(id){
        var r=confirm("Are you sure you want to delete this record?");
        if (r==true) {

            $.ajax({
                type: "POST",
                async: false,
                url: 'cardsEmployer/deleteEmployer/' + id,
                data: '',
                success: function (result) {
                    location.reload(false);
                }
            });

        }
        else  {

        }
    }

    $http.get("access/returnAjax")
        .success(function(response) {
            $scope.names = response;
        });
        
        
        
  
        
        
	});


