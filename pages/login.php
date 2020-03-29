<?php
include_once 'components/header.php';
include_once 'components/nav.php';
include_once '../objects/database.php';

$db = new Database();
$errors = array('mail' => '', 'pass' => '', 'login' => '');

if (isset($_POST['submit'])) {
    $user = $db->login($_POST['mail'], $_POST['pass']);
    if (empty($user)) {
        $errors['login'] = "Utilisateur introuvable";
    } else {
        session_start();
        $_SESSION['id'] = $user->getId();
        $_SESSION['name'] = $user->getName();
        $_SESSION['surname'] = $user->getSurname();
        $_SESSION['mail'] = $user->getMail();
        $_SESSION['admin'] = $user->getAdmin();
        $_SESSION['seller'] = $user->getSeller();
        header('Location: profil.php');
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Se connecter</title>
</head>

<body>
    <div class="container">
        <div id="loginCard" class="card" style="width: 30rem;">
            <div class="card-body">
                <h3 class="card-title text-center">Se connecter</h3>
                <form action="login.php" method="post">
                    <div class="inputError text-center"><?php echo $errors['login'] ?></div>
                    <div class="form-group">
                        <label for="mail">Mail</label>
                        <input type="email" class="form-control" name="mail">
                    </div>
                    <div class="form-group">
                        <label for="pass">Mot de passe</label>
                        <input type="password" class="form-control" name="pass">
                    </div>
                    <div class="text-center">
                        <input type="submit" name="submit" class="btn btn-secondary" value="Connexion">
                    </div>
                </form>
                <p class="card-title text-center">Nouveau ? Cliquez <a href="add.php" style="text-decoration: none; color:black; font-weight: bold;">ici</a></p>
            </div>
        </div>
    </div>
</body>

</html>