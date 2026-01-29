$(document).ready(function() { //Jquery thing, prepare HTML before running
    
    function loadWeatherData() {
        if ($("#map-container").length) { //length is 1 in index.php, it's 0 in login/register
            $("#favorites-list").empty(); //clear favs
                //These are all map operations
            $.ajax({ //talk to php without reloading
                url: 'api_clima.php', //who
                type: 'GET', //what
                dataType: 'json',
                success: function(data) {
                    var hasFavorites = false;

                    $.each(data, function(index, item) { //item is the city info 
                        var iconHtml = `
                            <div class="marker-content">
                                <img src="${item.img}" class="marker-img" alt="${item.condition}">
                                <div class="marker-temp">${item.temp}ºC</div>
                            </div>
                        `;

                        var customIcon = L.divIcon({ //Leaflet custom icon
                            className: 'custom-poke-marker',
                            html: iconHtml,
                            iconSize: [50, 50],
                            iconAnchor: [25, 25],
                            popupAnchor: [0, -30] //-30 goes up, not down
                        });

                        var marker = L.marker([item.lat, item.lng], { icon: customIcon }).addTo(window.mapInstance); //Put the poke-icon in the coordinate
                            //icons exist in memory without addTo, but no icon is shown
                        var heartClass = '';
                        if (item.is_favorite == true) {
                                heartClass = 'active'; //red heart
                        }
                            //fast input, inline css
                        var popupContent = `
                            <div style="text-align:center;">
                                <strong>${item.city_name}</strong><br>
                                <span style="color:gray;">${item.condition}</span><br>
                                <button class="fav-btn ${heartClass}" data-id="${item.id}">&#10084;</button>
                            </div>`;
                            //&#10084; is heart symbol
                        marker.bindPopup(popupContent); //bindpopup is leaflet function, it's a click event listener

                        if (item.is_favorite) {
                            hasFavorites = true;
                            var favHtml = `
                                <div class="fav-card">
                                    <strong>${item.city_name}</strong><br>
                                    <img src="${item.img}"><br>
                                    <span>${item.temp}ºC</span>
                                </div>
                            `;
                            $("#favorites-list").append(favHtml);
                        }
                    });

                    if (!hasFavorites) {
                        $("#favorites-list").html('<p>No favorite cities saved yet.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        }
    } //END OF THE FUNCTION

    if ($("#map-container").length) {
        //This makes the map start on Madrid, Spain with zoom level 6
        window.mapInstance = L.map('map-container').setView([40.4168, -3.7038], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            // {s} is subdomain, {z} is zoom, {x} and {y} are coordinates
            attribution: '&copy; OpenStreetMap' //I was advised to do this
        }).addTo(window.mapInstance);
        loadWeatherData();
    }

    if ($("#admin-map").length) {
        var adminMap = L.map('admin-map').setView([40.416, -3.703], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(adminMap);
        //Same thing as before
        var currentMarker = null; //Mickey herramienta

        adminMap.on('click', function(e) {
            //Fixed to 6 decimal
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);
            $("#input-lat").val(lat);
            $("#input-lng").val(lng);

            //Things if there is a previous marker
            if (currentMarker) adminMap.removeLayer(currentMarker);
            currentMarker = L.marker([lat, lng]).addTo(adminMap);
        });
    }

    $(document).on('click', '.fav-btn', function() {
        var btn = $(this); //the clicked one
        var locId = btn.data('id'); //id of the location (Madrid is 5)

        $.ajax({
            url: 'api_favorites.php',
            type: 'POST',
            data: { location_id: locId },
            success: function(response) { //we send the id of the fav
                location.reload(); //it's easier than changing everything
            }
        });
    });
});