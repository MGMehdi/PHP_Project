<?php
include 'components/header.php';
include 'components/nav.php';
include '../objects/user.php';
include '../objects/database.php';

$db = new Database();

if (empty($_SESSION['surname'])) {
    header('Location: login.php');
}

if (isset($_POST['MyProducts'])) {
    header('Location: myentreprise.php');
}

if (isset($_POST['BeASeller'])) {
    $user = new User($_SESSION['id'], '', '', '', '', '', 1);
    if ($db->beASeller($user)) {
        $_SESSION['seller'] = 1;
    }
}
if (isset($_POST['Disconnect'])) {
    session_unset();
    header('Location: login.php');
}
if (isset($_POST['Oui'])) {
    $db->DeleteUser($_SESSION['id']);
    session_unset();
    header('Location: login.php');
}
if (isset($_POST['Update'])) {
    header('Location: updateUser.php');
}
if (isset($_POST['Password'])) {
    header('Location: updatePassword.php');
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
            <input type="submit" value="Changer mes données" name="Update">
            <input type="submit" value="Changer de mots de passe" name="Password">
            <input type="submit" value="Déconnexion" name="Disconnect">
            <input type="button" value="Supprimer mon compte" onclick="Open()">
        </form>

        <div id="askDeleteBackground" class="text-center" onclick="Close()">
            <div id="loginCard" class="card" style="width: 40rem;">
                <div class="card-body">
                    <h3 class="card-title">Vous nous quittez ?</h3>
                    <h5>Etes vous sûr de vouloir supprimer votre compte ?</h5>
                    <form action="profil.php" method="post">
                        <input type="submit" name="Oui" class="btn btn-danger" value="Oui">
                        <input type="button" name="Non" class="btn btn-success" value="Non" onclick="Close()">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function Open() {
            document.getElementById('askDeleteBackground').style.display = 'block';
        }

        function Close() {
            document.getElementById('askDeleteBackground').style.display = 'none';
        }
    </script>


</body>

</html>