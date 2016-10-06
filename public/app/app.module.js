// define the 'Burgerpedia' module
// also include ngRoute for all our routing needs
var BurgerPedia = angular.module('BurgerPedia', ['ngRoute']);

 // define our canstant for the API
BurgerPedia.constant('constants', {
		API_URL: 'http://localhost/burgerpedia/public/api/'
	});
	
// configure our routes
BurgerPedia.config(function($routeProvider) {
	$routeProvider
		// route for the hamburgers page
		.when('/', {
			templateUrl : 'app/hamburgers/hamburgers.template.htm',
			controller  : 'hamburgersController'
		})

		// route for a single hamburger 
		.when('/hamburger/:hamburgerID', {
			templateUrl : 'app/hamburger/hamburger.template.htm',
			controller  : 'hamburgerController'
		})

		// default route
		.otherwise({
               redirectTo: '/'
        });
		
			
});

	