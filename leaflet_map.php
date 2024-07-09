<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive Leaflet Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <style>
        #map {
            height: 600px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Interactive Leaflet Map</h1>
    <button class="update-map" data-variable="VHM0">Toggle VHM0</button>
    <button class="update-map" data-variable="VTM01_SW1">Toggle VTM01_SW1</button>
    <button class="update-map" data-variable="VTM01_SW2">Toggle VTM01_SW2</button>
    <button class="update-map" data-variable="VTM10">Toggle VTM10</button>
    <div id="map"></div>
    
    <script>
        $(document).ready(function(){
            var map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            var markerClusters = L.markerClusterGroup();
            map.addLayer(markerClusters);

            var layers = {};  // Define layers object

            function getColor(value) {
                // Define color scale based on value
                return value > 5 ? '#800026' :
                       value > 4 ? '#BD0026' :
                       value > 3 ? '#E31A1C' :
                       value > 2 ? '#FC4E2A' :
                       value > 1 ? '#FD8D3C' :
                       value > 0.5 ? '#FEB24C' :
                       value > 0.1 ? '#FED976' :
                                    '#FFEDA0';
            }

            function updateMap(variable) {
                if (layers[variable]) {
                    markerClusters.removeLayer(layers[variable]);
                    delete layers[variable];
                } else {
                    $.ajax({
                        url: 'http://localhost:5000/data',  // Update this URL to your Flask app endpoint
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ variable: variable }),
                        success: function(response) {
                            if (response.error) {
                                console.error(response.error);
                                alert(response.error);
                                return;
                            }

                            console.log("Data received:", response);
                            var layerGroup = L.layerGroup();
                            
                            var longitude = response.longitude;
                            var latitude = response.latitude;
                            var variable_data = response.variable_data;
                            var variable_name = response.variable_name;

                            for (var i = 0; i < latitude.length; i += 10) { // Adjust step size to reduce number of markers
                                for (var j = 0; j < longitude.length; j += 10) { // Adjust step size to reduce number of markers
                                    var value = variable_data[i][j];
                                    if (value !== null) {
                                        var circle = L.circleMarker([latitude[i], longitude[j]], {
                                            color: getColor(value),
                                            fillColor: getColor(value),
                                            fillOpacity: 0.7,
                                            radius: 5
                                        });
                                        circle.bindPopup(variable_name + ': ' + value);
                                        layerGroup.addLayer(circle);
                                    }
                                }
                            }

                            markerClusters.addLayer(layerGroup);
                            layers[variable] = layerGroup;
                            console.log("Plotting complete.");
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching data:", status, error);
                            alert("Error fetching data: " + error);
                        }
                    });
                }
            }

            $('.update-map').on('click', function(){
                var variable = $(this).data('variable');
                updateMap(variable);
            });
        });
    </script>
</body>
</html>
