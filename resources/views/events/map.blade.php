<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>Draggable directions</title>
        <style>
            #right-panel { font-family: 'Roboto','sans-serif';line-height: 30px;padding-left: 10px; }
            html, body { height: 100%;margin: 0;padding: 0; }
            #map { height: 100%;float: right;width: 100%; }
            .side-panel { float: left;width: 34%;height: 100%; }
            #right-panel { overflow: scroll; }
            .panel { height: 100%;overflow: auto; }
            .map-container { width: 100%;height: 100%; }
            .map-container .side-panel { position: absolute;z-index: 9;background: #fff;height: calc(100% - 40px);width: 335px;left: 10px;top: 10px;border-radius: 5px;overflow: auto;box-shadow: 2px 0px 3px rgba(0, 0, 0, 0.15);padding: 10px;box-sizing: border-box;font-family: Roboto,Arial,sans-serif; }
            .map-container .side-panel h3 { font-size: 16px;line-height: 1.3125em;color: #d32323;margin: 0;font-weight: 600; }
            ul.direction_mode { list-style: none;margin: 20px 0 20px 0;padding: 0;display: flex; }
            ul.direction_mode li { width: 25%;text-align: center;padding-bottom: 5px;position: relative; }
            ul.direction_mode li svg { width: 22px;height: 25px;opacity: .6; }
            ul.direction_mode li:after { content: '';width: 100%;height: 1px;position: absolute;background: #676667;left: 0;bottom: 0; }
            ul.direction_mode li.active:after { background: #d32323;height: 3px; }
            ul.direction_mode li.active svg { opacity: 1; }
            .map-container .side-panel::-webkit-scrollbar{width:10px; }
            .map-container .side-panel::-webkit-scrollbar-thumb{border-radius:10px;background-color:#b8b8b8;border:2px solid #fff; }
            .map-container .side-panel::-webkit-scrollbar-thumb:hover{background-color:grey;border:2px solid #fff; }
            .map-container .side-panel .start_from { font-size: 14px; }
            .map-container .side-panel .start_from a.Swap { float: right;color: #0073bb;font-weight: 100;font-size: 12px;text-decoration: none; }
            .map-container .side-panel .enter_location { float: left;width: 100%;margin-top: 5px;position: relative; }
            .map-container .side-panel .enter_location input#location { width: 100%;padding: 8px 8px 8px 30px;border: solid 1px #ddd;box-sizing: border-box;border-radius: 5px;outline: none; }
            .map-container .side-panel .enter_location #location_icon { position: absolute;width: 17px;left: 8px;top: 7px; }
            .map-container .side-panel .enter_location #location_icon path { fill: #0073bb; }
            .map-container .side-panel .enter_location i { position: relative;padding-left: 30px;box-sizing: border-box;font-size: 13px;font-style: normal;margin-top: 10px;display: block;margin-bottom: 15px; }
            .map-container .side-panel .enter_location i #location_icon_bullet { position: absolute;width: 17px;left: 8px;top: -1px; }
            .map-container .side-panel .enter_location i #location_icon_bullet path{ fill: #d32323; }
            .map-container .side-panel button.GetDirectionBtn { color: white;background-color: #d90007;background: -webkit-linear-gradient(#d90007, #c91400);background: linear-gradient(#d90007, #c91400);padding: 5px 8px;font-size: 12px;line-height: 1.5em;border-radius: 3px;box-sizing: border-box;border: solid 1px #8d0005;font-weight: 600;cursor: pointer; }
            .map-container .side-panel button.GetDirectionBtn:hover{ background-color: #ed0008;background: -webkit-linear-gradient(#ed0008, #dd1600);background: linear-gradient(#ed0008, #dd1600); }
            .map-container .side-panel .Driving_directions { border-top: solid 1px #b3b3b3;border-bottom: solid 1px #b3b3b3;padding: 9px;margin-top: 15px;margin-bottom: 5px; }
            .map-container .side-panel #right-panel { padding-left: 0;overflow: auto; }
            .map-container .side-panel #right-panel table.adp-placemark tr td img { width: 15px;height: 25px;position: relative;top: 4px; }
            .map-container .side-panel #right-panel table.adp-placemark { background: none;border-left: none;border-right: 0;margin-top: -6px; }
            .adp-step, .adp-substep{ font-size: 14px; }
            .adp-step b, .adp-substep b { font-weight: 600 !important; }
            #mode { text-transform: lowercase;display: inline-block; }
            #mode:first-letter { text-transform: uppercase; }
            @media only screen and (max-width: 727px) {
                .map-container .side-panel { position: static;z-index: 9;background: #fff;height: calc(63% - 40px);width: 100%;left: 10px;top: 10px;border-radius: 0;overflow: auto;box-shadow: none;padding: 10px;box-sizing: border-box;font-family: Roboto,Arial,sans-serif;margin-bottom: 0; }
                #map { height:45%;}
            }
        </style>
    </head>
    <body>
        <div class="map-container">
            <div class="side-panel">
                <h3>Get directions</h3>
                <ul class="direction_mode" id="direction_mode">
                    <li class="active" data-mode="DRIVING">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="459px" height="459px" viewBox="0 0 459 459" style="enable-background:new 0 0 459 459;" xml:space="preserve">
                        <g>
                        <g id="time-to-leave">
                        <path d="M405.45,51c-5.101-15.3-20.4-25.5-35.7-25.5H89.25c-17.85,0-30.6,10.2-35.7,25.5L0,204v204c0,15.3,10.2,25.5,25.5,25.5H51
                              c15.3,0,25.5-10.2,25.5-25.5v-25.5h306V408c0,15.3,10.2,25.5,25.5,25.5h25.5c15.3,0,25.5-10.2,25.5-25.5V204L405.45,51z
                              M89.25,306C68.85,306,51,288.15,51,267.75s17.85-38.25,38.25-38.25s38.25,17.85,38.25,38.25S109.65,306,89.25,306z M369.75,306
                              c-20.4,0-38.25-17.85-38.25-38.25s17.85-38.25,38.25-38.25S408,247.35,408,267.75S390.15,306,369.75,306z M51,178.5L89.25,63.75
                              h280.5L408,178.5H51z"/>
                        </g>
                        </g>
                        </svg>
                    </li>
                    <li data-mode="WALKING">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 470.642 470.642" style="enable-background:new 0 0 470.642 470.642;" xml:space="preserve">
                        <g>
                        <g>
                        <path style="fill:#010002;" d="M223.821,76.022c10.333-0.333,19-4.333,26-12s10.333-16.667,10-27
                              c-0.333-10.335-4.167-19.168-11.5-26.5c-7.333-7.333-16.167-10.833-26.5-10.5s-19,4.333-26,12s-10.5,16.667-10.5,27
                              s3.833,19.167,11.5,26.5S213.488,76.355,223.821,76.022z"/>
                        <path style="fill:#010002;" d="M350.321,202.522l-55-30l-45-72c-8.667-10.667-19.333-16-32-16c-8.667,0-17,3.667-25,11l-68,69
                              c-2,2.667-3.333,5.667-4,9l-9,77v2c0,4.666,1.667,8.666,5,12c3.333,3.332,7.333,5,12,5s8.5-1.668,11.5-5c3-3.334,4.833-7,5.5-11
                              l7-66l24-24l-22,184l-39,87.001c-1.333,4-2,7.658-2,11.002c0,7.322,2.5,13.5,7.5,18.5s11.167,7.164,18.5,6.5
                              c10,0,17.333-4.678,22-14l42-94.002c0-0.67,0.333-1.835,1-3.5c0.668-1.67,1.335-3.17,2-4.5c0.667-1.335,1-2.67,1-4l5-45.001
                              l43,148.003c4.667,12,13,17.666,25,17c6.667,0,12.5-2.5,17.5-7.5s7.5-11.178,7.5-18.5c0-0.678-0.167-1.5-0.5-2.5
                              s-0.5-1.836-0.5-2.502l-60-205.001l7-67l17,27c1.333,2,3,3.667,5,5l59,33c4,1.333,6.667,2,8,2c4.667,0,8.667-1.833,12-5.5
                              c3.333-3.668,5-7.834,5-12.5C358.321,210.522,355.654,205.855,350.321,202.522z"/>
                        </g>
                        </g>
                        </svg>
                    </li>
                    <li data-mode="TRANSIT">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 491 491" style="enable-background:new 0 0 491 491;" xml:space="preserve">
                        <g>
                        <g>
                        <path style="fill:#010002;" d="M348.5,377l-1-2c0-0.667,0.167-1,0.5-1s0.5-0.333,0.5-1c10.667-4,20.333-9.333,29-16
                              s14.667-16.333,18-29l0.5-3.5c0.333-2.333,0.833-4.5,1.5-6.5V57c0-6.667-1.833-13.333-5.5-20c-3.67-6.667-8.336-12.667-14-18
                              c-5.667-5.333-12-9.833-19-13.5S345.5,0,339.5,0h-187c-6,0-12.5,1.667-19.5,5s-13.333,7.667-19,13s-10.334,11.333-14,18
                              c-3.667,6.667-5.5,13-5.5,19v265c0,4.667,1,9.333,3,14s4.667,9.167,8,13.5s7,8.333,11,12s8,6.5,12,8.5
                              c2,0.667,5.167,1.834,9.5,3.5c4.333,1.667,6.5,2.834,6.5,3.5l-77,116h45l56-81h154l56,81h45L348.5,377z M201.5,23
                              c0-2,0.833-4,2.5-6s3.5-3,5.5-3h72c0.667,0,2,0.667,4,2s3,2.667,3,4v28c0,2-0.833,3.667-2.5,5s-3.167,2-4.5,2h-72
                              c-1.333-0.667-2.333-1.333-3-2c-1.333-0.667-2.333-1.667-3-3c-1.333-1.337-2-2.67-2-4V23z M129.5,99c0-3.333,0.667-7,2-11
                              c2-3.339,4.333-6.673,7-10c2-2.667,4.833-5,8.5-7s7.5-3,11.5-3h174c2.667,0,6,1,10,3c2.667,1.333,5.667,3.333,9,6
                              c2.667,2,4.667,4.667,6,8c2,2.667,3,6,3,10v59c0,3.333-1,6.5-3,9.5s-4.333,5.833-7,8.5c-3.333,2.667-6.667,4.667-10,6
                              c-2.667,1.333-6,2-10,2h-171c-0.667,0-1.667-0.167-3-0.5s-2.333-0.833-3-1.5c-6.667-0.667-12.333-3.833-17-9.5s-7-11.833-7-18.5
                              V99z M181,330c-5.667,6-12.833,9-21.5,9s-15.667-3-21-9s-8-13.333-8-22c0-8,2.833-14.833,8.5-20.5s12.5-8.5,20.5-8.5
                              c8.667,0,15.834,2.667,21.5,8c5.667,5.333,8.5,12.333,8.5,21S186.667,324,181,330z M309,330c-5.667-6-8.5-13.333-8.5-22
                              s3-15.667,9-21s13-8,21-8c8.667,0,15.667,2.833,21,8.5s8,12.5,8,20.5c0,8.667-2.667,16-8,22s-12.333,9-21,9
                              C321.832,339,314.665,336,309,330z"/>
                        </g>
                        </g>
                        </svg>
                    </li>
                    <li data-mode="BICYCLING">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve">
                        <g>
                        <g>
                        <path d="M408.084,217.721c-5.005,0-9.926,0.363-14.744,1.051L354.252,86.447h-58.78v30h36.36l13.045,44.162l-152.849,26.998
                              l-20.613-36.737h21.415v-30h-74.757v30h18.943l31.89,56.837l-18.031,21.248c-14.112-7.18-30.071-11.232-46.96-11.232
                              C46.616,217.721,0,264.338,0,321.638s46.616,103.915,103.915,103.915c50.129,0,92.081-35.68,101.795-82.978l71.582,4.158
                              l44.366-151.559l31.771-5.612l11.142,37.721c-35.626,16.495-60.403,52.583-60.403,94.354c0,57.299,46.616,103.915,103.915,103.915
                              s103.916-46.616,103.916-103.915S465.384,217.721,408.084,217.721z M104.785,306.662l-1.739,29.949l72.249,4.197
                              c-8.467,31.491-37.253,54.744-71.38,54.744C63.158,395.552,30,362.394,30,321.638c0-40.757,33.158-73.915,73.915-73.915
                              c37.096,0,67.887,27.472,73.121,63.137L104.785,306.662z M255.206,315.399l-47.771-2.775
                              c-2.244-25.991-14.09-49.279-31.972-66.279l25.304-29.817l87.928-15.531L255.206,315.399z M408.084,395.552
                              c-40.757,0-73.915-33.158-73.915-73.915c0-28.148,15.82-52.665,39.031-65.145l20.498,69.395l28.771-8.499l-20.498-69.393
                              c2.018-0.166,4.052-0.273,6.112-0.273c40.757,0,73.916,33.158,73.916,73.915C481.999,362.394,448.842,395.552,408.084,395.552z"/>
                        </g>
                        </g>
                        </svg>
                    </li>
                </ul>
                <div class="start_from">
                    <span><b>Start From</b></span>
                    <!--<a href="#" class="Swap">Swap start / end point</a>-->
                </div>
                <div class="enter_location">
                    <svg version="1.1" id="location_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 54.757 54.757" style="enable-background:new 0 0 54.757 54.757;" xml:space="preserve">
                    <path d="M40.94,5.617C37.318,1.995,32.502,0,27.38,0c-5.123,0-9.938,1.995-13.56,5.617c-6.703,6.702-7.536,19.312-1.804,26.952
                          L27.38,54.757L42.721,32.6C48.476,24.929,47.643,12.319,40.94,5.617z M27.557,26c-3.859,0-7-3.141-7-7s3.141-7,7-7s7,3.141,7,7
                          S31.416,26,27.557,26z"/>
                    </svg>
                    <input type="text" name="location" id="location">
                    <i><svg version="1.1" id="location_icon_bullet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 54.757 54.757" style="enable-background:new 0 0 54.757 54.757;" xml:space="preserve">
                        <path d="M40.94,5.617C37.318,1.995,32.502,0,27.38,0c-5.123,0-9.938,1.995-13.56,5.617c-6.703,6.702-7.536,19.312-1.804,26.952
                              L27.38,54.757L42.721,32.6C48.476,24.929,47.643,12.319,40.94,5.617z M27.557,26c-3.859,0-7-3.141-7-7s3.141-7,7-7s7,3.141,7,7
                              S31.416,26,27.557,26z"/>
                        </svg> {{ $event->formatted_address }}</i>
                </div>
                <button type="button" class="GetDirectionBtn">Get Direction</button>
                <div id="right-panel">
                    <div class="Driving_directions"><span id="mode">Driving directions</span><span id="total"></span></div>
                </div>
            </div>
            <div id="map"></div>
        </div>
        <script src="{{ URL::asset('js/jquery.js') }}"></script>
        <script>
                var from_lat,from_lng;
                var to_lat,to_lng;
                to_lat = "{{ $event->latitude }}";
                to_lng = "{{ $event->longitude }}";
                @if(Session::has('latitude') && Session::has('longitude'))  
                from_lat = "{{ $user_lat }}";
                from_lng = "{{ $user_lng }}";
                @endif
                function initMap() {
                    var myLatLng = { lat: to_lat, lng: to_lng };
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 10,
                        center: myLatLng  
                    });

                    var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                        title: 'Hello World!'
                    });

                    var directionsService = new google.maps.DirectionsService;
                    var directionsDisplay = new google.maps.DirectionsRenderer({
                        draggable: true,
                        map: map,
                        panel: document.getElementById('right-panel')
                    });

                    //        directionsDisplay.addListener('directions_changed', function() {
                    //          computeTotalDistance(directionsDisplay.getDirections());
                    //        });

                    $(document).on('click','.GetDirectionBtn',function(){
                        if(!$("#location").val()){
                            @if(Session::has('latitude') && Session::has('longitude'))  
                                from_lat = "{{ $user_lat }}";
                                from_lng = "{{ $user_lng }}";
                            @endif
                        }
                        $(".direction_mode li.active").trigger('click');

                        console.log(from_lat);
                        console.log(from_lng);
                    });



                    $(document).on("click",".direction_mode li",function(){
                        $(".Driving_directions").next().remove();
                        $('.direction_mode li').removeClass('active');
                        $(this).addClass('active');
                        var mode = $(this).attr('data-mode');
                        $("#mode").text(mode+' directions');
                        if(from_lat !=undefined && from_lng !=undefined){
                            var start = new google.maps.LatLng(from_lat, from_lng);
                            var end = new google.maps.LatLng(to_lat, to_lng);
                            computeTotalDistance(directionsDisplay.getDirections());
                            displayRoute(start, end, directionsService,
                                directionsDisplay,mode,marker);
                        }else{
                              $("#right-panel").append("<div>We didn't recognize one of your addresses. Please enter at least a city and a state or a ZIP code.</div>")
                        }
                    });
                }

                function displayRoute(origin, destination, service, display,mode,marker) {
                    service.route({
                        origin: origin,
                        destination: destination,
                        travelMode: google.maps.TravelMode[mode],
                        avoidTolls: true
                    }, function (response, status) {
                        if (status === 'OK') {
                            marker.setMap(null);
                            display.setDirections(response);
                        } else {
                            $(".Driving_directions").next().remove();
                            $("#total").text('');
                            $("#right-panel").append("<div>We didn't recognize one of your addresses. Please enter at least a city and a state or a ZIP code.</div>")
    //                        alert('Could not display directions due to: ' + status);
                        }
                    });
                }

                function computeTotalDistance(result) {
                    var total = 0;
                    if(result != undefined){
                        var myroute = result.routes[0];
                        for (var i = 0; i < myroute.legs.length; i++) {
                            total += myroute.legs[i].distance.value;
                        }
                        total = total / 1000;
                        document.getElementById('total').innerHTML = total + ' km';
                    }
                }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZGTC412EEKYBmKXxH9VFnE97fKNsu0zQ&callback=initMap&libraries=places"></script>
        <script>
            function initialize() {

                var autocomplete = new google.maps.places.Autocomplete(document.getElementById('location'));
                autocomplete.addListener('place_changed', function () {
                    var place = autocomplete.getPlace();
                     from_lat = place.geometry.location.lat();
                     from_lng = place.geometry.location.lng();
                    //                    alert(place.geometry.location.lat());
                });

            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </body>
</html>