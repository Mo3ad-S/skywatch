function load_image(){
	//var image  = document.getElementById('image_skywatch');
	var canvas = document.getElementById("canvas");
	var ctx = canvas.getContext("2d");
	var img = new Image();

	$.ajax({
		url: './get_image.php',
		type: 'GET',
		dataType: "json",
		contentType: "application/json",
		success: function (data) {
			img.src=data;
			ctx.drawImage(img, 0, 0, 750, 500);
			//img.style.display = 'none';
			                
			// si la date de l'image date de moins d'une heure
			//cam = document.getElementById("cam");
			/*if (moment(data.substr(11,20), "YYYY_MM_DD__hh_mm_ss")>moment().subtract(1, 'hours')) {
				cam.style.color = "green";
			    cam.title="Caméra en ligne";
			} else {
				cam.document.getElementById("cam").style.color = "red";
			    cam.title="Caméra hors ligne";
			}*/
        }
	});
}
