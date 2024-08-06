<?php

    // On recupere le nextId des defis
	$fichierDefi = fopen("defi.txt", "r") or die("Unable to open file!");
	while(!feof($fichierDefi)) {
        $ligne = trim(fgets($fichierDefi));
        $ligneExplosee = explode("#", $ligne);
		if (count($ligneExplosee) > 3) {
			$id = $ligneExplosee[0];
		}
    }
	fclose($fichierDefi);
    $nextId = intval(($id) + 1);
  
    // Recuperation des joueurs
    $listeJoueur = array();
	$fichierJoueur = fopen("joueur.txt", "r") or die("Unable to open file!");
    $i = 0;
	while(!feof($fichierJoueur)) {
        $ligne = trim(fgets($fichierJoueur));
        if(strlen($ligne) > 1) {
            $listeJoueur[$i++] = $ligne . "#0";
        }
    }
	fclose($fichierJoueur);
    
    // Backup des fichiers
    $date = date("Y-m-d_H-i-s");
    $fichierBackup = $date . "_joueur.txt";
    if (file_exists($fichierBackup)) { die("Action annulee : un autre animateur attribue des points."); }
    copy("joueur.txt", $fichierBackup);
    $fichierBackup = $date . "_defi.txt";
    if (file_exists($fichierBackup)) { die("Action annulee : un autre animateur attribue des points."); }
    copy("defi.txt", $fichierBackup);
  
    // On ajoute le defi
	$fichierDefi = fopen("defi.txt", "a") or die("Unable to open file!");
	fwrite($fichierDefi, "\n" . $nextId . "#" . $_POST["anim"] . "#" . $_POST["titre"] . "#0");
	fclose($fichierDefi);

    // On ajoute une colonne aux joueurs
    $fichierJoueur = fopen("joueur.txt", "w") or die("Unable to open file!");
    foreach($listeJoueur as $joueur) {
        fwrite($fichierJoueur, $joueur . "\n");
    }
    fclose($fichierJoueur);

   
?>
