window.addEventListener("DOMContentLoaded", e => {
    
    //place la carte sur paris
    let map = L.map('map').setView([48.8560, 2.3404], 13);
    let itinerary = []
    let input = document.querySelector(".coordinates")
    input.value = ""
    
    //charge la carte OpenStreetMap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    //ajout d'un icone personnalisé de vélo
    let bikeIcon = L.icon({
        iconUrl: 'marker.png',
        shadowUrl: '',
    
        iconSize:     [26.25, 41.33], // size of the icon
        shadowSize:   [0,0], // size of the shadow
        iconAnchor:   [13.125,41.33], // point of the icon which will correspond to marker's location
        shadowAnchor: [0,0],  // the same for the shadow
        popupAnchor:  [0, -44] // point from which the popup should open relative to the iconAnchor
    });
    var marker = L.marker([2.33, 48.8]).addTo(map);

    //GET sur l'api de velib de Paris
    fetch("https://opendata.paris.fr/api/records/1.0/search/?dataset=velib-disponibilite-en-temps-reel&q=&facet=name&facet=is_installed&facet=is_renting&facet=is_returning&facet=nom_arrondissement_communes&rows=100", {
        method: 'GET'
    })
    .then(
        response => response.text()
    ).then(
        res => {
            data = JSON.parse(res)
            
            //ajout des marqueurs pour chaque station et d'un popup associé
            data.records.forEach(el => {
                L.marker([el.geometry.coordinates[1],el.geometry.coordinates[0]],{icon: bikeIcon}).addTo(map).bindPopup("<b>"+el.fields.name+"</b><br>Nombre de vélos disponibles : "
                +el.fields.numbikesavailable+"<br>Nombre de places disponibles : "+el.fields.numdocksavailable)
            });
        }
    ).catch(
        e => {
            console.log(e)
        }
    )

    //ajout d'un point d'itinéraire au clic
    function onMapClick(e) {
        L.marker(e.latlng).addTo(map);
    
        if(itinerary.length !== 0){
            
            L.polygon([
                itinerary[itinerary.length - 1],
                e.latlng
            ]).addTo(map);
        }
        itinerary.push(e.latlng)
        input.value = JSON.stringify(itinerary)
    }
    
    map.on('click', onMapClick);


    document.querySelector(".itinerary-form").addEventListener("submit", function (event) {
        event.preventDefault();

        //Vérification du jeton

        let token = document.querySelector(".token").value
        fetch('../auth_api/verify.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({jeton : token})
        })
        .then(response => response.json())
        .then(result => {
                if(result.statut === "Succès"){
                    document.querySelector(".username").value = result.utilisateur.identifiant
                    event.target.submit()
                }
        })
        .catch(error => {
            console.error("Erreur lors de la requête:", error);
        });
    })
});