<?php
include 'components/header.php';
include 'components/nav.php';
include_once '../objects/database.php';
$db = new Database();

////////////////////////////////////////////////////////////////////////////

$cities = $db->GetAllCities();
$productions = $db->GetAllEntreprises();

////////////////////////////////////////////////////////////////////////////
$selectLocations = 0;
$selectProducts = 0;
$entreprises = array();

if (isset($_POST['Products']) && isset($_POST['Locations'])) {
    if ($_POST['Products'] == 'ALL' && $_POST['Locations'] == 'ALL') {
        $entreprises = $db->GetAllEntreprises();
    } else if ($_POST['Products'] != 'ALL' && $_POST['Locations'] == 'ALL') {
        $entreprises=$db->GetAllEntreprisesWithProduct($_POST['Products']);
    } else if ($_POST['Products'] == 'ALL' && $_POST['Locations'] != 'ALL') {
        $entreprises = $db->GetAllEntreprisesWithCity($_POST['Locations']);
    } else if ($_POST['Products'] != 'ALL' && $_POST['Locations'] != 'ALL') {
        $entreprises = $db->GetAllEntreprisesWithProductAndCity($_POST['Products'], $_POST['Locations']);
    }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Search</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <form action="search.php" method="post">
                    <select name="Locations" class="custom-select">
                        <option value="ALL">Toutes les régions</option>
                        <?php foreach ($cities as $city) { ?>
                            <option value="<?php echo $city->getId()?>"><?php echo ($city->getCity()) ?></option>
                        <?php } ?>
                    </select>

                    <select name="Products" class="custom-select">
                        <option value="ALL">Toutes les productions</option>
                        <?php foreach ($productions as $production) { ?>
                            <option value="<?php echo ($production->getProduct()) ?>"><?php echo ($production->getProduct()) ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" class="btn btn-secondary btn-lg btn-block" value="Rechercher">
                </form>
            </div>

            <div class="col-sm-10">
                <table class="table">
                    <thead>
                        <th scope="col">Nom</th>
                        <th scope="col">Adresse</th>
                        <th scope="col">Produit</th>
                        <th scope="col">Contact</th>
                    </thead>
                    <tbody>
                        <?php foreach ($entreprises as $entreprise) { ?>
                            <tr>
                                <td><?php echo ($entreprise->getName()) ?></td>
                                <td><?php echo ($entreprise->getAddress()).' - '.$db->GetOneCity($entreprise->getCity())->getCity()?></td>
                                <td><?php echo ($entreprise->getProduct()) ?></td>
                                <td><?php echo ($entreprise->getPhone())?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>