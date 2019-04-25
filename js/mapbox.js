window.onload = start;

function start() {
    const eLista = document.querySelector(".platser");
    const eKnapp = document.querySelector("button");
    let url = "./spara4.php";
    let index = 0;

    mapboxgl.accessToken = 'pk.eyJ1IjoidmluY2VudG5vcmRlbWFuIiwiYSI6ImNqcGpvZDFmYTA4Ym0zcHFkMTQ0ZGtxM3YifQ.h6k8Y7CGTDvNoGwEKwNUyA';
    let map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/vincentnordeman/cjpjoquzz0f2u2rs3zkr6zlyx', // stylesheet location
        center: [18.07, 59.33], // starting position [lng, lat]
        zoom: 10 // starting zoom
    });

    map.on("click", addMarker);

    function addMarker(e) {
        let marker = new mapboxgl.Marker()
            .setLngLat(e.lngLat)
            .addTo(map);

        /* Lägg till en ny rad i tabellen för varje click */
        eLista.innerHTML += "<input name=\"koordinater[]\" type=\"text\" value=\"" + rund(e.lngLat.lng) + "," + rund(e.lngLat.lat) + "\"><input name=\"beskrivningar[]\" type=\"text\" value=\"Beskrivning\">";
    }
    /* Vid klick på Spara-knappen skicka data till PHP-skript */
    eKnapp.addEventListener("click", spara);

    function spara() {
        /* Skicka ajax-anrop till webbtjänsten*/
        let ajax = new XMLHttpRequest();
        ajax.addEventListener("loadend", sparaPlatser);

        function sparaPlatser() {
            if (this.responseText == "Klart") {
                alert("Platserna sparades i filen.")
            } else {
                alert("Något gick fel.");
            }
        }
        ajax.open("POST", url, true);

        /* Läs av formulärets innehåll */
        let formData = new FormData(eLista);

        /* Nu, skicka data */
        ajax.send(formData);
    }

    /* Runda av decimaler */
    function rund(tal) {
        return tal.toFixed(5);
    }
}