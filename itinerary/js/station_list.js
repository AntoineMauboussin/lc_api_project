window.addEventListener("DOMContentLoaded", e => {

    //GET sur l'api de velib de Paris
    fetch("https://opendata.paris.fr/api/records/1.0/search/?dataset=velib-disponibilite-en-temps-reel&q=&facet=name&facet=is_installed&facet=is_renting&facet=is_returning&facet=nom_arrondissement_communes&rows=100", {
        method: 'GET'
    })
    .then(
        response => response.text()
    ).then(
        res => {
            data = JSON.parse(res)
            data.records.forEach(el => {
                document.querySelector(".list").innerHTML += "<div><b>"+el.fields.name+"</b><br>Nombre de vélos disponibles : "
                +el.fields.numbikesavailable+"<br>Nombre de places disponibles : "+el.fields.numdocksavailable+"</div>"
            });
        }
    ).catch(
        e => {
            console.log(e)
        }
    )

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
            console.log(result);
    })
    .catch(error => {
        console.error("Erreur lors de la requête:", error);
    });
});