var app = angular.module('redPaintApp', ['ngSanitize'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('redPaintController', ['$scope', '$http', '$sce', '$compile', '$timeout', function ($scope, $http, $sce, $compile, $timeout) {

        $scope.login = {};
        $("#loaderOverlay").show();
        $("#alert_loading").show();
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
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = '';
                    $scope.alert_messages = 'Login successfully!Redirecting.....';
                    $(window).scrollTop(0);
                    $timeout(function () {
                        window.location = data.data.intended;
                    }, 2000);
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
        }

        $scope.submitRegister = function (isValid) {
            // check to make sure the form is completely valid
            if (isValid) {
                $scope.loading = true;
                $http({
                    method: 'POST',
                    url: BaseUrl + '/register',
                    data: 'first_name=' + $scope.register.first_name + '&last_name=' + $scope.register.last_name + '&email=' + $scope.register.email + '&password=' + $scope.register.password + '&password_confirmation=' + $scope.register.password_confirmation,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    if (data.data.error) {
                        $scope.alert_messages = data.data.error;
                    } else if (data.data.email) {
                        $scope.alert_messages = data.data.email[0];
                    } else if (data.data.password) {
                        $scope.alert_messages = data.data.password[0];
                    }
                    $scope.alertHide();
                    $(window).scrollTop(0);

                });
            }
        }

        $scope.submitChangePassword = function (isValid) {
            if (isValid) {
                $http({
                    method: 'POST',
                    url: BaseUrl + '/my-account/change-password',
                    data: 'password=' + $scope.password.password + '&confirm_password=' + $scope.password.confirm_password + '&current_password=' + $scope.password.current_password,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                    // $scope.push(data.data);
//                $scope.loading = false;

                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    if (data.data.error) {
                        $scope.alert_messages = data.data.error;
                    } else if (data.data.password) {
                        $scope.alert_messages = data.data.password[0];
                    } else if (data.data.password) {
                        $scope.alert_messages = data.data.confirm_password[0];
                    }
                    $scope.alertHide();
                    $(window).scrollTop(0);

                });
            }
        }

        $scope.forgotPassword = function () {
            $http.get(BaseUrl + '/password/email').
                    then(function (data, status, headers, config) {
                        var $e1 = $('#content').html(data.data);
                        $compile($e1)($scope);

                    });
        }

        $scope.submitResetPasswordLink = function (isValid) {
            if (isValid) {
                $scope.loading = true;
                $http({
                    method: 'POST',
                    url: BaseUrl + '/password/email',
                    data: 'email=' + $scope.reset.email,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $(window).scrollTop(0);
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
        }
        $scope.submitResetPassword = function (isValid) {
            if (isValid) {
                $scope.loading = true;
                $http({
                    method: 'POST',
                    url: BaseUrl + '/password/reset',
                    data: 'token=' + $scope.reset.token + '&email=' + $scope.reset.email + '&password=' + $scope.reset.password + '&password_confirmation=' + $scope.reset.password_confirmation,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages + '!Redirecting.....';
                    $(window).scrollTop(0);
                    $timeout(function () {
                        window.location = BaseUrl + "/";
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
        }
        // hide alert after 5 second
        $scope.alertHide = function () {
            $timeout(function () {
                $scope.alert_loading = false;
            }, 8000);
        }

//        $scope.init();

    }]);