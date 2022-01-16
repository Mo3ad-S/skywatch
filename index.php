<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Rafraichissement de la page toutes les 60 secondes, ce qui permet aux données météo d'être mises à jour-->
        <meta http-equiv="refresh" content="60">
		<!-- Icone de la page -->
		<link rel="icon" type="image/png" href="./img/planetarium.png" />
		
        <!-- on fait le lien avec les fichiers de style css et la banque d'icone font awesome -->
        <link rel="stylesheet" href="./style/skywatch.css" />
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

		<script src="./javascript/ephemeris-0.1.0.js"></script>
		<script src="./javascript/moment-with-locales.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="./javascript/skywatch.js"></script>
		
        <title>Skywatch</title>
        
        
    </head>
    <body>
    <!-- bandeau -->
    <header role="header">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
			<a class="navbar-brand" href="https://www.imt-atlantique.fr/fr">
				<img src = "https://www.imt-atlantique.fr/sites/default/files/Images/Ecole/charte-graphique/IMT_Atlantique_logo_RVB_Negatif_Baseline_400x272.png" alt="Logo de l'école IMT Atlantique" class="logo" >
			</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
						<a class="nav-link" href="./AVI/last_AVI_sequence.avi" class="link"><i class="fas fa-video"></i>  <i class="fas fa-hourglass-half"></i> Timelapse de la dernière heure</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link" href="./AVI/last_AVI_seq_Night.avi" class="link"><i class="fas fa-video"></i>  <i class="fas fa-moon"></i> Timelapse de la dernière nuit</a>
					</li>
                    <!-- témoin caméra en fonctionnement ou non (1h de délai) -->
					</li>
                    <li class="nav-item">
						<i class="fas fa-video"></i>
						<i class="fad fa-webcam<?php echo"-slash" ?>"></i>
					</li>
				</ul>
                    
            </div>
			<a class="navbar-brand" href="https://www.astronomie-pointedudiable.fr/">
				<img src = "https://www.astronomie-pointedudiable.fr/wp-content/uploads/2015/03/logo-gens-de-la-lune.png" class="logo-gdl" >
			</a>
        </nav>
    </header>
    
    <div class="container">
		<div class="row">
			<div class="col-4">
				<?php include 'meteo.php' ?>
			</div>
			<div class="col-8">
			<br><br>
				<canvas id="canvas" width="750" height="500" moz-opaque
				        onmousemove="cnvs_getCoordinates(event)" onmouseout="cnvs_clearCoordinates()"></canvas>
				<p id="dt_image"></p>
				<div id="xycoordinates"></div>
    			<!--canvas id="zoom" width="150" height="100"></canvas-->
			</div>
		</div>
		<div class="row">
			<div class="col-4">
				<br>
				<!-- calendrier lunaire -->
				<a target="blank" style="text-decoration:none;" href="http://www.calendrier-lunaire.net/" class="image-lune"><img src="http://www.calendrier-lunaire.net/module/LYWR2YW5jZWQtMTI0LWgyLTE2MjAxOTk0OTAuODIxNy0jMTUwOTFmLTMwMC0jZGVlYWI0LTE2MjAxOTk0OTAtMS0xMA.png" alt="La Lune" title="La Lune" /></a>
			</div>
			<div class="col-8">
				<table class="table table-hover">
					<!-- tableau météo -->
				  <thead>
					<tr>
						<th></th>
						<th>Mercure</th>
						<th>Vénus</th>
						<th>Mars</th>
						<th>Jupiter</th>
						<th>Saturne</th>
						<th>Uranus</th>
						<th>Neptune</th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
						<td>Lever</td> 
						<td>05h08m</td>
						<td>11h09m</td>
						<td>05h56m</td>
						<td>13h55m</td>
						<td>13h15m</td>
						<td>16h31m</td>
						<td>14h52m</td>
					</tr>
					<tr>
						<td>Ascension Droite</td>
						<td>13h30m19,14s</td>
						<td>17h44m10,14s</td>
						<td>13h57m55,24s</td>
						<td>21h41m37,41s</td>
						<td>20h39m12,89s</td>
						<td>2h42m26,41s</td>
						<td>23h27m28,47s</td>
					</tr>
					<tr>
						<td>Déclinaison</td>
						<td>-7°15'27,42"</td>
						<td>-27°07'34,93"</td>
						<td>-27°07'34,93"</td>
						<td>-15°00'18,60"</td>
						<td>-19°15'39,51"</td>
						<td>15°18'52,40"</td>
						<td>-4°46'31,38"</td>
					</tr>
				  </tbody>
				  <tfoot>
					<tr>
						<td colspan="8" style="text-align: right">Ephéméride des planètes</td>
					</tr>
				  </tfoot>
				</table>
			</div>
		</div>
    </div>
	
    <!-- moteur de recherche -->
    <!--div>
		<p>Moteur de recherche d'images</p>
   
		<form action="form.php" method ="GET" >
			<label for="start">Date :</label>
			<input type="date" id="date" name="date1"
		   min="2021-03-01" max="2032-12-31">
		   <label for="start">Heure :</label>
		   <input type="time" id="time" name="heure">

		
		<input type="submit">
		<input type="reset">
    </div-->
    </form>
	
 	<script type="text/javascript">
		load_image();
		intervalID = setInterval(load_image, 300000);
	</script>
   
    </body>
</html>