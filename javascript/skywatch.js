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