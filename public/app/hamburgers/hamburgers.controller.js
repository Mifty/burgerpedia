// create the controller and inject Angular's $scope
    BurgerPedia.controller('hamburgersController', function hamburgersController($scope, $http, $location, constants) {
		// set our current page for pagination purposes
		 $scope.currentPage=1;
		 $scope.lastPage=1;
		 $scope.loadMoreText='Load More Burgers...';
		
		//retrieve hamburgers listing from API
		$http.get(constants.API_URL + "hamburgers", {params: { page: $scope.currentPage }})
			.success(function(response) {
				$scope.hamburgers = response.data;
				$scope.currentPage = response.current_page;
				$scope.lastPage = response.last_page;
				
				if($scope.currentPage >= $scope.lastPage){
					$scope.loadMoreText='All Burgers Loaded!';
				}
			});
		
		// infinite scroll of the hamburgers
		$scope.loadMoreBurgers = function() {
			// increase our current page index
			$scope.currentPage++;
			
			
			//retrieve hamburgers listing from API and append them to our current list
			$http.get(constants.API_URL + "hamburgers", {params: { page: $scope.currentPage }})
				.success(function(response) {
					$scope.hamburgers = $scope.hamburgers.concat(response.data);
					$scope.currentPage = response.current_page;
					$scope.lastPage = response.last_page;
					
					if($scope.currentPage >= $scope.lastPage){
						$scope.loadMoreText='All Burgers Loaded!';
					}
				});
				
		};
		
		// adding a burger
		$scope.addBurger = function() {
				
			//add the new hamburger to our listing
			$http.post(constants.API_URL + "hamburgers", $scope.hamburger)
				.success(function(response) {
					
					console.log(response);
					
					// close the modal
					$scope.closeModal();
					
					// load the page for our newly created burger
					$scope.loadBurgerPage(response.id);
					

				})
				.error(function(response, status, headers, config) {
					// alert and log the response
					alert('Failed to add the burger: [Server response: '+status + '] - ' +response.name[0]);
					console.log(response);
					
				});

		}
		
		// load the page for an individual burger
		$scope.loadBurgerPage = function(id){
			 $location.path("hamburger/"+id);
		}
		
		// display the modal form
		$scope.showModal = function() {
			$('#addBurgerModal').modal('show');
		}
		
		// display the modal form
		$scope.closeModal = function() {
			$('#addBurgerModal').modal('hide');
		}
	});