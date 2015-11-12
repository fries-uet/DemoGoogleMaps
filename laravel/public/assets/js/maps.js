var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 21.038993, lng: 105.783799},
        zoom: 13
    });
}