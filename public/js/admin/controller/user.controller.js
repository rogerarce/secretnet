admin.controller('Users', [ "$scope", "$http", function($scope, $http) {

    $http.get('/admin/manager').then(function(response) {
      $scope.users = response.data
    });

    $scope.addUser = function() {
      let param = $scope.form;
      param.others = getData()
      $http.post('/admin/manager', param).then(function(response) {
        $scope.users.push(response.data)
      });
    }

    $scope.maxProfit = function(user_id) {
      $http.post('/admin/manager/max_profit/' + user_id).then(function(response) {
        return toastr.success('Successfully set user profit share to its maximum amount');
      })
    }

    function getData() {
      let pin = $("#pin").val()
      let upline_id = $("#uplineid").val()
      let position = $("input[name=position]:checked").val()
      let directref = $("#directref").val()
      let profitshare = $("input[name=profitshare]:checked").val()

      return {
        pin: pin,
        upline_id: upline_id,
        position: position,
        directref: directref,
        profitshare: profitshare,
      }
    }
}]);
