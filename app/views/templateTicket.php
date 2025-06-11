<!-- templateTicket.php (nouvelle version) -->
<div class="ticket-container">
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

    <div class="content">
        <?php
            if (isset($pageContent)) {
                include($pageContent . ".php");
            } else {
                echo "<h2>Bienvenue dans la gestion des tickets</h2>";
                echo "<p>Sélectionnez une option dans le menu de gauche.</p>";
            }
        ?>
    </div>
</div>
