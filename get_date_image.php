<?php
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

echo $lastDirectory.'/'.$lastFile;
#echo "</br>";

#echo json_encode('data: png;base64,'.base64_encode(file_get_contents($lastDirectory.'/'.$lastFile)));


?>