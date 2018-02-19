/* Google Maps ------------------------- */
function init() {
    var latlng = new google.maps.LatLng(-22.472126, -43.825582);
    var opcoes = {
        zoom: 18,
        center: latlng,
        scrollwheel: false,
        scaleControl: false,
        disableDefaultUI: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("mapa"), opcoes);
    var marcador = "imagens/marker.png";
    var marker = new google.maps.Marker({
        map: map,
        animation: google.maps.Animation.DROP,
        icon: marcador,
        position: map.getCenter()
    });
    var conteudo = 'INTEGRA';
    var infowindow = new google.maps.InfoWindow({
        content: conteudo
    });
    google.maps.event.addListener(marker, 'click', function () {
        infowindow.open(map, marker);
    });
}
init();