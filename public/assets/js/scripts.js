

let liste = document.getElementById('reservations_availability')

liste.addEventListener('change', recevoirValeur)

function recevoirValeur(){
    let id = liste.options[document.getElementById('reservations_availability').selectedIndex].value
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
    launchAjax(); 
}
    
