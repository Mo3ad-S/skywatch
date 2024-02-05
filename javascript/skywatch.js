function load_image(){
	//var image  = document.getElementById('image_skywatch');
	var canvas = document.getElementById("canvas");
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

	var dtImage = document.getElementById("dt_image");
	$.ajax({
		url: './get_date_image.php',
		type: 'GET',
		dataType: "json",
		contentType: "application/json",
		success: function (data) {
			canvas.style="background-size: cover; background-image: url("+data+")";

			var dt = moment(data.substr(11), "YYYY_MM_DD__hh_mm_ss").locale('fr-FR').format('LLLL');
			dtImage.innerHTML=dt.charAt(0).toUpperCase() + dt.slice(1);
        }
	});
}

function cnvs_getCoordinates(e)
{
	var canvas = document.getElementById("canvas");
	var bounds = canvas.getBoundingClientRect();
	x=e.clientX - bounds.left+0.5;
	y=e.clientY - bounds.top;
	document.getElementById("xycoordinates").innerHTML="Coordonn&eacute;es (x,y): (" + x + "," + y + ")";
	
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

function initPlanete() {
	$processor.init ();

	let planets=[{ name: "Mercure", apparent: $moshier.body.mercury.apparent, transit: $moshier.body.mercury.transit}
		, { name: "Vénus", apparent: $moshier.body.venus.apparent, transit: $moshier.body.venus.transit}
		, { name: "Mars", apparent: $moshier.body.mars.apparent, transit: $moshier.body.mars.transit}
		, { name: "Jupiter", apparent: $moshier.body.jupiter.apparent, transit: $moshier.body.jupiter.transit}
		, { name: "Saturne", apparent: $moshier.body.saturn.apparent, transit: $moshier.body.saturn.transit}
		, { name: "Uranus", apparent: $moshier.body.uranus.apparen, transit: $moshier.body.uranus.transitt}
		, { name: "Neptune", apparent: $moshier.body.neptune.apparent, transit: $moshier.body.neptune.transit}
	];
	// sun, mercury, venus, moon, mars, jupiter, saturn, uranus, neptune, pluto, chiron, sirius
	$("#tb-planets").empty();
	var tabHeader="<thead><tr><th></th>",
	    tabLever="<tr><td>Lever</td>",
		tabAD="<tr><td>Ascension Droite</td>",
		tabDeec="<tr><td>Déclinaison</td>";
	planets.forEach(function(planet) {
		tabHeader=tabHeader+"<th>"+planet.name+"</th>";
		tabLever=tabLever+"<tr>"+planet.transitt.approxRiseUT.hours+":"+planet.transitt.approxRiseUT.minutes+"</tr>";
		tabAD=tabAD+"<tr>"+planet.apparent.dRA+"</tr>";
		tabDeec=tabDeec+"<tr>"+planet.apparent.dDec+"</tr>";
		$processor.calc (date, planet);
		document.write(`<p style="white-space: pre-wrap">${JSON.stringify(body.position, '', 2)}</p>`);
	});
	tabHeader=tabHeader+"</tr></thead>";
		
	document.write(`<p style="white-space: pre-wrap">${JSON.stringify(body.position, '', 2)}</p>`);
	
}