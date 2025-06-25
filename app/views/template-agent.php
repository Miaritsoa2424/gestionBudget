<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/templatedev.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/list-client.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/form-add-client.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/detail-client.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/detail-report.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/affiliation-agent.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/message.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/list-messages.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/css/info-ticket.css">

</head>

<body>
    <div class="container">
        <div class="sidebar">

            <h3><i style="color: #0A6CF6;" class="fas fa-ticket-alt"></i> Ticketing - Agent</h3>

            <div class="nav-item">
                <a class="active nav-link">
                    <i class="fas fa-plus-circle"></i> Ticket
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="sub-menu">
                    <a href="<?= Flight::get('flight.base_url') ?>/list-ticket-agent"><i class="fas fa-list"></i>Liste Ticket </a>
                </div>
            </div>

            
            <div class="nav-item">
                <a href="<?= Flight::get('flight.base_url') ?>/listMessages">
                    <i class="fa fa-message"></i> Discussions
                </a>
            </div>


            <a href="<?= Flight::get('flight.base_url') ?>/logout-agent">
                <i class="fa fa-sign-out-alt"></i> Deconnexion
            </a>
        </div>

        <div class="content">
            <?php

            if (isset($page)) {
                include($page . ".php");
            }
            ?>
        </div>
    </div>

    <script>
        // Gestion des menus principaux
        document.querySelectorAll('.nav-link').forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault();
                const parent = item.parentElement;
                parent.classList.toggle('active');
            });
        });

        // Gestion des sous-menus
        document.querySelectorAll('.sub-menu a').forEach(item => {
            item.addEventListener('click', event => {
                // Ne pas empêcher la navigation si le lien a un href
                if (!item.getAttribute('href')) {
                    event.preventDefault();
                }
                // Retire la classe active de tous les autres sous-menus
                document.querySelectorAll('.sub-menu a').forEach(subItem => {
                    subItem.classList.remove('active');
                });
                // Ajoute la classe active au sous-menu cliqué
                item.classList.add('active');
            });
        });
    </script>
</body>

</html>