<?php
include_once 'components/header.php';
include_once 'components/nav.php';
include_once '../objects/database.php';
include_once '../objects/entreprise.php';
$db = new Database();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$cities = $db->GetAllCities();
$entreprise = $db->GetMyEntreprise($_SESSION['idEntreprise']);
$value = array('name' => $entreprise->getName(), 'product' => $entreprise->getProduct(), 'phone' => $entreprise->getPhone(), 'address' => $entreprise->getAddress(), 'district' => $entreprise->getCity());
$errors = array('name' => '', 'product' => '', 'phone' => '', 'address' => '', 'district' => '');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['save'])) {
    if (empty($_POST['name'])) {
        $errors['name'] = 'Nom manquant';
    } else if (empty($_POST['product'])) {
        $value['name'] = $_POST['name'];
        $errors['product'] = 'Pas de produit';
    } else if (empty($_POST['phone'])) {
        $value['name'] = $_POST['name'];
        $value['product'] = $_POST['product'];
        $errors['phone'] = 'Téléphone manquant';
    } else if (empty($_POST['address'])) {
        $value['name'] = $_POST['name'];
        $value['product'] = $_POST['product'];
        $value['phone'] = $_POST['phone'];
        $errors['address'] = 'Adresse manquante';
    } else if ($_POST['district'] == '---') {
        $value['name'] = $_POST['name'];
        $value['product'] = $_POST['product'];
        $value['phone'] = $_POST['phone'];
        $value['address'] = $_POST['address'];
        $errors['district'] = 'Choisissez un arondissement';
    } else {
        $entreprise = new Entreprise($_SESSION['id'], $_POST['name'], $_POST['address'], $_POST['district'], $_POST['product'], $_POST['phone']);
        $entreprise->setId($_SESSION['idEntreprise']);
        echo $entreprise->getId().' COUCOU';
        $_SESSION['idEntreprise']='';
        if ($db->UpdateEntreprises($entreprise)) {
            header('Location: myentreprise.php');
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Mes entreprises</title>
</head>

<body>
    <div class="container">
        <div id="loginCard" class="card" style="width: 30rem;">
            <div class="card-body">
                <h3 class="card-title text-center">Modifier votre entreprise</h3>
                <form action="updateEntreprise.php" method="post">
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $value['name'] ?>">
                        <div class="inputError"><?php echo $errors['name'] ?></div>
                    </div>
                    <div class="form-group">
                        <label for="product">Produit</label>
                        <input type="text" class="form-control" name="product" value="<?php echo $value['product'] ?>">
                        <div class="inputError"><?php echo $errors['product'] ?></div>

                    </div>
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" class="form-control" name="phone" value="<?php echo $value['phone'] ?>">
                        <div class="inputError"><?php echo $errors['phone'] ?></div>

                    </div>
                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" class="form-control" name="address" value="<?php echo $value['address'] ?>">
                        <div class="inputError"><?php echo $errors['address'] ?></div>

                    </div>
                    <div class="form-group">
                        <label for="district">Arrondissement</label>
                        <select name="district" class="custom-select">
                            <option value="---">---</option>
                            <?php foreach ($cities as $city) { 
                                if ($city->getId() == $entreprise->getCity()) {
                                    echo '<option selected value="'.$city->getId().'">'.$city->getCity().'</option>';
                                } else {
                                    echo '<option value="' . $city->getId() . '">' . $city->getCity() . '</option>';
                                }
                                ?>
                            <?php } ?>
                        </select>
                        <div class="inputError"><?php echo $errors['district'] ?></div>

                    </div>
                    <div class="text-center">
                        <input type="submit" name="save" class="btn btn-secondary" value="Enregistrer">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>