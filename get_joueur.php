<?php

    $listeScore = array();
    $listePseudo = array();
	$fichierJoueur = fopen("joueur.txt", "r") or die("Unable to open file!");
	while(!feof($fichierJoueur)) {
        $ligne = trim(fgets($fichierJoueur));
        $ligneExplosee = explode("#", $ligne);
		if (count($ligneExplosee) > 3) {
			$listeScore[$ligneExplosee[0]] = $ligneExplosee[3];
            $listePseudo[$ligneExplosee[0]] = $ligneExplosee[2];
		}
    }
	fclose($fichierJoueur);
    
    $listeJoueurTriee = array();
    $listePseudoTriee = array();
    $listeScoreTriee = array();
    if (strcmp($_POST["ordre"], "score") == 0) {
        $i = 0;
        $arrayScore = array_unique(array_values($listeScore));
        rsort($arrayScore);
        foreach ($arrayScore as $score) {
            foreach ($listeScore as $joueur => $scoreDuJoueur) {
                if (strcmp($score, $scoreDuJoueur) == 0) {
                    $listeJoueurTriee[$i] = $joueur;
                    $listePseudoTriee[$i] = $listePseudo[$joueur];
                    $listeScoreTriee[$i] = $score;
                    $i++;                
                }
            }
        }
    } else {
        $i = 0;
        $arrayJoueur = array_unique(array_keys($listeScore));
        sort($arrayJoueur);
        foreach ($arrayJoueur as $joueur) {
            $listeJoueurTriee[$i] = $joueur;
            $listePseudoTriee[$i] = $listePseudo[$joueur];
            $listeScoreTriee[$i] = $listeScore[$joueur];
            $i++;                
        }
    }

    $reponse = array();
    $reponse["joueur"] = $listeJoueurTriee;
    $reponse["pseudo"] = $listePseudoTriee;
    $reponse["score"] = $listeScoreTriee;
    echo json_encode($reponse);

?>
