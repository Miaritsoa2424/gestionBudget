<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/template.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/validation.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/budget.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/formPrevReal.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/formCsv.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/crmForm.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/departement.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/formModifDepartement.css">

    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/chart.css">

    <style>

    </style>
</head>

<body>
    <div class="navbar">
        <!-- <a href="#"><i class="fas fa-home"></i>Accueil</a> -->
        <?php
            if ($_SESSION['idDept'] == 1) { ?>
                <a href="validation"><i class="fas fa-check-circle"></i>Validation</a>
            <?php }
        ?>
        <a href="budget"><i class="fas fa-wallet"></i>Budget</a>
        <a href="departement"><i class="fas fa-building"></i>Département</a>
        <a href="crm"><i class="fas fa-handshake"></i>CRM</a>
        <a href="chart"><i class="fas fa-building"></i>Chart</a>
        <a href="deco"><i class="fas fa-sign-out-alt"></i>Deconnexion</a>
    </div>

    <main>
        <?php
        if (isset($page)) {
            include($page . ".php");
        }  ?>
    </main>
</body>

</html>