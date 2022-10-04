<div class="location-container">
    <div class="location-left-section">
        <h1 class="location-header">We are here to help <br> call <strong> 020 7405 1477</strong> or <strong> 0121 236 4415</strong> </h1>
        <p class="location-description">Visit us at
            <strong> 20 Beauchamp Pl, Knightsbridge, London SW3 1NQ </strong> and <strong> 46 Warstone Ln, Hockley, Birmingham B18 6JJ </strong> </p>
        <p class="location-button">
            <a href="{{ route('contact') }}" class="btn btn-block">BOOK APPOINTMENT</a>
        </p>
    </div>
    <div class="location-right-section">
        <div id="location_map" style="height: 500px; width:100%;"></div>
    </div>
</div>

<script>
    /** show map on window load */
window.onload = initLocationMap
function initLocationMap() {
  const locations = [
    { lat: 52.4868666, lng: -1.9121149 },
    { lat: 51.4976029, lng: -0.1644648 }
  ];
  
  /** Create map  */
  var bounds = new google.maps.LatLngBounds();
  const map = new google.maps.Map(document.getElementById("location_map"), {
    zoom: 7.5,
    center: locations[0],
    // disableDefaultUI: true,
    // mapTypeId: 'satellite'.
  });
  map.setMapTypeId('terrain');

  /** Add multiple markers to the map */
  for (i = 0; i < locations.length; i++) {
    const marker = new google.maps.Marker({
      position: locations[i],
      map: map,
      icon: '{{ asset("images/map_marker.png") }}'
    });
    bounds.extend(marker.position);
  }
  /** set center of all markers */
  map.fitBounds(bounds);
}
</script>