admin.controller('Pins', [ "$scope", "$http", function($scope, $http) {
  $http.get('/admin/pin').then(function(response) {
    $scope.pins = response.data
  })

  $scope.generate = function() {
    $http.post('/admin/pin').then(function(response) {
      $scope.pins.push(response.data)
    })
  }
}]);
