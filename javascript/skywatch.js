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

	// Taille du canvas
	const cWidth = canvas.width;
    const cHeight = canvas.height;

	// Initial du processeur de calcul des éphémérides
	$processor.init ();

	// Liste des propriétés des planètes
	let planets=[{ name: "Mercure", id: "mercure", body: $moshier.body.mercury }
		, { name: "Vénus", id: "venus", body: $moshier.body.venus }
		, { name: "Mars", id: "mars", body: $moshier.body.mars }
		, { name: "Jupiter", id: "jupiter", body: $moshier.body.jupiter }
		, { name: "Saturne", id: "saturne", body: $moshier.body.saturn }
		, { name: "Uranus", id: "uranus", body: $moshier.body.uranus }
		, { name: "Neptune", id: "neptune", body: $moshier.body.neptune }
	];

	// Construction dynamique du tableau
	$("#tb-planets").empty();
	var tabHeader="<thead><tr><th></th>",
	    tabLever="<tr><td>Lever (UT)</td>",
		tabCoucher="<tr><td>Coucher (UT)</td>",
		tabAD="<tr><td>Ascension Droite</td>",
		tabDec="<tr><td>Déclinaison</td>";

	planets.forEach(function(planet) {
		$processor.calc (date, planet.body);
		tabHeader=tabHeader+"<th id='th_"+planet.id+"' class='th_planet'>"+planet.name+"</th>";
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

	planets.forEach(function(planet) {
		$("#th_"+planet.id).on("click", function() {
			$processor.calc (date, planet.body);
			let ra=planet.body.position.apparent.ra;
			let dec=planet.body.position.apparent.dec;
			let position = celestialToCartesian(ra.hours, ra.minutes, ra.seconds, dec.degree, dec.minutes, dec.seconds, $const.glat, $const.tlong, cWidth, cHeight);
			drawMarker(position);
			console.info(planet.name);
			console.info(position);
		});
	});
	
}

function celestialToCartesian(raHours, raMinutes, raSeconds, decDegrees, decMinutes, decSeconds, latitude, longitude, width, height) {
    // Helper functions
    const radians = (degrees) => degrees * Math.PI / 180;
    const toDecimalHours = (hours, minutes, seconds) => hours + (minutes / 60) + (seconds / 3600);
    const toDecimalDegrees = (degrees, minutes, seconds) => degrees + (minutes / 60) + (seconds / 3600);

    // Convert RA and Dec to decimal hours and decimal degrees
    let raDecimalHours = toDecimalHours(raHours, raMinutes, raSeconds);
    let decDecimalDegrees = toDecimalDegrees(decDegrees, decMinutes, decSeconds);

    // Convert RA and Dec to radians
    let raRad = radians(raDecimalHours * 15); // converting hours to degrees by multiplying by 15
    let decRad = radians(decDecimalDegrees);

    // Calculate Greenwich Sidereal Time and Local Sidereal Time
    let now = new Date();
    let gst = getGST(now);
    let lst = (gst + longitude / 15) % 24; // Ensure LST wraps around correctly
    let lstRad = radians(lst * 15);

    // Calculate Hour Angle in radians
    let ha = lstRad - raRad;
    ha = (ha + 2 * Math.PI) % (2 * Math.PI); // Normalize hour angle to be between 0 and 2π

    // Convert observer's latitude to radians
    let latRad = radians(latitude);

    // Calculate altitude and azimuth
    let sinAlt = Math.sin(decRad) * Math.sin(latRad) + Math.cos(decRad) * Math.cos(latRad) * Math.cos(ha);
    let alt = Math.asin(sinAlt);
    let cosA = (Math.sin(decRad) - Math.sin(alt) * Math.sin(latRad)) / (Math.cos(alt) * Math.cos(latRad));
    let az = Math.acos(cosA);
    if (Math.sin(ha) > 0) {
        az = 2 * Math.PI - az;
    }

    // Map to Cartesian coordinates
    let x = width / 2 + (az / (2 * Math.PI) * width);
    let y = height / 2 - (alt / (Math.PI / 2) * height / 2);

    return { x: x, y: y};   
}

// Function to calculate Greenwich Sidereal Time based on current date and time
function getGST(now) {
    let s = now.getUTCHours() + now.getUTCMinutes() / 60 + now.getUTCSeconds() / 3600;
    // Simplified GST formula: this is approximate and works for casual use
    let gst = (18.697374558 + 24.06570982441908 * (now / 86400000)) % 24;
    return gst;
}

function drawMarker(position) {
	let canvasDraw = document.getElementById("canvas");
	let ctxDraw = canvas.getContext("2d");
	//document.getElementById("xycoordinates").innerHTML="Coordonn&eacute;es (x,y): (" + x + "," + y + ")";

	ctxDraw.beginPath();
	ctxDraw.arc(position.x, position.y, 10, 0, 2 * Math.PI); // Reduced the radius to 10 for better visibility
	ctxDraw.strokeStyle = "red";
	ctxDraw.stroke();
	//ctxDraw.fillStyle = 'red';
	//ctxDraw.fill();
}