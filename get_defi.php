<?php

    $filtre = $_POST['filtre'];
    $listeDefi = array();
	$fichierDefi = fopen("defi.txt", "r") or die("Unable to open file!");
    $i = 0;
	while(!feof($fichierDefi)) {
        $ligne = trim(fgets($fichierDefi));
        $ligneExplosee = explode("#", $ligne);
		if (count($ligneExplosee) > 2) {
            $defi["id"] = $ligneExplosee[0];
            $defi["anim"] = $ligneExplosee[1];
            $defi["titre"] = $ligneExplosee[2];
            $defi["reussi"] = $ligneExplosee[3];
            if (strlen($filtre) == 0 || strcmp($filtre, $defi["anim"]) == 0 ||  str_starts_with(strtolower($defi["titre"]), "bonus")) {
                $listeDefi[$i++] = $defi;
            }
		}
    }
	fclose($fichierDefi);

    echo json_encode($listeDefi);

?>
