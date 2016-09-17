<!doctype html>
<html lang="en" ng-app="angularTable">
  <head>
    <meta charset="utf-8">
    <title>Search Sort and Pagination in Angular js</title>
    <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
     <link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
	
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
     <script src="../js/jquery-1.11.3.min.js"></script>
     <script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
  </head>
  <body>
	<div class="container">
      <div class="" style="margin-top:10px;">
        <div class="col-lg-8">
			
			<div class="bs-component" ng-controller="listdata">
				
				
					<div class="form-group col-sm-6">
						<label >Search</label>
						<input type="text" ng-model="search" class="form-control" placeholder="Search">
					</div>
				
				<table class="table table-striped">
					<thead>
						<tr>
							<th ng-click="sort('id')">Id
								<span class="glyphicon sort-icon" ng-show="sortKey=='id'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('name')">Name
								<span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('email')">Email
								<span class="glyphicon sort-icon" ng-show="sortKey=='email'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('college')">College
								<span class="glyphicon sort-icon" ng-show="sortKey=='college'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('phone')">Phone
								<span class="glyphicon sort-icon" ng-show="sortKey=='phone'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="user in users|filter:search">
							<td >{{user.P_Id}}</td>
							<td >{{user.name}}</td>
							<td >{{user.email}}</td>
							<td >{{user.college}}</td>
							<td >{{user.phone}}</td>
							
						</tr>
					</tbody>
				</table> 
				
			</div>
		</div>
		
      </div>
    </div>
		<script src="js/angular/angular.js"></script>
		<script src="js/dirPagination.js"></script>
		<script src="app/registeredonlineapp.js"></script>	
  </body>
</html>
