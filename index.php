<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Rafraichissement de la page toutes les 60 secondes, ce qui permet aux données météo d'être mises à jour-->
        <!--meta http-equiv="refresh" content="60"-->
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
		<script src=".javascript/sidereal_time.js"></script>
		
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
				style="position: absolute; z-index: 0;"></canvas>
				<p id="dt_image"></p>
				<div id="xycoordinates"></div>
    			<!--canvas id="zoom" width="150" height="100"></canvas-->
				<canvas id="redcircles" width="750" height="500" 
				style="position: absolute; z-index: 0;"></canvas>
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
						<th>Chiron</th>
						<th>Sirius</th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
						<td>Lever</td> 
						<td id="rise_mercury"></td>
						<td id="rise_venus"></td>
						<td id="rise_mars"></td>
						<td id="rise_jupiter"></td>
						<td id="rise_saturn"></td>
						<td id="rise_uranus"></td>
						<td id="rise_neptune"></td>
						<td id="rise_chiron"></td>
						<td id="rise_sirius"></td>
					</tr>
					<tr>
						<td>Coucher</td> 
						<td id="set_mercury"></td>
						<td id="set_venus"></td>
						<td id="set_mars"></td>
						<td id="set_jupiter"></td>
						<td id="set_saturn"></td>
						<td id="set_uranus"></td>
						<td id="set_neptune"></td>
						<td id="set_chiron"></td>
						<td id="set_sirius"></td>
					</tr>
					<tr>
						<td>Ascension Droite</td>
						<td id="ra_mercury"></td>
						<td id="ra_venus"></td>
						<td id="ra_mars"></td>
						<td id="ra_jupiter"></td>
						<td id="ra_saturn"></td>
						<td id="ra_uranus"></td>
						<td id="ra_neptune"></td>
						<td id="ra_chiron"></td>
						<td id="ra_sirius"></td>
					</tr>
					<tr>
						<td>Déclinaison</td>
						<td id="d_mercury"></td>
						<td id="d_venus"></td>
						<td id="d_mars"></td>
						<td id="d_jupiter"></td>
						<td id="d_saturn"></td>
						<td id="d_uranus"></td>
						<td id="d_neptune"></td>
						<td id="d_chiron"></td>
						<td id="d_sirius"></td>
					</tr>
					<tr>
						<td>Visible</td>
						<td id="v_mercury"></td>
						<td id="v_venus"></td>
						<td id="v_mars"></td>
						<td id="v_jupiter"></td>
						<td id="v_saturn"></td>
						<td id="v_uranus"></td>
						<td id="v_neptune"></td>
						<td id="v_chiron"></td>
						<td id="v_sirius"></td>
					</tr>
					<tr>
						<td>Localiser la planète</td>
						<td><form><input id="b_mercury" type=button value="Afficher" onclick=drawCircle(z_mercury)></form></td>
						<td><form><input id="b_venus" type=button value="Afficher" onclick=drawCircle(z_venus)></form></td>
						<td><form><input id="b_mars" type=button value="Afficher" onclick=drawCircle(z_mars)></form></td>
						<td><form><input id="b_jupiter" type=button value="Afficher" onclick=drawCircle(z_jupiter)></form></td>
						<td><form><input id="b_saturn" type=button value="Afficher" onclick=drawCircle(z_saturn)></form></td>
						<td><form><input id="b_uranus" type=button value="Afficher" onclick=drawCircle(z_uranus)></form></td>
						<td><form><input id="b_neptune" type=button value="Afficher" onclick=drawCircle(z_neptune)></form></td>
						<td><form><input id="b_chiron" type=button value="Afficher" onclick=drawCircle(z_chiron)></form></td>
						<td><form><input id="b_sirius" type=button value="Afficher" onclick=drawCircle(z_sirius)></form></td>
					</tr>
				  </tbody>
				  <tfoot>
					<tr>
						<td colspan="8" style="text-align: right">Ephéméride des planètes</td>
					</tr>
				  </tfoot>
				  <input id="clear" type=button value="Effacer">
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

	<script type='text/javascript'>
		//fonction tirée de "Astronomical algorithms" par Jean Meeus

	function localSideralTime(longitude) {//longitude en dégrés décimaux
    	var datetime = new Date(Date.now()), 
        	Y = datetime.getUTCFullYear(),
    	    M = datetime.getUTCMonth() + 1,//en javascript : janvier = 0 !
        	D = datetime.getUTCDate(),
        	h = datetime.getUTCHours(),
        	m = datetime.getUTCMinutes(),
        	s = datetime.getUTCSeconds();
        
    	D += h / 24 + m / 60 / 24 + s / 3600 / 24;//pour avoir la fraction du jour sous forme décimale
   
    	return sideralTimeGreewich(julianDay(D, M, Y)) + longitude;// longitude > 0 --> Est
	}
   
	function julianDay(D, M, Y) {
  		var A, B;
    
  		if(M <= 2) {
    		M += 12;
    		Y -= 1;
    	}
    
  		A = Math.trunc(Y / 100);
    
  		if(Y < 1582) B = 0;//si l'année est une date dans le calendrier julien
  		else B = Math.trunc(2 - A + Math.trunc(A / 4));
    
  		return  Math.trunc(365.25 * (Y + 4716))
        	  	+ Math.trunc(30.6001 * (M + 1))
          		+ D + B - 1524.5;
	}
   
	function sideralTimeGreewich(julianday) {
 		var T     = (julianday - 2451545.0) / 36525,
    	temp  = (
              + 280.46061837
              + 360.98564736629 * (julianday - 2451545)
              + 0.000387933 * T * T
              - (T * T * T) / 38710000
              ) % 360;//opération modulo peut donner un résultat négatif...
		if(temp < 0) temp += 360;//...si c'est le cas, ajouter 360°
    
    return temp;
	}

	function hourAngle(lst, angleRA) {
  		var HA = lst-angleRA%360;
  		if(HA < 0) HA +=360;

  		return HA;
	}

	function rightAscensionToAngle(hour,minute,second) {
  		return (hour*15 + 0.25*minute + (15/360)*second)
	}
	function alt(ha, dec, lat) {
  		return Math.asin(Math.sin(dec)*Math.sin(lat*Math.PI/180) + Math.cos(dec)*Math.cos(lat*Math.PI/180)*Math.cos(ha*Math.PI/180))*(180/Math.PI);
	}

	function az(dec, alt, lat) {
		return Math.acos(((Math.sin(dec))-(Math.sin(alt*Math.PI/180)*Math.sin(lat*Math.PI/180)))/(Math.cos(alt*Math.PI/180)*Math.cos(lat*Math.PI/180)))*(180/Math.PI);
	}


	function dichotomy(a0,b0,alt,az) {
		function f(x, alt, az) {
			return Math.sqrt((Math.cos(alt*Math.PI/180)*Math.cos(alt*Math.PI/180)*300*300)-(x*x))-(Math.tan((Math.PI/2)-(az*Math.PI/180))*x)
		}
		var a = a0;
		var b = b0;
		var c;

		while (Math.abs(b-a)>0.1) {
			c = (a+b)/2;
			var fa = f(a, alt, az);
			var fb = f(b, alt, az);
			var fc = f(c, alt, az);
			if (Math.sign(fc) == Math.sign(fa)) {
				a = c;
			}
			else {
				b = c;
			}
		}
		return c;
	}

	function coordOnCanvas(c,az,alt) {
		if ((90 <= az) && (az <= 270)) {
			if ((-Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240) >= 240) {
				return {x:Math.round(c+375), y:Math.round((-Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240))};
			}
			else {
				return {x:Math.round(-c+375), y:Math.round((Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240))};
			}
		}
		else {
			if ((-Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240) >= 240) {
				return {x:Math.round(-c+375), y:Math.round((Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240))};
			}
			else {
				return {x:Math.round(c+375), y:Math.round((-Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240))};
			}
		}
	}

	function drawCircle(z) {
		var c = document.getElementById("redcircles");
		var ctx = c.getContext("2d");
		ctx.beginPath();
		ctx.arc(z.x, z.y, 20, 0, 2 * Math.PI);
		ctx.strokeStyle = "red";
		ctx.stroke();
		document.getElementById('clear').addEventListener('click', function() {
          	ctx.clearRect(0, 0, c.width, c.height);
        	}, false);
	}

		const d = new Date();
		const tzoffset = d.getTimezoneOffset()/60;
		var date = {year: d.getFullYear(), month: d.getMonth()+1, day: d.getDate(), hours: d.getHours(), minutes: d.getMinutes(), seconds: d.getSeconds(	)};
		//var date = {year:2022, month:05, day:08, hours:05, minutes:34, seconds:23};
		$const.tlong = 4.5694; // longitude de l'observatoire
		$const.glat = 48.456; // latitude de l'observatoire
		var radius = 300;

		$processor.init ();

		// sun, mercury, venus, moon, mars, jupiter, saturn, uranus, neptune, pluto, chiron, sirius
		var body = $moshier.body.mercury;
		$processor.calc (date, body);
		var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
		document.getElementById("rise_mercury").innerHTML = rise;
		var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
		document.getElementById("ra_mercury").innerHTML = ra;
		if (body.position.astrometricJ2000.dDec > 0) {
			var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		else {
			var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		document.getElementById("d_mercury").innerHTML = dec;
		var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
		document.getElementById("set_mercury").innerHTML = set;
		var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
		var lst = localSideralTime(4.5694);
		var ha = hourAngle(lst,ara);
    	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
		var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
		var z_mercury = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
		if ((0 < altitude) && (altitude < 90)) {
    		document.getElementById("v_mercury").innerHTML = "oui";
		}
		else {
			document.getElementById("v_mercury").innerHTML = "non";
			document.getElementById("b_mercury").disabled = true;
		}


		body = $moshier.body.venus;
		$processor.calc (date, body);
		var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
		document.getElementById("rise_venus").innerHTML = rise;
		var ra = body.position	.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
		document.getElementById("ra_venus").innerHTML = ra;	
		if (body.position.astrometricJ2000.dDec > 0) {
			var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		else {
			var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		document.getElementById("d_venus").innerHTML = dec;
		var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
		document.getElementById("set_venus").innerHTML = set;
		var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
		var lst = localSideralTime(4.5694);
		var ha = hourAngle(lst,ara);
    	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
		var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
		var z_venus = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
		if ((0 < altitude) && (altitude < 90)) {
    		document.getElementById("v_venus").innerHTML = "oui";
		}
		else {
			document.getElementById("v_venus").innerHTML = "non";
			document.getElementById("b_venus").disabled = true;
		}

		body = $moshier.body.mars;
		$processor.calc (date, body);
		var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
		document.getElementById("rise_mars").innerHTML = rise;
		var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
		document.getElementById("ra_mars").innerHTML = ra;	
		if (body.position.astrometricJ2000.dDec > 0) {
			var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		else {
			var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		document.getElementById("d_mars").innerHTML = dec;
		var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
		document.getElementById("set_mars").innerHTML = set;
		var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
		var lst = localSideralTime(4.5694);
		var ha = hourAngle(lst,ara);
    	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
		var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
		var z_mars = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
		if ((0 < altitude) && (altitude < 90)) {
    		document.getElementById("v_mars").innerHTML = "oui";
		}
		else {
			document.getElementById("v_mars").innerHTML = "non";
			document.getElementById("b_mars").disabled = true;
		}

		body = $moshier.body.jupiter;
		$processor.calc (date, body);
		var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
		document.getElementById("rise_jupiter").innerHTML = rise;
		var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
		document.getElementById("ra_jupiter").innerHTML = ra;	
		if (body.position.astrometricJ2000.dDec > 0) {
			var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		else {
			var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}		
		document.getElementById("d_jupiter").innerHTML = dec;
		var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
		document.getElementById("set_jupiter").innerHTML = set;
		var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
		var lst = localSideralTime(4.5694);
		var ha = hourAngle(lst,ara);
    	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
		var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
		var z_jupiter = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
		if ((0 < altitude) && (altitude < 90)) {
    		document.getElementById("v_jupiter").innerHTML = "oui";
		}
		else {
			document.getElementById("v_jupiter").innerHTML = "non";
			document.getElementById("b_jupiter").disabled = true;
		}

		body = $moshier.body.saturn;
		$processor.calc (date, body);
		var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
		document.getElementById("rise_saturn").innerHTML = rise;
		var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
		document.getElementById("ra_saturn").innerHTML = ra;	
		if (body.position.astrometricJ2000.dDec > 0) {
			var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		else {
			var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}		
		document.getElementById("d_saturn").innerHTML = dec;
		var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
		document.getElementById("set_saturn").innerHTML = set;
		var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
		var lst = localSideralTime(4.5694);
		var ha = hourAngle(lst,ara);
    	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
		var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
		var z_saturn = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
		if ((0 < altitude) && (altitude < 90)) {
    		document.getElementById("v_saturn").innerHTML = "oui";
		}
		else {
			document.getElementById("v_saturn").innerHTML = "non";
			document.getElementById("b_saturn").disabled = true;
		}

		body = $moshier.body.uranus;
		$processor.calc (date, body);
		var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
		document.getElementById("rise_uranus").innerHTML = rise;
		var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
		document.getElementById("ra_uranus").innerHTML = ra;	
		if (body.position.astrometricJ2000.dDec > 0) {
			var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		else {
			var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}		
		document.getElementById("d_uranus").innerHTML = dec;
		var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
		document.getElementById("set_uranus").innerHTML = set;
		var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
		var lst = localSideralTime(4.5694);
		var ha = hourAngle(lst,ara);
    	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
		var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
		var z_uranus = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
		if ((0 < altitude) && (altitude < 90)) {
    		document.getElementById("v_uranus").innerHTML = "oui";
		}
		else {
			document.getElementById("v_uranus").innerHTML = "non";
			document.getElementById("b_uranus").disabled = true;
		}


		body = $moshier.body.neptune;
		$processor.calc (date, body);
		var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
		document.getElementById("rise_neptune").innerHTML = rise;
		var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
		document.getElementById("ra_neptune").innerHTML = ra;	
		if (body.position.astrometricJ2000.dDec > 0) {
			var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		else {
			var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}		
		document.getElementById("d_neptune").innerHTML = dec;
		var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
		document.getElementById("set_neptune").innerHTML = set;
		var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
		var lst = localSideralTime(4.5694);
		var ha = hourAngle(lst,ara);
    	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
		var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
		var z_neptune = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
		if ((0 < altitude) && (altitude < 90)) {
    		document.getElementById("v_neptune").innerHTML = "oui";
		}
		else {
			document.getElementById("v_neptune").innerHTML = "non";
			document.getElementById("b_neptune").disabled = true;
		}

		body = $moshier.body.chiron;
		$processor.calc (date, body);
		var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
		document.getElementById("rise_chiron").innerHTML = rise;
		var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
		document.getElementById("ra_chiron").innerHTML = ra;	
		if (body.position.astrometricJ2000.dDec > 0) {
			var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}
		else {
			var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
		}		
		document.getElementById("d_chiron").innerHTML = dec;
		var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
		document.getElementById("set_chiron").innerHTML = set;
		var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
		var lst = localSideralTime(4.5694);
		var ha = hourAngle(lst,ara);
    	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
		var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
		var z_chiron = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
		if ((0 < altitude) && (altitude < 90)) {
    		document.getElementById("v_chiron").innerHTML = "oui";
		}
		else {
			document.getElementById("v_chiron").innerHTML = "non";
			document.getElementById("b_chiron").disabled = true;
		}

		body = $moshier.body.sirius;
		$processor.calc (date, body);
		var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
		document.getElementById("rise_sirius").innerHTML = rise;
		var ra = body.position.astrimetricJ2000.ra.hours + 'h' + body.position.astrimetricJ2000.ra.minutes + 'm' + body.position.astrimetricJ2000.ra.seconds + 's';
		document.getElementById("ra_sirius").innerHTML = ra;	
		if (body.position.astrimetricJ2000.dDec > 0) {
			var dec = body.position.astrimetricJ2000.dec.degree + '°' + body.position.astrimetricJ2000.dec.minutes + "'";
		}
		else {
			var dec = "-" + body.position.astrimetricJ2000.dec.degree + '°' + body.position.astrimetricJ2000.dec.minutes + "'";
		}		
		document.getElementById("d_sirius").innerHTML = dec;
		var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
		document.getElementById("set_sirius").innerHTML = set;
		var ara = rightAscensionToAngle(body.position.astrimetricJ2000.ra.hours, body.position.astrimetricJ2000.ra.minutes, body.position.astrimetricJ2000.ra.seconds);
		var lst = localSideralTime(4.5694);
		var ha = hourAngle(lst,ara);
    	var altitude = alt(ha,body.position.astrimetricJ2000.dDec,48.456);
		var azimuth = az(body.position.astrimetricJ2000.dDec,altitude,48.456);
		var z_sirius = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
		if ((0 < altitude) && (altitude < 90)) {
    		document.getElementById("v_sirius").innerHTML = "oui";
		}
		else {
			document.getElementById("v_sirius").innerHTML = "non";
			document.getElementById("b_sirius").disabled = true;
		}
	</script>
    </body>
</html>
