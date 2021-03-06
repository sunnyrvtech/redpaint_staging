var app = angular.module('redPaintApp', ['ngSanitize'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('redPaintController', ['$scope', '$http', '$sce', '$compile', '$timeout', function ($scope, $http, $sce, $compile, $timeout) {

        $scope.login = {};
        $("#loaderOverlay").show();
        $("#alert_loading").show();
        $scope.submitLogin = function (isValid) {
            $scope.loading = true;
            // check to make sure the form is completely valid
            if (isValid) {
                $http({
                    method: 'POST',
                    url: BaseUrl + '/login',
                    data: 'email=' + $scope.login.email + '&password=' + $scope.login.password + '&type=' + $scope.login.type,
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
                    data: 'first_name=' + $scope.register.first_name + '&last_name=' + $scope.register.last_name + '&email=' + $scope.register.email + '&password=' + $scope.register.password + '&password_confirmation=' + $scope.register.password_confirmation + '&type=' + $scope.register.type,
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

        $scope.submitChangePassword = function (isValid) {
            if (isValid) {
                $http({
                    method: 'POST',
                    url: BaseUrl + '/account/change/password',
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

        //   ajax request send for subscription 
        $scope.submitSubscriptionAjax = function ($Url, $Id, $method) {
            $scope.loading = true;
            $http({
                method: $method,
                url: $Url,
                data: {id: $Id},
                headers: {'Content-Type': 'application/json'}
            }).then(function (data, status, headers, config) {
                $scope.loading = false;
                $scope.alert_loading = true;
                $scope.alertClass = 'alert-success';
                $scope.alertLabel = 'Success!';
                $scope.alert_messages = data.data.messages;
                $scope.alertHide();
                $("#confirmationModal").modal('hide');
                $("#confirmationModal button").attr('disabled', false);
                $(".modal-backdrop").remove();
                var $e1 = $('#content').html(data.data.html);
                $compile($e1)($scope);
                $(window).scrollTop(0);
            }, function errorCallback(data) {
                $scope.loading = false;
                $scope.alert_loading = true;
                $scope.alertClass = 'alert-danger';
                $scope.alertLabel = 'Error!';
                $scope.alert_messages = data.data.error;
                $("#confirmationModal").modal('hide');
                $("#confirmationModal button").attr('disabled', false);
                $scope.alertHide();
                $(window).scrollTop(0);

            });
        }

        $scope.submitNewsletter = function (isValid) {
            $scope.loading = true;
            $scope.isDisabled = true;
            $http({
                method: 'POST',
                url: BaseUrl + '/newsletter',
                data: 'email=' + $scope.news,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data, status, headers, config) {
                $scope.loading = false;
                $scope.news_msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>' + data.data.success + '</div>';
            }, function errorCallback(data) {
                $scope.loading = false;
                $scope.news_msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> ' + data.data.error + '</div>';
            });
            $timeout(function () {
                $scope.isDisabled = false;
                $scope.news_msg = false;
            }, 8000);
        }
        $scope.filterByDay = function ($day) {
            if ($day) {
                window.history.pushState("", "", BaseUrl + '/search?keyword=daily_deals&day=' + $day);
                $scope.loading = true;
                $http({
                    method: 'GET',
                    url: BaseUrl + '/search',
                    params: {keyword: 'daily_deals', day: $day},
                    headers: {'Content-Type': 'application/json'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    var $e1 = $('#content').html(data.data.html);
                    $compile($e1)($scope);
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

        $scope.submitZipRegion = function ($zipCode) {
            $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDZGTC412EEKYBmKXxH9VFnE97fKNsu0zQ&address=' + $zipCode + '&sensor=true', function (data) {
                //console.log(data.results[0]);
                if (data.status != "ZERO_RESULTS") {
                    for (var i = 0; i < data.results[0].address_components.length; i++) {
                        var addr = data.results[0].address_components[i];
                        if (addr.types[0] == ['administrative_area_level_1']) {
                            $("#state").val(addr.short_name);
                        }
                        if (addr.types[0] == ['administrative_area_level_2']) {
                            $("#city").val(addr.short_name);
                        }
                        if (addr.types[0] == ['locality']) {
                            $("#address").val(addr.long_name);
                        }
                        if (addr.types[0] == ['country']) {
                            var countryId = $('#country_id option').filter(function () {
                                return $(this).html() == addr.long_name;
                            }).val();
                            $('#country_id').val(countryId);
                        }
                    }
                }
            });
        }
        $scope.EventLikes = function ($eventId, $url) {
            $http({
                method: 'POST',
                url: $url,
                data: 'event_id=' + $eventId,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data, status, headers, config) {
                $scope.like.text = data.data.like_txt;
                $scope.like.count = data.data.like_count;
                $scope.like.class = data.data.like_class;
                $scope.like.title = data.data.like_title;
            }, function errorCallback(data) {
                $scope.loading = false;
                $scope.alert_loading = true;
                $scope.alertClass = 'alert-danger';
                $scope.alertLabel = 'Error!';
                $scope.alert_messages = "Something went wrong,please try again !";
                $scope.alertHide();
                $(window).scrollTop(0);
            });
        }

        $scope.submitUserLocation = function ($Url, $latitude, $longitude) {
            $scope.loading = true;
            $http({
                method: 'POST',
                url: $Url,
                data: 'latitude=' + $latitude + '&longitude=' + $longitude,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data, status, headers, config) {
                window.location.reload();
            }, function errorCallback(data) {
                window.location.reload();
            });
        }



        $scope.choosePlan = function ($Id) {
            $scope.paymentForm = true;
            $scope.planForm = false;
//             $("#plan").val($Id);
            $("#plan option[value='" + $Id + "']").prop('selected', true);

        }



        // hide alert after 5 second
        $scope.alertHide = function () {
            $timeout(function () {
                $scope.alert_loading = false;
            }, 8000);
        }

//        $scope.init();

    }]);