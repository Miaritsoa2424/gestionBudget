<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Espace Client' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/templateClient.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/report-client.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/list-messages.css">

</head>
<body>
    <nav class="top-nav">
        <div class="nav-brand" >
            <i class="fas fa-ticket-alt"></i>
            <span>Support Client</span>
        </div>
        <ul class="nav-links" >
            <li><a href="<?= Flight::get('flight.base_url') ?>/homeClient"><i class="fas fa-home"></i> Accueil</a></li>
            <li class="active"><a href="report-client"><i class="fas fa-file-alt "></i> Rapport</a></li>
            <li><a href="<?= Flight::get('flight.base_url') ?>/listMessagesClient"><i class="fas fa-comments"></i> Discussion
            <span class="notification-badge">0</span>
            </a></li>
            
            <li><a href="<?= Flight::get('flight.base_url') ?>/logout-client"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <?php
            if (isset($page)) {
                include($page . ".php");
            }
        ?>
    </main>

</body>
</html>
