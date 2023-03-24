
//  --- JQUERY  --- 


// ANIMATION PAGE ACCUEIL

$('.homeContent').hide();
$('.homeImage').hide();

$('.homeTitle').click(()=> {
    $('.homeContent').fadeToggle();
})
$('.homeContent').click(()=> {
    $('.homeImage').fadeToggle();
})

$('.homeImage').click(()=> {
    $('.homeContent').slideToggle();
    $('.homeImage').slideUp()
})


// ANIMATION PAGE MENU

$('.formulaTitle').hide();
$('.plat').hide();

$('.menuTitle').click(()=> {
    $('.formulaTitle').fadeToggle();
})

$('.formulaTitle').click(()=> {
    $('.plat').fadeToggle().animate ({opacity : .6, margin :30}) ;
})

$('.plat').click(()=> {
    $('.plat').slideUp();
})


// ANIMATION PAGE CARTE

$('.dishContent').hide();
$('.dishPhoto').hide();

$('.dishCategory').click(()=> {
    $('.dishContent').fadeToggle().animate ({opacity : .6, margin :30}) ;
})
$('.dishContent').click(()=> {
    $('.dishPhoto').fadeToggle();
    $('.dishContent').animate ({
        opacity : .6,
    margin :10
    }) ;
})

// --- AJAX EN JS VANILLA --- 

// Récuperer la valeur de la date choisie par l'utilisateur
let reservationDate =  document.getElementById('reservations_reservationDate')
let liste = document.getElementById('reservations_availability')

reservationDate.addEventListener('change', () => {
    var choosenDate = reservationDate.value
    
    // Voir la longueur du tableau des dates avec les disponibilités
    let length = document.getElementById("reservations_availability").options.length;
    
    // Construire le tableau contenant la liste des dates
    let availabilityDateArray = []
    for (let i = 0; i < length  ; i++) {
        availabilityDateArray[i] = (liste.options[i].innerText)
    }

    // Verifier si la date choisie est dans le tableau
    // Récupérer ensuite son id
    for (let i = 0; i < length ; i++) {
        if(availabilityDateArray[i].includes(`${choosenDate}`)){
            // Dans la liste des availability, mettre selected="selected" sur la date choisie
            liste.options[i].selected = true
            var id = i
        }s
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


