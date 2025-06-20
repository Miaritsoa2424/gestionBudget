<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->


    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/template.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/templateDev.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/ticketForm.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/validation.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/budget.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/formPrevReal.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/formCsv.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/crmForm.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/departement.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/formModifDepartement.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/ticketAdmin.css">

    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/chart.css">

</head>

<body>

    <div class="container">
        <div class="sidebar">
            <h3><i class="fas fa-ticket-alt"></i> Tickets</h3>
            <a href="formTicket">
                <i class="fas fa-plus-circle"></i> Nouveau Ticket
            </a>
            <a href="listeTicket">
                <i class="fas fa-list"></i> Liste des Tickets
            </a>
            <a href="ticketDept">
                <i class="fas fa-list"></i> Liste des tickets du departements
            </a>
            <a href="ticketStats">
                <i class="fas fa-chart-pie"></i> Statistiques
            </a>
        </div>

        
    </div>

</body>

</html>