<?php
    #on récupère les données météo depuis l'api
    $url = "http://api.openweathermap.org/data/2.5/weather?q=Plouzan%C3%A9&lang=fr&units=metric&appid=63b47d491981e87de1e1319c8d5b08b0";

    $file = file_get_contents($url);

    $json = json_decode($file);

    

    # Récupération et conversion des données météorologiques
    $name = $json->name;
    $meteo = $json -> weather[0] -> main;
    $tempC = number_format($json -> main -> temp);
    $wind = $json -> wind -> speed ;
    $windkmh = number_format($wind*3.6);
    $humidity = $json -> main -> humidity;
    $sunrise = $json -> sys -> sunrise;
    $sunset = $json -> sys -> sunset;
    $description = $json -> weather[0] -> description; 
    $id = $json -> weather[0] -> id;
    $icon = $json -> weather[0] -> icon;

    ### Conversion du lever du soleil
    $dtL = new DateTime('@' . $sunrise);
    $dtL->setTimezone(new DateTimeZone('Europe/Paris'));
    ### Conversion du coucher du soleil
    $dtC = new DateTime('@' . $sunset);
    $dtC->setTimezone(new DateTimeZone('Europe/Paris'));


    ### Variables Seeing
    $Tseuil = 4 ; 
    $Vseuil = 4 ;
    $Hseuil = 75 ;    
   
    #fonction intermédiaire pour calculer le seeing
    function testConditions($seeing,$tempC,$wind,$humidity){
        global $Tseuil,$Vseuil,$Hseuil;
        if ($tempC > $Tseuil){
            $seeing=$seeing-1;
        }
        if ($wind >$Vseuil ){
            $seeing=$seeing-1;
        }
        if ($humidity >$Hseuil ){
            $seeing=$seeing-1;
        }

        if ($seeing<1 ){
            $seeing = 1;
        }
        echo $seeing; 

    }
    ### Calcul du Seeing
    function seeing($tempC,$meteo,$wind,$humidity,$description,$id) {

        global $Tseuil,$Vseuil,$Hseuil,$sunrise,$sunset ;
        
        
       
        #on traite tous les cas de météo

        if ($meteo == "Clear" ){
            $seeing = 9;
            testConditions($seeing,$tempC,$wind,$humidity);
        }
        if ($meteo == "Clouds"){
            $seeing = 6;
            if ($description =="scattered clouds"){
                $seeing=$seeing-1;
            }
            if ($description =="broken clouds"){
                $seeing=$seeing-2;
            }
            if ($description =="overcast clouds"){
                $seeing=$seeing-4;
            }
            testConditions($seeing,$tempC,$wind,$humidity);
        }
        if ($meteo == "Rain"){
            $seeing = 6;
            if ($id == 501 or $id == 520 or $id == 521 ){
                $seeing=$seeing-2;
            }
            if ($id == 502 or $id == 503 or $id == 504 or $id == 511 or $id == 522 or $id == 531 )
            { $seeing=$seeing-4;  
            }
            testConditions($seeing,$tempC,$wind,$humidity); 

        }
        if ($meteo == "Drizzle"){
            $seeing = 6;
            if ($id == 301 or $id == 311 or $id == 321 ) {
                $seeing=$seeing-2;
            }
            if ($id == 302 or $id == 312 or $id == 313 or $id == 314 )
            { $seeing=$seeing-4;  
            }
            testConditions($seeing,$tempC,$wind,$humidity); 

        }
        if ($meteo == "Snow"){
            $seeing = 6;
            if ($id == 601 or $id == 611 or $id == 612 or $id == 615 or $id == 620 ) {
                $seeing=$seeing-1;
            }
            if ($id == 613 or $id == 616 or $id == 621) {
                $seeing=$seeing-2;
            }
            if ($id == 602 or $id == 622)
            { $seeing=$seeing-4;  
            }
            testConditions($seeing,$tempC,$wind,$humidity);

        }
        if ($meteo == "Thunderstorm"){
            $seeing = 2;
            if ($id == 210) {
                $seeing=$seeing+1;
            }
            testConditions($seeing,$tempC,$wind,$humidity); 

        }
        if ($meteo == "Fog" || $meteo == "Mist" || $meteo == "Smoke" || $meteo == "Haze" || $meteo == "Dust" || $meteo == "Sand" || $meteo == "Ash" || $meteo == "Squall" || $meteo == "Tornado"){
            $seeing = 2;
            testConditions($seeing,$tempC,$wind,$humidity); 

        }
        return;
    }

    #on définit le fuseau horaire
    date_default_timezone_set("Europe/Paris");

?>

<br>
				<table class="table table-hover">
					<!-- tableau météo -->
				  <thead>
					<tr>
						<th>Infos météo</th>
					</tr>
				  </thead>
				  <tbody>
				  <tr>
					<th>Ville</th>
					<td><?php echo $name ?></td>
				  </tr>
				  <tr>
					<th>Météo</th>
					<td><?php echo $meteo ?></td>
				  </tr>
				  <tr>
					<th>Description</th>
					<td class="caseicone"><?php echo $description ?> <img src = "http://openweathermap.org/img/wn/<?php echo $icon ?>@2x.png" class="icone"> </td>
				  </tr> 
				  <tr>
					<th>Date</th>
					<td><?php echo date("d/m/Y") ?></td>
				  </tr>
				  <tr>
					<th>Heure</th>
					<td><?php echo date("H:i:s") ?></td>
				  </tr>
				  <tr>
					<th>Température</th>
					<td><?php echo $tempC ?> °C</td>
				  </tr>
				  <tr>
					<th>Vent</th>
					<td><?php echo $windkmh ?> km/h</td>
				  </tr>
				  <tr>
					<th>Humidité</th>
					<td><?php echo $humidity ?> %</td>
				  </tr>
				  <tr>
					<th>Lever du soleil</th>
					<td><?php echo $dtL->format('H:i') ?></td>
				  </tr>
				  <tr>
					<th>Coucher du soleil</th>
					<td><?php echo $dtC->format('H:i') ?></td>
				  </tr>
				  <tr>
					<th>Qualité du ciel (1 à 9)</th>
					<td><?php seeing($tempC,$meteo,$wind,$humidity,$description,$id); ?></td>
				  </tr>
				</tbody>
				</table>
