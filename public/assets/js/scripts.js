
// Récuperer la valeur de la date choisie par l'utilisateur
let reservationDate =  document.getElementById('reservations_reservationDate')
let liste = document.getElementById('reservations_availability')

reservationDate.addEventListener('change', function(){
    var choosenDate = reservationDate.value
    
    // Voir la longueur du tableau des dates avec les disponibilités
    let length = document.getElementById("reservations_availability").options.length;
    
    // Construire le tableau contenant la liste des dates
    let availabilityDateArray = []
    for (let i = 0; i < length - 1 ; i++) {
        availabilityDateArray[i] = (liste.options[i].innerText)
    }

    // Verifier si la date choisie est dans le tableau
    // Récupérer ensuite son id
    for (let i = 0; i < length - 1; i++) {
        if(availabilityDateArray[i].includes(`${choosenDate}`)){
            var id = i + 1
        }
    } 
    
    // Récuperer en AJAX le nombre de guestMax pour la date selectionnée
    
    const url = "http://127.0.0.1:8000/availability/" + id; 
    async function launchAjax(){    
        const requete = await fetch(url, {
            method:'GET'
        });
        
        if(!requete.ok){
            alert('un probleme est survenu');
        } else {
            let donnees = await requete.json();

           donnees.forEach(element => {
                document.getElementById('nbMax').textContent =  element.guestMax
            })

        }
    }    
    
    launchAjax()
})

