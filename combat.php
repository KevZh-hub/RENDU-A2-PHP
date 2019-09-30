<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0

## CONNECTEZ VOUS A VOTRE BASE DE DONNEE


$pdo = new PDO('mysql:host=127.0.0.1;dbname=td_php', "root", "");

## ETAPE 1
$query = $pdo->prepare("SELECT * FROM personnages WHERE pv>10");
$query->execute();
$allPerso = $query->fetchAll(PDO::FETCH_OBJ);
## POUVOIR SELECTIONER UN PERSONNE DANS LE PREMIER SELECTEUR

## ETAPE 2

## POUVOIR SELECTIONER UN PERSONNE DANS LE DEUXIEME SELECTEUR

## ETAPE 3

## LORSQUE LON APPPUIE SUR LE BOUTON FIGHT, RETIRER LES PV DE CHAQUE PERSONNAGE PAR RAPPORT A LATK DU PERSONNAGE QUIL COMBAT

## ETAPE 4

## UNE FOIS LE COMBAT LANCER (QUAND ON APPPUIE SUR LE BTN FIGHT) AFFICHER en dessous du formulaire
# pour le premier perso PERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)
# pour le second persoPERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)

## ETAPE 5

## N'AFFICHER DANS LES SELECTEUR QUE LES PERSONNAGES QUI ONT PLUS DE 10 PV
function updatePerso($idPerso, $pvPerson, $pdo)
{
    $query = $pdo->prepare("UPDATE personnages SET pv = :newPv WHERE id = :id");
    $query->execute(["id" => $idPerso, 'newPv' => $pvPerson]);
    $a = $query->fetch(PDO::FETCH_OBJ);
    $perso = getPerso($idPerso, $pdo);

    return $perso;
}

function getPerso($id, $pdo)
{
    $query = $pdo->prepare("SELECT * FROM personnages WHERE id = :id");
    $query->execute(["id" => $id]);
    $a = $query->fetch(PDO::FETCH_OBJ);

    return $a;
}

?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rendu Php</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="nav mb-3">
    <a href="./rendu.php" class="nav-link">Accueil</a>
    <a href="./personnage.php" class="nav-link">Mes Personnages</a>
    <a href="./combat.php" class="nav-link">Combats</a>
</nav>
<h1>Combats</h1>
<div class="w-100 mt-5">

    <form action="" method="POST">
        <select name="perso1" id="">
            <option value="" selected disabled>Choissisez le perso 1</option>
            <?php foreach ($allPerso as $key=>$perso) { ?>
                <option value="<?= $perso->id ?>"><?= $perso->name ?> </option>
            <?php } ?>
        </select>

        <select name="perso2" id="">
            <option value="" selected disabled>Choissisez le perso 2</option>
            <?php foreach ($allPerso as $key=>$perso) { ?>
                <option value="<?= $perso->id ?>"><?= $perso->name ?> </option>
            <?php } ?>
        </select>

        <button type="submit">Fight</button><br>
        <?php
        if (!empty($_POST)) {
            $perso1 = $_POST['perso1'];
            $perso2 = $_POST['perso2'];
            $dbPerso1 = getPerso($perso1, $pdo);
            $dbPerso2 = getPerso($perso2, $pdo);
            $pvPerso1 = $dbPerso1->pv - $dbPerso2->atk;
            $pvPerso2 = $dbPerso2->pv - $dbPerso1->atk;

            $newPerso1 = updatePerso($perso1, $pvPerso1, $pdo);
            $newPerso2 = updatePerso($perso2, $pvPerso2, $pdo);

            echo $newPerso2->name . " à perdu " . $dbPerso1->atk . " pv il a donc actuellement " . $newPerso2->pv . "PV <br>";

            echo $newPerso1->name . " à perdu " . $dbPerso2->atk . " pv il a donc actuellement " . $newPerso1->pv . "PV <br>";

        }
        ?>
    </form>

</div>

</body>
</html>


