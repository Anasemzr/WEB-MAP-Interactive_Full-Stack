let userLocalisationMarker;

document.getElementById('btnDisponible').onclick = () => {
    map.removeLayer(groupeIndispo)
    groupeDispo.addTo(map)
    document.getElementsByClassName("leaflet-control-layers-selector")[0].checked = true;
    document.getElementsByClassName("leaflet-control-layers-selector")[1].checked = false;
  }
  document.getElementById('btnTous').onclick = () => {
    groupeDispo.addTo(map)
    groupeIndispo.addTo(map)
    document.getElementsByClassName("leaflet-control-layers-selector")[0].checked = true;
    document.getElementsByClassName("leaflet-control-layers-selector")[1].checked = true;
  }

var instances;
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    instance = M.Sidenav.init(elems);
  });

  $(document).ready(function(){
    $('.collapsible').collapsible();
  });

// Récupère et affiche le pseudo et l'email de l'utilisateur actuel
fetch('nav-init.php')
.then(res =>{
    if (res.ok) return res.json();
}).then(data => {
    document.getElementById('pseudo').innerText = data.pseudo;
    document.getElementById('email').innerText = data.email;
})
.catch(error => console.log(error));