admin.controller('Pins', [ "$scope", "$http", function($scope, $http) {
  $http.get('/admin/pin').then(function(response) {
    $scope.pins = response.data
  })

  $scope.generate = function() {
    let data = {
      account_type: $("select[name='account_type']").val(),
      upline_id: $("select[name='upline_id']").val(),
    }

    $http.post('/admin/pin', data).then(function(response) {
      $scope.pins.push(response.data)
    })
  }
}]);
