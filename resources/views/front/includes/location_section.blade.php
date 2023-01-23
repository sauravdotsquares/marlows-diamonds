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

// /** show map on window load */
// window.onload = function() {
//   initLocationMap(); 
// }

// function initLocationMap() {
  
//   const locations = [
//     { lat: 52.486912796211634, lng: -1.9119830200551595 },
//     { lat: 51.4976029, lng: -0.1644648 }
//   ];

//   // 52.486912796211634, -1.9119830200551595

//   const options = {
//     zoom: 18, // 7.5
//     center: new google.maps.LatLng(52.486902608199614, -1.9121013705836836), // locations[0],
//     streetViewControl: !1,
//     mapTypeControl: !1,
//     fullscreenControl: !1,
//     styles: [
//         { featureType: "administrative", elementType: "all", stylers: [{ saturation: "95" }, { lightness: "-48" }, { visibility: "on" }, { color: "#ff0000" }, { weight: "0.01" }] },
//         { featureType: "administrative", elementType: "geometry", stylers: [{ visibility: "on" }, { hue: "#00a3ff" }] },
//         { featureType: "administrative", elementType: "geometry.fill", stylers: [{ visibility: "on" }, { color: "#4a335a" }, { saturation: "45" }, { lightness: "-64" }] },
//         { featureType: "administrative", elementType: "geometry.stroke", stylers: [{ visibility: "off" }] },
//         { featureType: "administrative", elementType: "labels.text", stylers: [{ hue: "#ff0000" }, { visibility: "on" }, { saturation: "100" }, { lightness: "-50" }, { gamma: "1.60" }, { weight: "0.01" }] },
//         { featureType: "administrative", elementType: "labels.text.fill", stylers: [{ color: "#4a335a" }, { weight: "0.01" }, { visibility: "on" }] },
//         { featureType: "administrative.country", elementType: "geometry.fill", stylers: [{ saturation: "100" }, { lightness: "9" }, { weight: "6.25" }, { visibility: "on" }] },
//         { featureType: "administrative.neighborhood", elementType: "labels.text.fill", stylers: [{ color: "#4a335a" }] },
//         { featureType: "landscape", elementType: "all", stylers: [{ color: "#f7f5fa" }] },
//         { featureType: "landscape", elementType: "labels.icon", stylers: [{ hue: "#ff0000" }, { visibility: "off" }] },
//         { featureType: "poi",   elementType: "all", stylers: [{ visibility: "off" }] },

//         // { featureType: "poi.attraction",   elementType: "all", stylers: [{ visibility: "off" }] },
//         // { featureType: "poi.business.shopping",   elementType: "all", stylers: [{ visibility: "on" }] },
//         // { featureType: "poi.business.shopping",   elementType: "all", stylers: [{ visibility: "on", color: "#8e2e65" }] },
//         // { featureType: "poi.government",   elementType: "all", stylers: [{ visibility: "off" }] },
//         // { featureType: "poi.medical",   elementType: "all", stylers: [{ visibility: "off" }] },
//         // { featureType: "poi.park",   elementType: "all", stylers: [{ visibility: "off" }] },
//         // { featureType: "poi.place_of_worship",   elementType: "all", stylers: [{ visibility: "off" }] },
//         // { featureType: "poi.school",   elementType: "all", stylers: [{ visibility: "off" }] },
//         // { featureType: "poi.sports_complex",   elementType: "all", stylers: [{ visibility: "off" }] },
//         // elementType: "all", stylers: [{ visibility: "on" }]
//         // { featureType: "poi",  elementType: "labels.text.fill",  stylers: [{ color: "#d59563" }], },
//         // { featureType: "poi",   elementType: "all", stylers: [{ visibility: "on" }] }, // original
//         //   {
//         //     featureType: "poi",
//         //     elementType: "labels.text.fill",
//         //     stylers: [{ color: "#d59563" }],
//         //   },
//         //   {
//         //     featureType: "poi.park",
//         //     elementType: "geometry",
//         //     stylers: [{ color: "#263c3f" }],
//         //   },
//         //   {
//         //     featureType: "poi.park",
//         //     elementType: "labels.text.fill",
//         //     stylers: [{ color: "#6b9a76" }],
//         //   },

//         { featureType: "road", elementType: "all", stylers: [{ saturation: -100 }, { lightness: 45 }, { visibility: "on" }] },
//         { featureType: "road.highway", elementType: "all", stylers: [{ visibility: "simplified" }] },
//         { featureType: "road.highway", elementType: "geometry.fill", stylers: [{ visibility: "on" }, { color: "#e3cbe3" }, { saturation: "-30" }] },
//         { featureType: "road.arterial", elementType: "all", stylers: [{ visibility: "on" }] },
//         { featureType: "road.arterial", elementType: "geometry.fill", stylers: [{ color: "#e1cce1" }] },
//         { featureType: "road.arterial", elementType: "labels", stylers: [{ visibility: "simplified" }, { hue: "#9600ff" }, { saturation: "100" }, { lightness: "-71" }, { weight: "5.35" }] },
//         { featureType: "road.arterial", elementType: "labels.icon", stylers: [{ visibility: "off" }, { color: "#4a335a" }, { saturation: "18" }] },
//         { featureType: "road.local", elementType: "labels.text.fill", stylers: [{ color: "#4a335a" }, { saturation: "100" }, { lightness: "-55" }] },
//         { featureType: "transit", elementType: "all", stylers: [{ visibility: "off" }] },
//         { featureType: "transit.station", elementType: "all", stylers: [{ visibility: "on" }] },
//         { featureType: "transit.station", elementType: "labels", stylers: [{ visibility: "on" }] },
//         { featureType: "transit.station", elementType: "labels.text", stylers: [{ visibility: "on" }, { color: "#120722" }, { weight: "0.21" }, { gamma: "1.00" }, { lightness: "-30" }, { saturation: "0" }] },
//         { featureType: "transit.station.bus", elementType: "all", stylers: [{ visibility: "off" }] },
//         { featureType: "transit.station.bus", elementType: "geometry", stylers: [{ visibility: "off" }] },
//         { featureType: "transit.station.bus", elementType: "geometry.fill", stylers: [{ color: "#e40000" }, { visibility: "off" }] },
//         { featureType: "transit.station.bus", elementType: "geometry.stroke", stylers: [{ visibility: "off" }] },
//         { featureType: "transit.station.bus", elementType: "labels", stylers: [{ visibility: "off" }] },
//         { featureType: "water", elementType: "all", stylers: [{ color: "#e3cbe3" }, { visibility: "on" }] },
//     ],
// }
  
//   /** Create map  */
//   var bounds = new google.maps.LatLngBounds();
//   const map = new google.maps.Map(document.getElementById("location_map"), options);

//   /** Add multiple markers to the map */
//   for (i = 0; i < locations.length; i++) {
//     const marker = new google.maps.Marker({
//       position: locations[i],
//       map: map,
//       icon: '{{ asset("images/map_marker.png") }}'
//     });
//     google.maps.event.addListener(marker, 'click', markerOnClick);
//     bounds.extend(marker.position);  
//   }
//   /** set center of all markers */
//   map.fitBounds(bounds);

//   /** set zoom and center to clicked marker */
//   function markerOnClick(element){
//     if(map.zoom == 18){
//       map.fitBounds(bounds);
//     }else{
//       map.setCenter(new google.maps.LatLng(element.latLng.lat(), element.latLng.lng()));
//       map.setZoom(18);
//     }
//   }
  
// }
</script>