var app = angular.module('backEnd', ['ngSanitize'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('backEndController', ['$scope', '$http', '$sce', '$compile', '$timeout', function ($scope, $http, $sce, $compile, $timeout) {

        $scope.loading = false;
        $("#loaderOverlay").show();
        $("#alert_loading").show();



        $scope.init = function () {
            //$scope.loading = true;
            $timeout(function () {
                var renderHTML = $("#renderHtml").html();
                $("#renderHtml").html('');
                var $e1 = $('#renderHtml').html(renderHTML);
                $compile($e1)($scope);
            }, 800);
        }

        $scope.changeCategoryStatus = function ($id) {
            alert($id);
            //$scope.loading = true;
            $http({
                method: 'POST',
                url: BaseUrl + '/loginggggg',
                data: 'email=' + 'dddd',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data, status, headers, config) {
                $scope.loading = false;
                $scope.alert_loading = true;
                $scope.alertClass = 'alert-success';
                $scope.alertLabel = '';
                $scope.alert_messages = 'Login successfully!Redirecting.....';
                $(window).scrollTop(0);
                $timeout(function () {
                    window.location = BaseUrl + "/my-account";
                }, 2000);

                //console.log(data);
                // $scope.push(data.data);
//                $scope.loading = false;

            }, function errorCallback(data) {
                $scope.loading = false;
                $scope.alert_loading = true;
                $scope.alertClass = 'alert-danger';
                $scope.alertLabel = 'Error!';
                $scope.alert_messages = data.data.error;
                $scope.alertHide();
                $(window).scrollTop(0);
            });

        }

        // hide alert after 5 second
        $scope.alertHide = function () {
            $timeout(function () {
                $scope.alert_loading = false;
            }, 8000);
        }

        $scope.init();

    }]);