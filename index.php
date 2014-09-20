<?php

?>

<!DOCTYPE html>
<html>

<head>
	<title>Fuzzy Search</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name='Description' content='fuzzy search mockup' />
	<meta name="author" content="liu tong">
	<link rel="shortcut icon" href="favicon.ico">

	<script type='text/javascript' src='js/lib/jquery-1.7.2.min.js'></script>
	<link type='text/css' href='css/bootstrap.css' rel='stylesheet' />
	<script type='text/javascript' src='js/lib/bootstrap.min.js'></script>

	<link href="css/style.css" rel="stylesheet">
	<style type="text/css">
		.mapdiv_wrapper{
		    margin-top: 20px;
		    display: block;
 		    margin-left: auto;
  		    margin-right: auto;
		    width: 90%;
		   /* height: 80%; */
		    /*height: 450px;*/

			background-color: #FFF;
		    -moz-box-shadow: 0px 1px 2px #9f9f9f;
		    -webkit-box-shadow: 0px 1px 2px #9f9f9f;
		    box-shadow: 0px 1px 2px #9f9f9f;
		    padding: 10px;
		    margin-bottom: 20px;
		}
	    #mapdiv {
	        width: 100%; 
	      	height: 100%;
	      	margin:auto;
	    }
	    .debuglog {
	    	margin-top: 10px;
	    	padding-left: 50px;
    
		}
  </style>
</head>

<body >
	<h3 class="text-center">Fuzzy Location Search</h3>
	<div class='container'>
		
<!-- 		<div class="form-group">
			<label for="indirizzoinput">indirizzo</label>
			<input type="text" class="form-control" id="indirizzoinput" placeholder="inserire un posto">
		</div>
		<button id="conferma"  class="btn btn-default">Conferma</button>
		<button id="debug"  class="btn btn-default pull-right">Debug</button>

 -->

  <div class="col-lg-12">
    <div class="input-group">
      <input  id="indirizzoinput" type="text" class="form-control">
      <span class="input-group-btn">
        <button id="conferma"  class="btn btn-default"  type="button"><span class="glyphicon glyphicon-search"></span></button>
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"  type="button"><span class="caret"></span></button>
         <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li><a id="debug"  href="#">Show Debug</a></li>
        </ul>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->



	</div>

	<div class='mapdiv_wrapper'>
		<div id="mapdiv" class="box"></div>
	</div>

	<div class='containera'>
	<div class="debuglog well"></div>
	</div>




<div id="footer">
	<div class="container">
		<div class="text-muted text-center"> <a href="tables.php">Fuzzy Search implemented with Levenshtein Distance Algorithm(PHP)</a></div>
	</div>
</div>

</body>
<script type='text/javascript' src='js/levenshtein.js'></script>
<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
 <script>
    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());
 
    var lonLat = new OpenLayers.LonLat(11.3524529,44.4968718)
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
 
    var zoom=16;
 
    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);
 
    markers.addMarker(new OpenLayers.Marker(lonLat));
 
    map.setCenter (lonLat, zoom);
  </script>
</html>