<?php

    $pointsAttribues = array(200, 180, 160, 140, 120, 100, 80, 60, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50);
    $facteurAge = 21;
    $facteurPlatine = 5;
	$pointsQuete = 100;
	$pointsBonus = 100;
    
    // Recuperation des defis
    $listeDefi = array();
	$fichierDefi = fopen("defi.txt", "r") or die("Unable to open file!");
	while(!feof($fichierDefi)) {
        $ligne = trim(fgets($fichierDefi));
        $ligneExplosee = explode("#", $ligne);
		if (count($ligneExplosee) > 2) {
            $defi["id"] = $ligneExplosee[0];
            $defi["anim"] = $ligneExplosee[1];
            $defi["titre"] = $ligneExplosee[2];
            $defi["reussi"] = $ligneExplosee[3];
            $listeDefi[$defi["id"]] = $defi;
		}
    }
	fclose($fichierDefi);
    
    // Recuperation des joueurs
    $listeJoueur = array();
	$fichierJoueur = fopen("joueur.txt", "r") or die("Unable to open file!");
	while(!feof($fichierJoueur)) {
        $ligne = trim(fgets($fichierJoueur));
        $ligneExplosee = explode("#", $ligne);
		if (count($ligneExplosee) > 4) {
            $joueur["joueur"] = array_shift($ligneExplosee);
            $joueur["age"] = array_shift($ligneExplosee);
            $joueur["pseudo"] = array_shift($ligneExplosee);
            $joueur["score"] = array_shift($ligneExplosee);
            $joueur["defis"] = $ligneExplosee;
            $listeJoueur[$joueur["joueur"]] = $joueur;
		}
    }
	fclose($fichierJoueur);

	// On recupere le defi des le debut
	$defi = $listeDefi[$_POST["defi"]];
	$nbFoisReussi = intval($defi["reussi"]);

	$reponse = "";
	$reponseKo = "";

    $joueurs = explode("#", $_POST["joueur"]);
	foreach($joueurs as $nom_du_joueur) {
		// Pour chaque joueur, on regarde si le defi n'a pas encore et reussi et on agit en consequence
		$joueur = $listeJoueur[$nom_du_joueur];
		$defisDuJoueur = $joueur["defis"];
		$defiDejaReussi = $defisDuJoueur[intval($_POST["defi"])];
		if (strcmp($defiDejaReussi, "0") == 0 || str_starts_with(strtolower($defi["titre"]), "bonus") || str_starts_with(strtolower($defi["titre"]), "quete")) {
			// --> On marque le defi comme reussi chez le joueur
			$defisDuJoueur[intval($_POST["defi"])] = "1";
			$joueur["defis"] = $defisDuJoueur;
			$listeJoueur[$nom_du_joueur] = $joueur;

			// --> On donne les points
			$facteur = $facteurAge - intval($joueur["age"]);
			$pointsBase = $pointsAttribues[$nbFoisReussi];
			if (str_starts_with(strtolower($defi["titre"]), "platine")) {
				$facteur = $facteur * $facteurPlatine;
			}
			if (str_starts_with(strtolower($defi["titre"]), "quete")) {
				$pointsBase = $pointsQuete;
			}
			if (str_starts_with(strtolower($defi["titre"]), "bonus")) {
				$pointsBase = $pointsBonus;
			}
			$points = $facteur * $pointsBase;
			$joueur["score"] = intval($joueur["score"]) + $points;
			$listeJoueur[$nom_du_joueur] = $joueur;

			// --> On incremente le nombre de fois ou le defi a ete reussi
			$defi["reussi"] = (intval($defi["reussi"]) + 1) . "";
			$listeDefi[$_POST["defi"]] = $defi;

			$reponse .= "BRAVO : Le joueur " . $joueur["joueur"] . " a gagne " . $points . " points et a maintenant un score de " . $joueur["score"] . " points.<br>";

		} else {
			$reponseKo .= "Action annulee : Le joueur " . $joueur["joueur"] . " a deja accompli ce defi !!!!!<br>";
		}
	}
	
	if (strlen($reponseKo) == 0) {
		// --> On sauvegarde
		// Backup des fichiers
		$date = date("Y-m-d_H-i-s");
		$fichierBackup = $date . "_joueur.txt";
		if (file_exists($fichierBackup)) { die("Action annulee : un autre animateur attribue des points."); }
		copy("joueur.txt", $fichierBackup);
		$fichierBackup = $date . "_defi.txt";
		if (file_exists($fichierBackup)) { die("Action annulee : un autre animateur attribue des points."); }
		copy("defi.txt", $fichierBackup);

		// --> On recree le fichier des defis
		$fichierDefi = fopen("defi.txt", "w") or die("Unable to open file!");
		foreach($listeDefi as $key => $defi) {
			fwrite($fichierDefi, $defi["id"] . "#" . $defi["anim"] . "#" . $defi["titre"] . "#" . $defi["reussi"] . "\n");
		}
		fclose($fichierDefi);

		// --> On recree le fichier des joueurs
		$fichierJoueur = fopen("joueur.txt", "w") or die("Unable to open file!");
		foreach($listeJoueur as $key => $joueur) {
			fwrite($fichierJoueur, $joueur["joueur"] . "#" . $joueur["age"] . "#" . $joueur["pseudo"] . "#" . $joueur["score"] . "#" . implode("#", $joueur["defis"]) . "\n");
		}
		fclose($fichierJoueur);
		
		echo $reponse;
	} else {
		echo($reponseKo);
	}

?>
