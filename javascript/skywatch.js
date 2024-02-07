const zeroPad = (num, places) => String(num).padStart(places, '0')

function load_image(){
	//var image  = document.getElementById('image_skywatch');
	//var ctx = canvas.getContext("2d");
	//var img = new Image();

/*	$.ajax({
		url: './get_image.php',
		type: 'GET',
		dataType: "json",
		contentType: "application/json",
		success: function (data) {
			img.src=data;
			//ctx.drawImage(img, 0, 0, 1548, 1040, 0, 0, 750, 500);
			//ctx.drawImage(img, 0, 0, 0, 0, 750, 500);
			//img.style.display = 'none';
        }
	});*/

	let image="2021_04_07__22_24_29";
	var canvas = document.getElementById("canvas");
	canvas.style="background-size: cover; background-image: url(img/"+image+".jpg)";

	var dt = moment(image, "YYYY_MM_DD__hh_mm_ss").locale('fr-FR').format('LLLL');
	var dtImage = document.getElementById("dt_image");
	dtImage.innerHTML=dt.charAt(0).toUpperCase() + dt.slice(1);
	initPlanete( moment(image, "YYYY_MM_DD__hh_mm_ss"));

	/*$.ajax({
		url: './get_date_image.php',
		type: 'GET',
		dataType: "json",
		contentType: "application/json",
		success: function (data) {
			canvas.style="background-size: cover; background-image: url("+data+")";

			var dt = moment(data.substr(11), "YYYY_MM_DD__hh_mm_ss").locale('fr-FR').format('LLLL');
			dtImage.innerHTML=dt.charAt(0).toUpperCase() + dt.slice(1);
        }
	});*/
}

function cnvs_getCoordinates(e)
{
	var canvas = document.getElementById("canvas");
	var bounds = canvas.getBoundingClientRect();
	x=e.clientX - bounds.left+0.5;
	y=e.clientY - bounds.top;
	document.getElementById("xycoordinates").innerHTML="Coordonn&eacute;es (x,y): (" + x + "," + y + ")";
	//https://astronomie.baillet.org/ephemerides/systeme-solaire/jupiter.php
	/*var ctx = canvas.getContext("2d");
	ctx.beginPath();
	ctx.arc(x, y, 10, 0, 2 * Math.PI);
	ctx.strokeStyle = "red";
	ctx.stroke();*/
}

function cnvs_clearCoordinates()
{
	document.getElementById("xycoordinates").innerHTML="";
}

function initPlanete(dt) {
	var date = {year: dt.year(), month: dt.month(), day: dt.day(), hours: dt.hour(), minutes: dt.minute(), seconds: dt.second()};

	$const.tlong = -4.572820; // longitude
	$const.glat = 48.36093; // latitude

	$processor.init ();

	//name: "Mercure", apparent: $moshier.body.mercury.apparent, transit: $moshier.body.mercury.transit}
	let planets=[{ name: "Mercure", body: $moshier.body.mercury }
		, { name: "Vénus", body: $moshier.body.venus }
		, { name: "Mars", body: $moshier.body.mars }
		, { name: "Jupiter", body: $moshier.body.jupiter }
		, { name: "Saturne", body: $moshier.body.saturn }
		, { name: "Uranus", body: $moshier.body.uranus }
		, { name: "Neptune", body: $moshier.body.neptune }
	];
	// sun, mercury, venus, moon, mars, jupiter, saturn, uranus, neptune, pluto, chiron, sirius
	$("#tb-planets").empty();
	var tabHeader="<thead><tr><th></th>",
	    tabLever="<tr><td>Lever (UT)</td>",
		tabCoucher="<tr><td>Coucher (UT)</td>",
		tabAD="<tr><td>Ascension Droite</td>",
		tabDec="<tr><td>Déclinaison</td>";

	planets.forEach(function(planet) {
		$processor.calc (date, planet.body);
		tabHeader=tabHeader+"<th>"+planet.name+"</th>";
		tabLever=tabLever+"<td>"+zeroPad(planet.body.position.altaz.transit.approxRiseUT.hours,2)+"h"+zeroPad(planet.body.position.altaz.transit.approxRiseUT.minutes,2)+"</td>";
		tabCoucher=tabCoucher+"<td>"+zeroPad(planet.body.position.altaz.transit.approxSetUT.hours,2)+"h"+zeroPad(planet.body.position.altaz.transit.approxSetUT.minutes,2)+"</td>";
		tabAD=tabAD+"<td>"+planet.body.position.apparent.ra.hours+"h"+planet.body.position.apparent.ra.minutes+"m"+planet.body.position.apparent.ra.seconds+"</td>";
		tabDec=tabDec+"<td>"+planet.body.position.apparent.dec.degree+"°"+planet.body.position.apparent.dec.minutes+"'"+planet.body.position.apparent.dec.seconds.toFixed(0)+"''</td>";
	});
	tabHeader=tabHeader+"</tr></thead>";
	tabLever=tabLever+"</tr>";
	tabCoucher=tabCoucher+"</tr>";
	tabAD=tabAD+"</tr>";
	tabDec=tabDec+"</tr>";

	let htmlTab=tabHeader+"<tbody>"+tabLever+tabCoucher+tabAD+tabDec+"</tbody>\
	<tfoot>\
		<tr>\
			<td colspan='8' style='text-align: right'>Ephéméride des planètes</td>\
		</tr>\
	</tfoot>";

		
	$("#tb-planets").append(htmlTab);
	
}