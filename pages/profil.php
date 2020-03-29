<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/user.php';
include '../objects/database.php';

if (empty($_SESSION['surname'])) {
    header('Location: login.php');
}

if (isset($_POST['MyProducts'])) {
    header('Location: myentreprise.php');
}

if (isset($_POST['BeASeller'])) {
    $user = new User($_SESSION['id'], '', '', '', '', '', 1);
    $db = new Database();
    if ($db->updateUser($user)) {
        $_SESSION['seller'] = 1;
    }
}

if (isset($_POST['Disconnect'])) {
    session_unset();
    header('Location: login.php');
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Mon compte</title>
</head>

<body>
    <div class="container-fluid">
        <h1>Bienvenue <?php echo $_SESSION['surname'] ?></h1>

        

        <form action="profil.php" method="post">
            <?php if ($_SESSION['seller']) { ?>
                <input type="submit" value="Mes productions" name="MyProducts">
            <?php } else { ?>
                <input type="submit" value="Devenir un vendeur" name="BeASeller">
            <?php } ?>
            <input type="submit" value="Déconnexion" name="Disconnect">
        </form>
    </div>
</body>

</html>