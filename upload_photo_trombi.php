<html>
<head>
<meta http-equiv="refresh" content="0; url=trombi.html" />
</head>
<body>
<?php
if (strlen($_POST['nom_du_joueur']) > 4) {
    $target_file = "photos/" . $_POST['nom_du_joueur'] . ".jpg";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}
?>
</body>
</html>
