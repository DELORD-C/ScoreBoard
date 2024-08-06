<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background: lightgrey;">
    <?php
        $fichierDefi = fopen("defi.txt", "r");
        $fichierJoueur = fopen("joueur.txt", "r");
        $listeDefis = [];
        $listeDefisAnims = [];
        $listeJoueurs = [];
        $i = 0;

        while(!feof($fichierDefi)) {
            $ligne = trim(fgets($fichierDefi));
            $ligneExplosee = explode("#", $ligne);
            if (count($ligneExplosee) > 2) {
                $listeDefisAnims[$ligneExplosee[1]][$ligneExplosee[0]] = $ligneExplosee[2];
                $listeDefis[$ligneExplosee[0]]["name"] = $ligneExplosee[2];
            }
        }
        
        while(!feof($fichierJoueur)) {
            $ligne = trim(fgets($fichierJoueur));
            $ligneExplosee = explode("#", $ligne);
            if (count($ligneExplosee) > 2) {
                $listeJoueurs[$ligneExplosee[0]] = [];
            }
            for($i = 4; $i < count($ligneExplosee); $i++) {
                if ($ligneExplosee[$i] == 1)
                    $listeDefis[$i - 4]["joueurs"][] = $ligneExplosee[0];
            }
        }

        foreach ($listeDefisAnims as $anim => $defis) {
            echo "<hr><h2>$anim</h2>";
            foreach ($defis as $id => $nom) {
                echo "<h3>$nom</h3>";
                echo "<ul>";
                if (isset($listeDefis[$id]["joueurs"])) {
                    foreach ($listeDefis[$id]["joueurs"] as $joueur) {
                        echo "<li>$joueur</li>";
                    }
                }
                else {
                    echo "<p style='color: red'>PERSONNE</p>";
                }
                echo "</ul>";
            }
        }
    ?>
</body>
</html>