$(document).ready(function() {
$('.related-post').owlCarousel({
	    loop:true,
	    margin:20,
	    nav:true,
	    dots:false,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        900:{
	            items:3
	        },
	        1000:{
	            items:3
	        }
	    }
	})
$('.owlsliderone').owlCarousel({
        loop:true,
        margin:20,
        nav:true,
        dots:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });

$('.owlslidertwo').owlCarousel({
        loop:true,
        margin:20,
        nav:true,
        dots:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    });

$('.slider-review').owlCarousel({
        loop:true,
        margin:30,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    });

$('.photo-slider').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
});
$('.mobil-bar').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    dots:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
 // variables 
      var toTop = $('#scroll-to-top');
      // logic
      toTop.on('click', function() {
        $('html, body').animate({
          scrollTop: $('html, body').offset().top,
        });
      });

});


/** location map */
window.onload = function() {
    initLocationMap();
}
function initLocationMap() {
  
    const locations = [
        { lat: 52.486912796211634, lng: -1.9119830200551595 },
        { lat: 51.4976029, lng: -0.1644648 }
    ];

    const options = {
        zoom: 18, // 7.5
        center: new google.maps.LatLng(52.486902608199614, -1.9121013705836836), // locations[0],
        streetViewControl: !1,
        mapTypeControl: !1,
        fullscreenControl: !1,
        styles: [
            { featureType: "administrative", elementType: "all", stylers: [{ saturation: "95" }, { lightness: "-48" }, { visibility: "on" }, { color: "#ff0000" }, { weight: "0.01" }] },
            { featureType: "administrative", elementType: "geometry", stylers: [{ visibility: "on" }, { hue: "#00a3ff" }] },
            { featureType: "administrative", elementType: "geometry.fill", stylers: [{ visibility: "on" }, { color: "#4a335a" }, { saturation: "45" }, { lightness: "-64" }] },
            { featureType: "administrative", elementType: "geometry.stroke", stylers: [{ visibility: "off" }] },
            { featureType: "administrative", elementType: "labels.text", stylers: [{ hue: "#ff0000" }, { visibility: "on" }, { saturation: "100" }, { lightness: "-50" }, { gamma: "1.60" }, { weight: "0.01" }] },
            { featureType: "administrative", elementType: "labels.text.fill", stylers: [{ color: "#4a335a" }, { weight: "0.01" }, { visibility: "on" }] },
            { featureType: "administrative.country", elementType: "geometry.fill", stylers: [{ saturation: "100" }, { lightness: "9" }, { weight: "6.25" }, { visibility: "on" }] },
            { featureType: "administrative.neighborhood", elementType: "labels.text.fill", stylers: [{ color: "#4a335a" }] },
            { featureType: "landscape", elementType: "all", stylers: [{ color: "#f7f5fa" }] },
            { featureType: "landscape", elementType: "labels.icon", stylers: [{ hue: "#ff0000" }, { visibility: "off" }] },
            { featureType: "poi",   elementType: "all", stylers: [{ visibility: "off" }] },
            { featureType: "road", elementType: "all", stylers: [{ saturation: -100 }, { lightness: 45 }, { visibility: "on" }] },
            { featureType: "road.highway", elementType: "all", stylers: [{ visibility: "simplified" }] },
            { featureType: "road.highway", elementType: "geometry.fill", stylers: [{ visibility: "on" }, { color: "#e3cbe3" }, { saturation: "-30" }] },
            { featureType: "road.arterial", elementType: "all", stylers: [{ visibility: "on" }] },
            { featureType: "road.arterial", elementType: "geometry.fill", stylers: [{ color: "#e1cce1" }] },
            { featureType: "road.arterial", elementType: "labels", stylers: [{ visibility: "simplified" }, { hue: "#9600ff" }, { saturation: "100" }, { lightness: "-71" }, { weight: "5.35" }] },
            { featureType: "road.arterial", elementType: "labels.icon", stylers: [{ visibility: "off" }, { color: "#4a335a" }, { saturation: "18" }] },
            { featureType: "road.local", elementType: "labels.text.fill", stylers: [{ color: "#4a335a" }, { saturation: "100" }, { lightness: "-55" }] },
            { featureType: "transit", elementType: "all", stylers: [{ visibility: "off" }] },
            { featureType: "transit.station", elementType: "all", stylers: [{ visibility: "on" }] },
            { featureType: "transit.station", elementType: "labels", stylers: [{ visibility: "on" }] },
            { featureType: "transit.station", elementType: "labels.text", stylers: [{ visibility: "on" }, { color: "#120722" }, { weight: "0.21" }, { gamma: "1.00" }, { lightness: "-30" }, { saturation: "0" }] },
            { featureType: "transit.station.bus", elementType: "all", stylers: [{ visibility: "off" }] },
            { featureType: "transit.station.bus", elementType: "geometry", stylers: [{ visibility: "off" }] },
            { featureType: "transit.station.bus", elementType: "geometry.fill", stylers: [{ color: "#e40000" }, { visibility: "off" }] },
            { featureType: "transit.station.bus", elementType: "geometry.stroke", stylers: [{ visibility: "off" }] },
            { featureType: "transit.station.bus", elementType: "labels", stylers: [{ visibility: "off" }] },
            { featureType: "water", elementType: "all", stylers: [{ color: "#e3cbe3" }, { visibility: "on" }] },
        ],
    }
    
    /** Create map  */
    var bounds = new google.maps.LatLngBounds();
    const map = new google.maps.Map(document.getElementById("location_map"), options);
  
    /** Add multiple markers to the map */
    for (i = 0; i < locations.length; i++) {
        const marker = new google.maps.Marker({
            position: locations[i],
            map: map,
            icon: mapMarker
        });
        google.maps.event.addListener(marker, 'click', markerOnClick);
        bounds.extend(marker.position);  
    }

    /** set center of all markers */
    map.fitBounds(bounds);
  
    /** set zoom and center to clicked marker */
    function markerOnClick(element){
        if(map.zoom == 18){
            map.fitBounds(bounds);
        }else{
            map.setCenter(new google.maps.LatLng(element.latLng.lat(), element.latLng.lng()));
            map.setZoom(18);
        }
    }
    
}


$(window).on("load", function () {
    $("#map").length &&
        (document.getElementById("map").addEventListener(
            "dragstart",
            function (e) {
                console.log('dragstart');
                (null != $("#map .gm-style").length && 0 != $("#map .gm-style").length && "" != $("#map .gm-style").length) || loadSnazymap(e);
            },
            !1
        ),
        document.getElementById("map").addEventListener(
            "touchstart",
            function (e) {
                console.log('drags-end');
                (null != $("#map .gm-style").length && 0 != $("#map .gm-style").length && "" != $("#map .gm-style").length) || loadSnazymap(e);
            },
            !1
        ));
});
$("dd").after("<br>");


/**
 * isInViewport
 * @returns 
 * check if element in viewport
 */
 $.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};//endof isInViewport

//Home page video play on mouse hover
 /*const video = document.getElementById("video")
    video.onmouseover = function(){
        video.play();
    }
    video.onmouseout = function(){
        video.pause();
    }*/

$(window).scroll(function(e)
  {
    var offsetRange = $(window).height() / 3,
        offsetTop = $(window).scrollTop() + offsetRange + $(".header-main").outerHeight(true),
        offsetBottom = offsetTop + offsetRange;

    $("#video").each(function () { 
      var y1 = $(this).offset().top;
      var y2 = offsetTop;
      if (y1 + $(this).outerHeight(true) < y2 || y1 > offsetBottom) {
        this.pause(); 
      } else {
      this.play(); 
      }
    });
});



function isIOS() {
  return [
    'iPad Simulator',
    'iPhone Simulator',
    'iPod Simulator',
    'iPad',
    'iPhone',
    'iPod'
  ].includes(navigator.platform)
  || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
}