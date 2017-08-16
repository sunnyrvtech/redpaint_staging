var app = angular.module('redPaintApp', [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('authController', ['$scope', '$http', function ($scope, $http) {

        $scope.login = {};

        $scope.submitLogin = function (isValid) {
            //$scope.loading = true;
            // check to make sure the form is completely valid
            if (isValid) {
                $http({
                    method: 'POST',
                    url: BaseUrl + '/login',
                    data: 'email=' + $scope.login.email + '&password=' + $scope.login.password,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    window.location = BaseUrl + "/admin";

                }, function errorCallback(data) {
                    alert(data.data.error);
                });
            }
        };

    }]);