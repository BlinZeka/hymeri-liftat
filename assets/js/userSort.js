"use strict";
var app = angular.module('UserSort' , []);

app.controller("UserController" , function ($scope , $http){
	$http.get("users/returnDatas").success(function (response){
		$scope.datas = response;
	});
});

