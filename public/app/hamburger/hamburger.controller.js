// create the controller and inject Angular's $scope
    BurgerPedia.controller('hamburgerController', function hamburgerController($scope, $http, $location, $routeParams, constants) {
		// set our current page for pagination purposes
		$scope.hamburger_id = $routeParams.hamburgerID;
		$scope.hamburger_name = "Unknown Burger";
		$scope.hamburger_author = "Saint Nick";
		$scope.hamburger_overview = "Ho Ho Ho";
		$scope.hamburger_created_date = "Christmas";
		
		// modal title
		$scope.modal_title = 'Add a new Description for '+$scope.hamburger_name;
		$scope.modal_button = "Add Description";
		
		// pagination
		$scope.currentPage=1;
		$scope.lastPage=1;
		$scope.loadMoreText='Load More Descriptions...';
		
		$http.get(constants.API_URL + "hamburgers/" + $scope.hamburger_id )
			.success(function(response) {
				$scope.descriptions = response.data;
				$scope.hamburger_name = response.name;
				$scope.hamburger_author = response.author;
				$scope.hamburger_overview = response.overview;
				$scope.hamburger_created_date = response.created_at;
				
				// got the burger, now get the descriptions from the API
				$http.get(constants.API_URL + "hamburgers/" + $scope.hamburger_id + "/descriptions")
					.success(function(response) {
						$scope.descriptions = response.data;
						$scope.currentPage = response.current_page;
						$scope.lastPage = response.last_page;
						
						if($scope.currentPage >= $scope.lastPage){
							$scope.loadMoreText='All Descriptions Loaded!';
						}
					})
					.error(function(response, status, headers, config) {
							// log the response
							console.log(response);
							
							// alert and log the response
							alert('Failed to get the burger descriptions: [Server response: '+status + '] - ' +response.name[0]);
							
						});
			})
			.error(function(response, status, headers, config) {
					// log the response
					console.log(response);
					
					// reload the main page
					$scope.loadBurgersPage();
					
				});
		
		// infinite scroll of the hamburgers
		$scope.loadMoreDescriptions = function() {
			// increase our current page index
			$scope.currentPage++;
			
			
			//retrieve descriptions listing from API and append them to our current list
			$http.get(constants.API_URL + "hamburgers/" + $scope.hamburger_id + "/descriptions", {params: { page: $scope.currentPage }})
				.success(function(response) {
					$scope.descriptions = $scope.descriptions.concat(response.data);
					$scope.currentPage = response.current_page;
					$scope.lastPage = response.last_page;
					
					if($scope.currentPage >= $scope.lastPage){
						$scope.loadMoreText='All Descriptions Loaded!';
					}
				});
				
		};
		
		// when talk about adding a description, it is either a new description or an exisitng one. the button value tells us what to do...
		// its not the cleanest way to do it but it works.
		$scope.addDescription = function(descriptionID){
			
			if($scope.modal_button == "Edit Description"){
				//edit the existing description to our hamburger
				$http.put(constants.API_URL + "hamburgers/" + $scope.hamburger_id + "/descriptions/"+descriptionID, $scope.description )
					.success(function(response) {
						
						console.log(response);
						
						// close the modal
						$scope.closeModal();
						
						// reload the page
						location.reload();

					})
					.error(function(response, status, headers, config) {
						// alert and log the response
						alert('Failed to edit the description: [Server response: '+status + '] - ' +response.name);
						console.log(response);
						
					});
			}else{
				//add the new description to our hamburger
				$http.post(constants.API_URL + "hamburgers/" + $scope.hamburger_id + "/descriptions", $scope.description)
					.success(function(response) {
						
						console.log(response);
						
						// close the modal
						$scope.closeModal();
						
						// reload the page
						location.reload();
						

					})
					.error(function(response, status, headers, config) {
						// alert and log the response
						alert('Failed to add the description: [Server response: '+status + '] - ' +response.name[0]);
						console.log(response);
						
					});
			}
		}
		
		$scope.deleteDescription = function(descriptionID){
			var confirmDelete = confirm('Are you sure you want to delete this description?');
			if (confirmDelete) {
				$http.delete(constants.API_URL + "hamburgers/" + $scope.hamburger_id + "/descriptions/"+descriptionID)
				.success(function(response) {
					
					console.log(response);
					$location.reload();
					

				})
				.error(function(response, status, headers, config) {
					// alert and log the response
					alert('Failed to add the description: [Server response: '+status + '] - ' +response.name[0]);
					console.log(response);
					
				});
			}else{
				return false;
			}
			
		}
		
		// load the burgers page
		$scope.loadBurgersPage = function(){
			 $location.path("hamburgers");
		}
		
		// display the modal form
		$scope.showModal = function(action,descriptionID) {
			
			 switch (action) {
				case 'edit':
					$scope.modal_title = "Edit Description for "+$scope.hamburger_name;
					$scope.modal_button = "Edit Description";
					$http.get(constants.API_URL + "hamburgers/" + $scope.hamburger_id + "/descriptions/"+descriptionID)
                        .success(function(response) {
                            console.log(response);
                            $scope.description = response;
                        });
					break;
				case 'add':
				default:
					$scope.description = null;
					$scope.modal_title = 'Add a new Description for '+$scope.hamburger_name;
					$scope.modal_button = "Add Description";
					break;
			}
		
			$('#addDescriptionModal').modal('show');
		}
		
		// close the modal form
		$scope.closeModal = function() {
			$('#addDescriptionModal').modal('hide');
		}
	});