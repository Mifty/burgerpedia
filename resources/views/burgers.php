<!DOCTYPE html>
<html lang="en" ng-app="BurgerPedia">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="BurgerPedia">
    <meta name="author" content="Mifty Yusuf">

    <title>BurgerPedia - We've Got the Burgers</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
	
	<!-- custom CSS for the page -->
    <link href="<?= asset('css/burgerpedia.css') ?>" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
  </head>

  <body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">BurgerPedia</a>
        </div>
      </div>
    </nav>

	<!-- MAIN CONTENT AND INJECTED VIEWS -->
    <div id="main">
        <!-- this is where content will be injected -->
        <div ng-view></div>
    </div>

	<!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
	<script src="<?= asset('js/angular/angular.min.js') ?>"></script>
	<script src="<?= asset('js/angular/angular-route.min.js') ?>"></script>
	<script src="<?= asset('js/jquery.min.js') ?>"></script>
	<script src="<?= asset('js/bootstrap.min.js') ?>"></script>
	
	<!-- AngularJS Application Scripts -->
	<script src="<?= asset('app/app.module.js') ?>"></script>
	<script src="<?= asset('app/hamburgers/hamburgers.controller.js') ?>"></script>
	<script src="<?= asset('app/hamburger/hamburger.controller.js') ?>"></script>
		
		

  </body>
</html>
