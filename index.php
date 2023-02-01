<?php
session_start();
if (!isset($_SESSION['email'])) header('Location:log-in.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ChargeMap</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" />
    <link rel="stylesheet" href="markerClusterPlugin/MarkerCluster.css" />
    <link rel="stylesheet" href="markerClusterPlugin/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="leafletRoutingMachine/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="css/leaflet.awesome-markers.css" />
    <link rel="stylesheet" href="css/marker.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/"></script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>

    <script src="https://unpkg.com/leaflet.markercluster@1.1.0/dist/"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet" /> -->
    <!-- Materialize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
    <!-- material icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="./css/mainStyle.css" />
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />

    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@2.4.1/dist/esri-leaflet.js" integrity="sha512-xY2smLIHKirD03vHKDJ2u4pqeHA7OQZZ27EjtqmuhDguxiUvdsOuXMwkg16PQrm9cgTmXtoxA6kwr8KBy3cdcw==" crossorigin=""></script>

    <!-- Load Esri Leaflet Geocoder from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="" />
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js" integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA==" crossorigin=""></script>
    <!-- Leaflet routing machine -->
    <script src="leafletRoutingMachine/leaflet-routing-machine.min.js"></script>
  </head>

  <body>
    <nav>
      <div class="nav-wrapper">
        <a href="#" class="logo hide-on-small-and-down" style="margin-left: 0.5em"><i class="fa-sharp fa-solid fa-charging-station fa-lg" style="margin-right: 0.2em"></i>ChargeMap</a>

        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="fa-solid fa-bars"></i></a>

        <ul id="nav-mobile" class="right">

          <li class="hide-on-med-and-down" style="margin-right: 1em; margin-left: 1em">
            <button type="button" id="btnDisponible" class="btn btn-primary waves-effect">Disponibles</button>
          </li>
          <li class="hide-on-med-and-down" style="margin-right: 1em">
            <button type="button" id="btnTous" class="btn btn-primary waves-effect">Tous</button>
          </li>
        </ul>
      </div>
    </nav>

    <ul id="slide-out" class="sidenav sidenav-fixed">
      <li>
        <div class="user-view" >
          <div class="background">
            <img src="./css/images/electric-car-charging-station-front-view-electric-car-silhouette-with-green-glowing-dark-background-.jpg" style='height: 100%; width: 100%; object-fit: fill'/>
          </div>
          <a href="#user"><img class="circle" src="./css/images/avatar.jfif" /></a>
          <a href="#pseudo"><span id="pseudo" class="white-text name"></span></a>
          <a href="#email"><span id="email" class="white-text email"></span></a>
        </div>
      </li>
      <li class="btnLocaliser">
        <button id="localiser" class="btn waves-effect waves-light" type="submit" name="action">
          Me localiser
          <i class="material-icons right">person_pin_circle</i>
        </button>
      </li>
      <li><a href="#!"><i class="fa-solid fa-users"></i>Liste d'amis - A venir</a></li>
      <li><a href="#!"><i class="fas fa-search-plus"></i>Ajouter un ami - A venir</a></li>
      <li><a href="#!"><i class="fa-solid fa-user-plus"></i>Demande d'ajout - A venir</a></li>
      <li><a href="#!"><i class="fas fa-comment-dots"></i>Mes avis - A venir</a></li>
      <li class="btnLocaliser">
        <button id="deconnect-btn" class="btn waves-effect waves-light" type="submit" name="action">
          Se deconnecter
          <i class="material-icons right">logout</i>
          <!-- <i class="material-icons right">person_pin_circle</i> -->
        </button>
      </li>
    </ul>

    <div class="mapContainer">
      <div id="map"></div>
      <div id="listeProches">
        <ul class="collapsible">
          <li id="stationsProches">
            <div id="collaps" class="collapsible-header"><i class="material-icons">expand_more</i>Voir les stations proches</div>
          </li>
        </ul>
      </div>
    </div>

    <footer class="page-footer">
      <div class="footer-copyright">
        <div class="container">© Projet créée dans le cadre du cours de Développement web</div>
      </div>
    </footer>
  </body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script> -->

<script src="js/leaflet.awesome-markers.js"></script>

<script src="markerClusterPlugin/leaflet.markercluster.js"></script>
<script src="./markerClusterPlugin/leaflet.markercluster.layersupport.js"></script>
<script src="./js/navEtInteraction.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="./markerClusterPlugin/GeometryUtil.js"></script>
<script src="./js/scriptMap.js"></script>
