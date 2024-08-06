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
            echo "<h2>$ligneExplosee[0]</h2>";
            for($i = 4; $i < count($ligneExplosee); $i++) {
                if ($ligneExplosee[$i] == 1)
                    echo "<li>" . $listeDefis[$i - 4]["name"] . "</li>";
            }
        }
    ?>
</body>
</html>