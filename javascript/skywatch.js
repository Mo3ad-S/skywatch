var date = {year:2021, month:10, day:09, hours:00, minutes:35, seconds:49};
var cercle = {
	x: 375,
	y: 248,
	r: 334,
	start: 0,
	end: 2 * Math.PI
}

function load_image(){
	let canvas = document.getElementById("canvas");
	let ctx = canvas.getContext("2d");

	$("#canvas").on("click", function() {
		ctx.clearRect(0, 0, canvas.width, canvas.height);
	});

	$.ajax({
		url: './get_date_image.php',
		type: 'GET',
		dataType: "text",
		contentType: "text/plain",
		success: function (data) {
			canvas.style="background-size: cover; background-image: url("+data+")";

			var dt = moment(data.substr(11), "YYYY_MM_DD__hh_mm_ss").locale('fr-FR').format('LLLL');
			$("#dt_image").html(dt.charAt(0).toUpperCase() + dt.slice(1));
			init();

			ctx.beginPath();
			ctx.arc(cercle.x, cercle.y, cercle.r, cercle.start, cercle.end);
			ctx.strokeStyle = "red";
			ctx.stroke();
			
			// 80°
			ctx.beginPath();
			ctx.ellipse(cercle.x, 62, 49, 41, 0, cercle.start, cercle.end);	
			ctx.strokeStyle = "red";
			ctx.stroke();
			
			// 70°
			ctx.beginPath();
			ctx.ellipse(cercle.x, 67, 97, 81, 0, cercle.start, cercle.end);	
			ctx.strokeStyle = "red";
			ctx.stroke();
			
			// 60°
			ctx.beginPath();
			ctx.ellipse(cercle.x, 73, 144, 121, 0, cercle.start, cercle.end);	
			ctx.strokeStyle = "red";
			ctx.stroke();
			
			// 50°
			ctx.beginPath();
			ctx.ellipse(cercle.x, 81, 189, 159, 0, cercle.start, cercle.end);	
			ctx.strokeStyle = "red";
			ctx.stroke();
			
			// 40°
			ctx.beginPath();
			ctx.ellipse(cercle.x, 93, 231, 195, 0, cercle.start, cercle.end);	
			ctx.strokeStyle = "red";
			ctx.stroke();
			
			// 30°
			ctx.beginPath();
			ctx.ellipse(cercle.x, 108, 270, 225, 0, cercle.start, cercle.end);	
			ctx.strokeStyle = "red";
			ctx.stroke();

			// 20°
			ctx.beginPath();
			ctx.ellipse(cercle.x, 123, 305, 255, 0, cercle.start, cercle.end);	
			ctx.strokeStyle = "red";
			ctx.stroke();

			// 10°
			ctx.beginPath();
			ctx.ellipse(cercle.x, 138, 338, 284, 0, cercle.start, cercle.end);	
			ctx.strokeStyle = "red";
			ctx.stroke();

			// 0°
			ctx.beginPath();
			ctx.ellipse(cercle.x, 153, 365, 310, 0, cercle.start, cercle.end);	
			ctx.strokeStyle = "red";
			ctx.stroke();
		}
	});
}

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
			return {x:Math.round(-c+375), y:Math.round((-Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240))};
		}
		else {
			return {x:Math.round(c+375), y:Math.round((Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240))};
		}
	}
	else {
		if ((-Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240) >= 240) {
			return {x:Math.round(c+375), y:Math.round((Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240))};
		}
		else {
			return {x:Math.round(-c+375), y:Math.round((-Math.tan(Math.PI/2 - az*(Math.PI/180))*c+240))};
		}
	}
}

function drawCircle(z) {
	//var c = $("#redcircles");
	let canvas = document.getElementById("canvas");
	let ctx = canvas.getContext("2d");
	ctx.beginPath();
	ctx.arc(z.x, z.y, 20, 0, 2 * Math.PI);
	ctx.strokeStyle = "red";
	ctx.stroke();
	document.getElementById('clear').addEventListener('click', function() {
		  ctx.clearRect(0, 0, c.width, c.height);
		}, false);
}

function init() {

	const d = new Date();
	const tzoffset = d.getTimezoneOffset()/60;
	//var date = {year: d.getFullYear(), month: d.getMonth()+1, day: d.getDate(), hours: d.getHours(), minutes: d.getMinutes(), seconds: d.getSeconds(	)};
	$const.tlong = 4.5694; // longitude de l'observatoire
	$const.glat = 48.456; // latitude de l'observatoire
	var radius = 300;

	$processor.init ();

	// sun, mercury, venus, moon, mars, jupiter, saturn, uranus, neptune, pluto, chiron, sirius
	var body = $moshier.body.mercury;
	$processor.calc (date, body);
	var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
	$("#rise_mercury").html(rise);
	var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
	$("#ra_mercury").html(ra);
	if (body.position.astrometricJ2000.dDec > 0) {
		var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	else {
		var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	$("#d_mercury").html(dec);
	var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
	$("#set_mercury").html(set);
	var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
	var lst = localSideralTime(4.5694);
	var ha = hourAngle(lst,ara);
	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
	var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
	var z_mercury = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
	if ((0 < altitude) && (altitude < 90)) {
		$("#v_mercury").html("oui");
	}
	else {
		$("#v_mercury").html("non");
		$("#b_mercury").disabled = true;
	}


	body = $moshier.body.venus;
	$processor.calc (date, body);
	var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
	$("#rise_venus").html(rise);
	var ra = body.position	.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
	$("#ra_venus").html(ra);	
	if (body.position.astrometricJ2000.dDec > 0) {
		var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	else {
		var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	$("#d_venus").html(dec);
	var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
	$("#set_venus").html(set);
	var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
	var lst = localSideralTime(4.5694);
	var ha = hourAngle(lst,ara);
	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
	var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
	var z_venus = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
	$("#b_venus").on("click", function() {
		drawCircle(z_venus);
	});
	if ((0 < altitude) && (altitude < 90)) {
		$("#v_venus").html("oui");
	}
	else {
		$("#v_venus").html("non");
		$("#b_venus").disabled = true;
	}

	body = $moshier.body.mars;
	$processor.calc (date, body);
	var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
	$("#rise_mars").html(rise);
	var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
	$("#ra_mars").html(ra);	
	if (body.position.astrometricJ2000.dDec > 0) {
		var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	else {
		var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	$("#d_mars").html(dec);
	var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
	$("#set_mars").html(set);
	var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
	var lst = localSideralTime(4.5694);
	var ha = hourAngle(lst,ara);
	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
	var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
	var z_mars = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
	$("#b_mars").on("click", function() {
		drawCircle(z_mars);
	});
	if ((0 < altitude) && (altitude < 90)) {
		$("#v_mars").html("oui");
	}
	else {
		$("#v_mars").html("non");
		$("#b_mars").disabled = true;
	}

	body = $moshier.body.jupiter;
	$processor.calc (date, body);
	var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
	$("#rise_jupiter").html(rise);
	var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
	$("#ra_jupiter").html(ra);	
	if (body.position.astrometricJ2000.dDec > 0) {
		var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	else {
		var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}		
	$("#d_jupiter").html(dec);
	var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
	$("#set_jupiter").html(set);
	var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
	var lst = localSideralTime(4.5694);
	var ha = hourAngle(lst,ara);
	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
	var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
	var z_jupiter = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
	$("#b_jupiter").on("click", function() {
		drawCircle(z_jupiter);
	});
	if ((0 < altitude) && (altitude < 90)) {
		$("#v_jupiter").html("oui");
	}
	else {
		$("#v_jupiter").html("non");
		$("#b_jupiter").disabled = true;
	}

	body = $moshier.body.saturn;
	$processor.calc (date, body);
	var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
	$("#rise_saturn").html(rise);
	var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
	$("#ra_saturn").html(ra);	
	if (body.position.astrometricJ2000.dDec > 0) {
		var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	else {
		var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}		
	$("#d_saturn").html(dec);
	var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
	$("#set_saturn").html(set);
	var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
	var lst = localSideralTime(4.5694);
	var ha = hourAngle(lst,ara);
	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
	var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
	var z_saturn = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
	$("#b_saturn").on("click", function() {
		drawCircle(z_saturn);
	});
	if ((0 < altitude) && (altitude < 90)) {
		$("#v_saturn").html("oui");
	}
	else {
		$("#v_saturn").html("non");
		$("#b_saturn").disabled = true;
	}

	body = $moshier.body.uranus;
	$processor.calc (date, body);
	var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
	$("#rise_uranus").html(rise);
	var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
	$("#ra_uranus").html(ra);	
	if (body.position.astrometricJ2000.dDec > 0) {
		var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	else {
		var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}		
	$("#d_uranus").html(dec);
	var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
	$("#set_uranus").html(set);
	var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
	var lst = localSideralTime(4.5694);
	var ha = hourAngle(lst,ara);
	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
	var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
	var z_uranus = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
	$("#b_uranus").on("click", function() {
		drawCircle(z_uranus);
	});
	if ((0 < altitude) && (altitude < 90)) {
		$("#v_uranus").html("oui");
	}
	else {
		$("#v_uranus").html("non");
		$("#b_uranus").disabled = true;
	}

	body = $moshier.body.neptune;
	$processor.calc (date, body);
	var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
	$("#rise_neptune").html(rise);
	var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
	$("#ra_neptune").html(ra);	
	if (body.position.astrometricJ2000.dDec > 0) {
		var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	else {
		var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}		
	$("#d_neptune").html(dec);
	var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
	$("#set_neptune").html(set);
	var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
	var lst = localSideralTime(4.5694);
	var ha = hourAngle(lst,ara);
	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
	var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
	var z_neptune = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
	$("#b_neptune").on("click", function() {
		drawCircle(z_neptune);
	});
	if ((0 < altitude) && (altitude < 90)) {
		$("#v_neptune").html("oui");
	}
	else {
		$("#v_neptune").html("non");
		$("#b_neptune").disabled = true;
	}

	body = $moshier.body.chiron;
	$processor.calc (date, body);
	var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
	$("#rise_chiron").html(rise);
	var ra = body.position.astrometricJ2000.ra.hours + 'h' + body.position.astrometricJ2000.ra.minutes + 'm' + body.position.astrometricJ2000.ra.seconds + 's';
	$("#ra_chiron").html(ra);	
	if (body.position.astrometricJ2000.dDec > 0) {
		var dec = body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}
	else {
		var dec = "-" + body.position.astrometricJ2000.dec.degree + '°' + body.position.astrometricJ2000.dec.minutes + "'";
	}		
	$("#d_chiron").html(dec);
	var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
	$("#set_chiron").html(set);
	var ara = rightAscensionToAngle(body.position.astrometricJ2000.ra.hours, body.position.astrometricJ2000.ra.minutes, body.position.astrometricJ2000.ra.seconds);
	var lst = localSideralTime(4.5694);
	var ha = hourAngle(lst,ara);
	var altitude = alt(ha,body.position.astrometricJ2000.dDec,48.456);
	var azimuth = az(body.position.astrometricJ2000.dDec,altitude,48.456);
	var z_chiron = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
	$("#b_chiron").on("click", function() {
		drawCircle(z_chiron);
	});
	if ((0 < altitude) && (altitude < 90)) {
		$("#v_chiron").html("oui");
	}
	else {
		$("#v_chiron").html("non");
		$("#b_chiron").disabled = true;
	}

	body = $moshier.body.sirius;
	$processor.calc (date, body);
	var rise = (body.position.altaz.transit.approxRiseUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxRiseUT.minutes + 'm';
	$("#rise_sirius").html(rise);
	var ra = body.position.astrimetricJ2000.ra.hours + 'h' + body.position.astrimetricJ2000.ra.minutes + 'm' + body.position.astrimetricJ2000.ra.seconds + 's';
	$("#ra_sirius").html(ra);	
	if (body.position.astrimetricJ2000.dDec > 0) {
		var dec = body.position.astrimetricJ2000.dec.degree + '°' + body.position.astrimetricJ2000.dec.minutes + "'";
	}
	else {
		var dec = "-" + body.position.astrimetricJ2000.dec.degree + '°' + body.position.astrimetricJ2000.dec.minutes + "'";
	}		
	$("#d_sirius").html(dec);
	var set = (body.position.altaz.transit.approxSetUT.hours-tzoffset)%24 + 'h' + body.position.altaz.transit.approxSetUT.minutes + 'm';
	$("#set_sirius").html(set);
	var ara = rightAscensionToAngle(body.position.astrimetricJ2000.ra.hours, body.position.astrimetricJ2000.ra.minutes, body.position.astrimetricJ2000.ra.seconds);
	var lst = localSideralTime(4.5694);
	var ha = hourAngle(lst,ara);
	var altitude = alt(ha,body.position.astrimetricJ2000.dDec,48.456);
	var azimuth = az(body.position.astrimetricJ2000.dDec,altitude,48.456);
	var z_sirius = coordOnCanvas(dichotomy(-300,300,azimuth,altitude),azimuth,altitude);
	$("#b_sirius").on("click", function() {
		drawCircle(z_sirius);
	});
	if ((0 < altitude) && (altitude < 90)) {
		$("#v_sirius").html("oui");
	}
	else {
		$("#v_sirius").html("non");
		$("#b_sirius").disabled = true;
	}
}