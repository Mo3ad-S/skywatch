<?php
#connexion au serveur ftp gérée par un fichier json
#$str = file_get_contents('data.json');
#$json = json_decode($str, true);
#$ftp_server = $json['credential']['host'];
#$ftp_user = $json['credential']['user'];
#$ftp_pass = $json['credential']['pwd'];

#echo "plop";
$directories = scandir("./",SCANDIR_SORT_DESCENDING);


foreach($directories as $directory){
	// Si le répertoire contient est de la forme yyyy-mm-dd (4digits-2digits-2digits)
	if (preg_match("/((\d{4})\-(\d{2})\-(\d{2}))/", $directory)) {
		// Alors on l'ajoute dans la liste
		$lastDirectory = $directory;
		break;
	}
}

// On récupère la liste des fichiers du répertoire
$files = scandir($lastDirectory, SCANDIR_SORT_DESCENDING);
// Pour chaque fichier
foreach($files as $file) {
	// Si le fichier ne contient pas le mot "unfold" et son format est ".jpg"
	if (!preg_match("/unfold/", $file) && preg_match("/\.(jpg)$/", $file)) {
		// Alors on l'ajoute dans la liste
		$lastFile = $file;
		break;
	}
}

#echo $lastDirectory.'/'.$lastFile;
#echo "</br>";

echo json_encode('data: png;base64,'.base64_encode(file_get_contents($lastDirectory.'/'.$lastFile)));


/*
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
		// Le répertoire le plus récent est le premier de la liste
		$directory=$listDirectories[0];
		
		
		// On récupère la liste des fichiers du répertoire
        $files = ftp_nlist($conn_id, $directory); 
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
		// L'image la plus récente est la premire de la liste
		$file=$listFiles[0];
		
		// On affiche le nom de l'image
        $file2 = str_replace("/web","",$file);
        $file3 = "http://90.63.133.56".$file2;
		
		//On renvoie l'url de l'image sous format json
		echo json_encode($file3);
		
		
    } else {
		echo "Connexion impossible en tant que $ftp_user";
    }
	

	// Fermeture de la connexion
    ftp_close($conn_id);
	*/
	//echo json_encode("skywatch.png");
	#echo json_encode('data: png;base64,'.base64_encode(file_get_contents('skywatch.png')));

?>