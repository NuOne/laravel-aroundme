function initMap() {
    var center = {lat:6.9271,lng:79.8612};
    var map = new google.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 15
    });

    var input = document.getElementById('pac-input');

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var infowindow = new google.maps.InfoWindow();

    var marker = new google.maps.Marker({
        map: map
    });

    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    var service = new google.maps.places.AutocompleteService();

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
            map.setZoom(15);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(15);
        }

        marker.setPlace({
            placeId: place.place_id,
            location: place.geometry.location
        });
        marker.setVisible(true);

        var service = new google.maps.places.PlacesService(map);

        service.nearbySearch({
            location: place.geometry.location,
            radius: 1000
        }, callback);
    });

    function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
                createMarker(results[i]);
            }
        }
    }

    function createMarker(place) {

        var placeLoc = place.geometry.location;

        var gpmarker    = new google.maps.MarkerImage(place.icon, null, null, null, new google.maps.Size(25, 25));

        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location,
            icon: gpmarker
        });

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + place.vicinity + '</div>');
            infowindow.open(map, this);

            $.ajax({
                url: "ajax/places",
                data: {'placeId': place.place_id},
                method :"GET",
                success: function(data){
                    if(data.success == true)
                        $('#infowindow-content').html(data.data);
                },
                dataType: "json"
            });
        });
    }
}