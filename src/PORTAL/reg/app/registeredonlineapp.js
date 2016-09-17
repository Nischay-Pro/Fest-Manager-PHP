var app = angular.module('angularTable', ['angularUtils.directives.dirPagination']);

app.controller('listdata',function($scope,$http){
	$http.get("http://172.16.34.160/Pearl%202k16/PORTAL/reg/registeredonlinedata.php")
  .then(function (response) {
$scope.users = response.data;
});
	
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;   //set the sortKey to the param passed
		$scope.reverse = !$scope.reverse; //if true make it false and vice versa
	}
});