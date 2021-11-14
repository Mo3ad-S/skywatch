<!DOCTYPE html>
<html>
    <head>
        <title>Affichage des photos recherchées</title>
        <meta charset="utf-8">
        
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </head>
	<style>
img {
	border: 1px solid #ddd; /* Gray border */
	border-radius: 4px;  /* Rounded border */
	padding: 5px; /* Some padding */
	width: 150px; /* Set a small width */}
/* Add a hover effect (blue shadow) */
img:hover {
	box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);}
.back, .link{
    text-decoration: none;
    color: teal;
    text-transform: uppercase;
    padding: 0;
    margin: 0 15px;
    transition: all 0.2s ease-in-out;
    border-bottom: 2px solid transparent;}
.link{
    padding-left:15px;}
.back:hover, .link:hover{
    border-color: teal;
    padding-bottom: 3px;}
ul {
list-style:none;
margin-left:0;
padding-left:0;}
li {
margin-bottom:15px;}
b{
    margin-left:15px; 
    color: teal;}
.vignette{
    margin-left:17px;}
	</style>
    <body>
    <di><a href = "index.php" class="back"> <i class="fas fa-backward"></i> Retour à l'image actuelle </a></div>
        <!-- p>Veuillez vous connecter au serveur FTP afin d'avoir accès aux images recherchées</p -->
    <?php
    #on récupère les données du formulaire de recherche
     $datef = $_GET['date1']; 
     $heuref=$_GET['heure'];
     #on modifie les tirets
     $date=str_replace("-","_",$datef);
     $heure=str_replace(":","_",$heuref);
     
     #on sépare les données
     $justelheure = substr($heure,0,2);
     $justelesminutes = substr($heure,3);
     $j = substr($date,8);
     $m = substr($date,5,2);
     $a = substr($date,0,4);
     
     #cas limite du jour si heure < 12h et pas le début du mois
     if(intval($justelheure) < 12 && $j != "01"){
         $jour = substr($date,8);
         if(intval($jour) <= 10){
            $jourprécédent = "0".strval(intval($jour)-1);
         }
         else{
            $jourprécédent = strval(intval($jour)-1);
         }
            
         

         $datef = substr($datef,0,8).$jourprécédent;
         


         
         
     }
     
     #cas limite du début de mois si heure < 12h (et d'année si besoin)
     if($j == "01" && intval($justelheure) < 12){
        if($m == "05" || $m == "07" || $m == "10"){
            $jourprécédent = "30";
            $moisprécédent = "0".strval(intval($m)-1);
            $datef = str_replace($j,$jourprécédent,$datef);
            $datef = str_replace($m,$moisprécédent,$datef);
        }
        if($m == "12"){
            $jourprécédent = "30";
            $moisprécédent = strval(intval($m)-1);
            $datef = str_replace($j,$jourprécédent,$datef);
            $datef = str_replace($m,$moisprécédent,$datef);
        }
        if($m == "04" || $m == "06" || $m == "08" || $m == "09"){
            $jourprécédent = "31";
            $moisprécédent = "0".strval(intval($m)-1);
            $datef = str_replace($j,$jourprécédent,$datef);
            $datef = str_replace($m,$moisprécédent,$datef);
        }
        if($m == "02"){
            $jourprécédent = "31";
            $moisprécédent = "0".strval(intval($m)-1);
            $datef = substr($datef,0,5)."01-31";
        }
        if($m == "11"){
            $jourprécédent = "31";
            $moisprécédent = strval(intval($m)-1);
            $datef = str_replace($j,$jourprécédent,$datef);
            $datef = str_replace($m,$moisprécédent,$datef);

        }
        if($m == "01"){
            
            $annéeprécédente = strval(intval($a)-1);
            
            $datef = $annéeprécédente."-12-31";
            
            
        }
        if($m == "03"){
            #année bissextile
            if((intval($a) % 400 == 0 )|| ((intval($a) % 4 == 0 ) && (intval($a) % 100 != 0 )) ){
                $jourprécédent = "29";
                $moisprécédent = "0".strval(intval($m)-1);
                $datef = str_replace($j,$jourprécédent,$datef);
                $datef = str_replace($m,$moisprécédent,$datef);
            }
            else{
                $jourprécédent = "28";
                $moisprécédent = "0".strval(intval($m)-1);
                $datef = str_replace($j,$jourprécédent,$datef);
                $datef = str_replace($m,$moisprécédent,$datef);
            }
        }


     }
     #on complète la liste des heures avec + ou - 2 minutes
     $listeheure = array();
     if(intval($justelesminutes) == 0  ){
        foreach (range(58,59) as $i){
            array_push($listeheure, strval(intval($justelheure)-1)."_".strval($i));
         } 
        foreach (range(0,2) as $i){
            array_push($listeheure, $justelheure."_".strval(intval($justelesminutes)+$i));
         }
         
     }
     if(intval($justelesminutes) == 1  ){
        foreach (range(59) as $i){
            array_push($listeheure, strval(intval($justelheure)-1)."_".strval($i));
         }
        foreach (range(0,3) as $i){
           array_push($listeheure, $justelheure."_"."0".strval($i));
        }
        
    }
    if(intval($justelesminutes) == 59  ){
        foreach (range(57,59) as $i){
            array_push($listeheure, $justelheure."_".strval($i));
         }
        foreach (range(0,1) as $i){
           array_push($listeheure, strval(intval($justelheure)+1)."_"."0".strval($i));
        }
        
    }
    if(intval($justelesminutes) == 58  ){
        foreach (range(56,59) as $i){
           array_push($listeheure, $justelheure."_".strval($i));
        }
        foreach (range(0) as $i){
            array_push($listeheure, strval(intval($justelheure)+1)."_"."0".strval($i));
         }
    }
    if(intval($justelesminutes)>= 12 && intval($justelesminutes) <= 57 ){
        
            foreach (range(-2,2) as $i){
               array_push($listeheure, $justelheure."_".strval(intval($justelesminutes)+$i));
            }
    }
    if(intval($justelesminutes)>= 2 && intval($justelesminutes) <= 7 ){
        
        foreach (range(-2,2) as $i){
           array_push($listeheure, $justelheure."_"."0".strval(intval($justelesminutes)+$i));
        }
    }
    if(intval($justelesminutes) == 8 ){
        
        foreach (range(-2,1) as $i){
           array_push($listeheure, $justelheure."_"."0".strval(intval($justelesminutes)+$i));
        }
        array_push($listeheure, $justelheure."_10");
    }
    if(intval($justelesminutes) == 9 ){
        
        foreach (range(-2,0) as $i){
           array_push($listeheure, $justelheure."_"."0".strval(intval($justelesminutes)+$i));
        }
        foreach (range(1,2) as $i){
            array_push($listeheure, $justelheure."_".strval(intval($justelesminutes)+$i));
        }
    
    }
    if(intval($justelesminutes) == 10 ){
        
        foreach (range(-2,-1) as $i){
           array_push($listeheure, $justelheure."_"."0".strval(intval($justelesminutes)+$i));
        }
        foreach (range(0,2) as $i){
            array_push($listeheure, $justelheure."_".strval(intval($justelesminutes)+$i));
        }
    
    }
    if(intval($justelesminutes) == 11 ){
        
        
        array_push($listeheure, $justelheure."_"."09");
        
        foreach (range(-1,2) as $i){
            array_push($listeheure, $justelheure."_".strval(intval($justelesminutes)+$i));
        }
    
    }

  

     
  
    ?>
        <!--formulaire host,user,pass de votre compte ftp-->

<?php
#connexion automatique via un formulaire json
$str = file_get_contents('data.json');
$json = json_decode($str, true);
$ftp_server = $json['credential']['host'];
$ftp_user = $json['credential']['user'];
$ftp_pass = $json['credential']['pwd'];


 
    // Mise en place d'une connexion basique
    $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 
 
    // Tentative d'identification
    if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
        
		ftp_pasv($conn_id, true) ;

		// On récupère la liste des répertoires
        $directories = ftp_nlist($conn_id, "/web/skywatch/"); 
        $i=0;
		
		// Pour chaque répertoire
        foreach($directories as $directory){
			// Si le répertoire contient est de la forme yyyy-mm-dd (4digits-2digits-2digits)
			if (preg_match("/((\d{4})\-(\d{2})\-(\d{2}))/", $directory)) {
				// Alors on l'ajoute dans la liste
				$listDirectories[$i] = $directory;
				$i ++;
			}
		}
		// On trie la liste
		rsort($listDirectories);
        $pastrouvédossier = true;
		// Le répertoire le plus récent est le premier de la liste
        foreach($listDirectories as $directory){
            
            if($directory == "/web/skywatch/".$datef){
                $dossier = $directory;
                $pastrouvédossier = false;
                break;
            }
        }

        if($pastrouvédossier){
            echo "<ul><b>Aucun dossier à la date ".$datef." n'a été trouvé</b></ul>";
        }
		
		if(!$pastrouvédossier){

        
		// On récupère la liste des fichiers du répertoire
        $files = ftp_nlist($conn_id, $dossier); 
        $i=0;
		
		// Pour chaque fichier
        foreach($files as $file){	
		// Si le fichier ne contient pas le mot "unfold" et son format est ".jpg"
			if (!preg_match("/unfold/", $file) && preg_match("/\.(jpg)$/", $file)) {
				// Alors on l'ajoute dans la liste
				$listFiles[$i] = $file;
				$i ++;
			}
		}
		// On trie la liste
		rsort($listFiles);
		$pastrouvéimage = true;
        #on fait afficher les images correspondantes à la recherche avec des liens d'affichage
        $listImages = array();
        $d = str_replace("_","-",$date);
		echo '<ul><b>Images du '.$d.'</b>';
        foreach($listFiles as $file){
            foreach(range(0,4) as $i){
                if(substr($file,0,-7) == "/web/skywatch/".$datef."/".$date."__".$listeheure[$i]){
					$file = $ftp_server.str_replace("/web","",$file);
                    echo '<li>';
					echo '<a target="_blank" href="http://'.$file.'" class = "link">';
					echo $date."__".$listeheure[$i]."<br>"."<br>".'<img src="http://'.$file.'" alt="'.$date."__".$listeheure[$i].'" class = "vignette">';
					echo '</a></li>';
					$pastrouvéimage = false;
                    array_push($listImages,$file);
                }
            }
        }
        if($pastrouvéimage){
            echo "<b>Aucune image correspondant à l'heure ".$heuref." et à la date ".$datef." n'a été trouvée dans le dossier ".$datef."</b>";
        }
		echo '</ul>';
        }
		
    } else {
		echo "Connexion impossible en tant que $ftp_user";
    }
	
	
    // Fermeture de la connexion
    ftp_close($conn_id);


?>
    <div>
    <p>Moteur de recherche d'images</p>
   
    <form action="form.php" method ="GET" >
        <label for="start">Date :</label>
        <input type="date" id="date" name="date1"
       min="2021-03-01" max="2032-12-31">
       <label for="start">Heure :</label>
       <input type="time" id="time" name="heure">

    
    <input type="submit">
    <input type="reset">
    </div>
    </form>
    </body>
</html>
