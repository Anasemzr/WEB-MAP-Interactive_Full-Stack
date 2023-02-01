
let parisCoords = [48.864716, 2.349014]
var map = L.map('map',{ zoomControl: false }).setView(parisCoords, 12);
var mark_address
let aEteLocalise

var p1 = L.latLng(48.903882, 2.248815),
p2 = L.latLng(48.816243, 2.418073),
bounds_area = L.latLngBounds(p1, p2);

var jawgMap = L.tileLayer('https://tile.jawg.io/jawg-streets/{z}/{x}/{y}{r}.png?access-token=nsi1iOXZ0TFJgd75Y9nsCmqiZ5G9RraVOeQBXjw44D6EaKCp40ExjBO4m35NYfjK', {}).addTo(map);
map.attributionControl.addAttribution("<a href=\"https://www.jawg.io\" target=\"_blank\">&copy; Jawg</a> - <a href=\"https://www.openstreetmap.org\" target=\"_blank\">&copy; OpenStreetMap</a>&nbsp;contributors")

let PlacesDispo //Liste des places Dispo en JSON
let PlacesIndispo

var bolt = L.AwesomeMarkers.icon({ // Style de marqueur représentant une station diponible 
  icon: "check",
  prefix: "fa",
  markerColor: "green",
  iconColor: "white"
});

var no_bolt = L.AwesomeMarkers.icon({ // Style de marqueur représentant une station indiponible
  icon: "xmark",
  prefix: "fa",
  markerColor: "red",
  iconColor: "white"
});

loadPlacesDispo() // Initialise les marqueurs de stations disponibles
loadPlacesIndispo() // Initialise les marqueurs de stations indisponibles

// Initalisation des couches pour MakreCluster
var LayerSupportGroup = L.markerClusterGroup.layerSupport()
var groupeDispo = L.layerGroup()
var groupeIndispo = L.layerGroup()
LayerSupportGroup.addTo(map)

// Overlay Leaflet
const overlayMaps = {
    "Stations disponibles": groupeDispo,
    "Stations indisponibles" : groupeIndispo
  };

L.Control.CustomButtons = L.Control.Layers.extend({
  onAdd: function () {
    this._initLayout();
    this._update();
    return this._container;
  },
  createButton: function (type, className) {
    const elements = this._container.getElementsByClassName(
      "leaflet-control-layers-list"
    );
    const button = L.DomUtil.create(
      "button",
      `btn-markers ${className}`,
      elements[0]
    );
    button.textContent = `${type} `;
  },
});

new L.Control.CustomButtons(null, overlayMaps, { collapsed: false }).addTo(map);

// Zoom 
L.control.zoom({position: 'bottomright'}).addTo(map);

// Type de layers pour la map
var mqi = jawgMap;
  sate = L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x} 78", {
    attribution: "Tiles © Esri — Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community"});

var baseMaps = {
    "Basique": mqi,
    "Satellite":sate,
};

var overlays =  {//add any overlays here
};
L.control.layers(baseMaps,overlays, {position: 'bottomright'}).addTo(map);

//search
var searchControl = L.esri.Geocoding.geosearch({placeholder: "Entrez une adresse",expanded:true,collapseAfterResult:false,searchBounds:bounds_area}).addTo(map);
//zoomToResult
searchControl.on('results', function (data) {
  if(mark_address != null)    {
    map.removeLayer(mark_address)
  }
  mark_address=L.marker(data.results[data.results.length-1].latlng).addTo(map);
  routingMachine.spliceWaypoints(0, 1, mark_address.getLatLng());
  trouverMarqueursProches();
  afficherMarqueursProches();
});


// Requête vers l'api OPEN DATA PARIS qui récupère un JSON des stations disponibles en temps réel
async function loadDispo() {
    PlacesDispo = await fetch('https://opendata.paris.fr/api/records/1.0/search/?dataset=belib-points-de-recharge-pour-vehicules-electriques-disponibilite-temps-reel&q=dispo&rows=1000&facet=statut_pdc&facet=last_updated&facet=arrondissement')
    return PlacesDispo.json()
}

// Renvoie une chaine de caractère contenant le code HTML du popup d'un marqueur
function get_pop_up(PlacesDispo,i,x,y,id_pdc){
  var s = `<p> N° `+PlacesDispo[i].fields.id_pdc+'</p> <p> Mise à jour : ' + moment(PlacesDispo[i].fields.last_updated).fromNow()+
  `<br><b>` + 
  PlacesDispo[i].fields.adresse_station +`</b></p>
  <section class="slider-wrapper">
  <button class="slide-arrow" id="slide-arrow-prev" onclick="(()=>{
    
    const slidesContainer = document.getElementById('slides-container');
    const prevButton = document.getElementById('slide-arrow-prev');

    prevButton.addEventListener('click', () => {
      slidesContainer.scrollLeft -= 243;
    });
    this.onclick = undefined
    })()"> &#8249;
  </button>
  <button class="slide-arrow" id="slide-arrow-next" onclick="(()=>{
    const slidesContainer = document.getElementById('slides-container');
    const nextButton = document.getElementById('slide-arrow-next');
    nextButton.addEventListener('click', () => {
    slidesContainer.scrollLeft += 243;});
    this.onclick = undefined
  })()">
    &#8250;
  </button>
  <ul class="slides-container" id="slides-container">


  </ul>
    </section>

  <div style="display : flex; justify-content : space-around">
    <button onclick="displayAvisForm()" class="btn waves-effect waves-light route"> Avis !</button> 
    <button onclick="ajouterStationAItineraire(${x},${y})" class="btn waves-effect waves-light route"> On y va !</button> 
  </div> 
  <div class="post-avis-card">
    <form id='avisForm' method="post" action='post-avis.php'>
      <input name='id_pdc' value=${id_pdc} style='display : none;' </input>
      <textarea id="avisText" class="text" name="avisText" form="avisForm"></textarea>
      <input type="submit" value="Poster un avis" class="submitButton btn waves-effect waves-light">
    </form>
  </div>`;
  return s;
}

// CSS POP UP Station Disponible
var css_dispo =
{
  'maxWidth': '270',
  'maxHeight':'270',

  'minWidth': '200',
  'minHeight':'200',
  
  'className' : 'pop-up-station-dispo'
}

// CSS POP UP Station Indisponible
var css_indispo =
{
  'maxWidth': '270',
  'maxHeight':'270',

  'minWidth': '200',
  'minHeight':'200',
  
  'className' : 'pop-up-station-indispo'
}

// Initalise les marqueurs des stations disponible actuellement
async function loadPlacesDispo() {
    PlacesDispo = await loadDispo()
    PlacesDispo = PlacesDispo.records

    for (let i = 0; i < PlacesDispo.length ; i++) {
      let x = PlacesDispo[i].geometry.coordinates[1]
      let y = PlacesDispo[i].geometry.coordinates[0]
      if (isNaN(x) || isNaN(y)) {
        continue
      }
      let marker = L.marker([x,y],{icon:bolt});  
      const popup = await get_pop_up(PlacesDispo,i,x,y, PlacesDispo[i].fields.id_pdc);
      marker.bindPopup(popup,css_dispo);
      if (isNaN(x) || isNaN(y)) continue;
      marker._leaflet_id =  PlacesDispo[i].fields.id_pdc;
      marker.address = PlacesDispo[i].fields.adresse_station
      marker.on('click', onClick);
      groupeDispo.addLayer(marker)
    }

}

// Créer un itinéraire d'une adresse fournie ou de la localisation de l'utilisateur jusqu'a une station
function ajouterStationAItineraire(x, y) {
  if (mark_address == null) {
    alert('Veuillez vous localiser ou renseigner une adresse avant de programmer un itinéraire');
    // M.toast({html : 'Veuillez vous localiser ou renseigner une adresse avant', displayLength : 3000})
    return
  }
  let coordonees = [x,y]
  routingMachine.spliceWaypoints(routingMachine.getWaypoints().length-1, 1, coordonees)
  routingMachine.addTo(map);
}

// Requête vers l'api OPEN DATA PARIS qui récupère un JSON des stations indisponibles en temps réel
async function loadIndispo() {
    PlacesIndispo = await fetch('https://opendata.paris.fr/api/records/1.0/search/?dataset=belib-points-de-recharge-pour-vehicules-electriques-disponibilite-temps-reel&q=occupé&rows=1000&facet=statut_pdc&facet=last_updated&facet=arrondissement')
    return PlacesIndispo.json()
}

// Initalise les marqueurs des stations indisponible actuellement
async function loadPlacesIndispo() {
    PlacesIndispo = await loadIndispo()
    PlacesIndispo = PlacesIndispo.records;
    for (let i = 0; i < PlacesIndispo.length; i++) {
      let x = PlacesIndispo[i].geometry.coordinates[1]
      let y = PlacesIndispo[i].geometry.coordinates[0]
      if (isNaN(x) || isNaN(y)) {
        continue
      }
      let marker = L.marker([x,y],{icon:no_bolt});  
      const popup = await get_pop_up(PlacesDispo,i,x,y, PlacesDispo[i].fields.id_pdc);
      marker.bindPopup(popup,css_indispo);
      marker._leaflet_id =  PlacesIndispo[i].fields.id_pdc;   
      marker.on('click', onClick);  
      groupeIndispo.addLayer(marker)
      }
}

// Se déclenche au clic sur un marqueur, effectue une requête qui récupère les avis de la stations
function onClick(e) {
  let url = "get-avis.php?id="+this._leaflet_id;
  fetch(url)
  .then(res =>{
      if (res.ok) return res.json();
      else console.log('not success');
  }).then(data => {
      let avisContent = "";
      data.forEach(avis => {
        avisContent +=`<li class="slide"><b><br>`+ avis.pseudo +'</b><br><div class="description">'+ avis.contenu +`</div></li>`
      });
      document.getElementById('slides-container').innerHTML = avisContent;
  })
  .catch(error => console.log(error));
}

LayerSupportGroup.checkIn([groupeDispo, groupeIndispo])

// Affiche le formulaire pour poster un avis sur une station
function displayAvisForm(){
  $('.post-avis-card').show();
}

// LEAFLET ROUTING MACHINE
let routingMachine =L.Routing.control({
  routeWhileDragging: false,
  addWaypoints : false,
  language : 'fr'
})

// GEOLOCALISATION
document.getElementById('localiser').onclick = () => {
  if (aEteLocalise) {
    map.setView(mark_address.getLatLng(),5)
    mark_address.openPopup()
  }
  map.locate({
    setView: true,
    enableHighAccuracy: true,
    maxZoom : 13
})
// if location found show marker and circle
.on("locationfound", (e) => {
    //retire l'ancien marker
    if(mark_address != null) {
      map.removeLayer(mark_address)
    }
  // marker
  mark_address = L.marker([e.latitude, e.longitude]).bindPopup(
    "Vous êtes ici."
  );
  // add marker
  map.addLayer(mark_address);
  mark_address.openPopup()
  aEteLocalise = true;
  if ($(window).width() < 992) {
    $('.sidenav').sidenav('close');
 }
 routingMachine.spliceWaypoints(0, 1, mark_address.getLatLng());
 trouverMarqueursProches();
 afficherMarqueursProches();
})
// if error show alert
.on("locationerror", (e) => {
  console.log(e);
  alert("Location access denied.");
});
}

/// MARQUEURS PROCHES
var markersProches;

// Récupère la liste des marquers proches en fonction de l'adresse renseignée
function trouverMarqueursProches() {
  markersProches = groupeDispo.getLayers()
  var uniqueSet = []
  for(let i =0; i < markersProches.length; i++) {
    if (uniqueSet.includes(markersProches[i]._latlng.lat)) {
      markersProches.splice(i,1)
      i--;
    } else {
      uniqueSet.push(markersProches[i]._latlng.lat)
    }
  }
  markersProches = L.GeometryUtil.nClosestLayers(map, markersProches, mark_address.getLatLng(), 5)
}

// Affiche la liste des marqueurs proches
function afficherMarqueursProches() {
  $('#stationsProches').css('display', 'block')
  let menu = document.getElementById('stationsProches');
  $('.collapsible-body').remove()
  for(let i = 0; i < markersProches.length; i++) {
    let x = `<div onclick="zoomToCoords(${markersProches[i].layer._latlng.lat}, ${markersProches[i].layer._latlng.lng})" class="collapsible-body"><div class="collapsItem"><span><i class="material-icons">ev_station</i></span><span>${markersProches[i].layer.address + ''}</span></div></div>`
    menu.insertAdjacentHTML( 'beforeend', x );
  }
  if (document.getElementById('stationsProches').className == 'active') {
    document.getElementById('collaps').click()
  }
}

// Zoom vers des coordonnées fournie
function zoomToCoords(lat, lng) {
  map.setView([lat, lng], 20)
  groupeDispo.addTo(map)
  document.getElementsByClassName("leaflet-control-layers-selector")[0].checked = true;
}

// Event listener qui déconnecte un utilisateur
document.getElementById('deconnect-btn').addEventListener('click',function(){
  window.location.replace("log-out.php"); 
});