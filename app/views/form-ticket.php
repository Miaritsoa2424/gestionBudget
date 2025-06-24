<style>
.status-messages {
    margin-bottom: 20px;
}

.alert {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

</style>

<div class="report-detail">
    <div class="content-wrapper">
        <!-- Coordonnées de l'envoyeur -->
        <div class="section">
            <h3>Coordonnées de l'envoyeur</h3>
            <div class="photo-container">
                    <img src="https://placehold.co/200x250/CCCCCC/000000/png?text=Portrait+Test" alt="" class="client-photo">
                </div>
            <p><strong>Nom:</strong> <?= $demoReport['client']['nom']; ?></p>
            <p><strong>Prénom:</strong> <?= $demoReport['client']['prenom']; ?></p>
            <p><strong>Email:</strong> <?= $demoReport['client']['email']; ?></p>
        </div>

        <!-- Détails du report -->
        <div class="section">
            <h3>Détails du report</h3>
            <p><strong>Date d'envoi:</strong> <?= $demoReport['date']; ?></p>
            <p><strong>Statut:</strong> 
                <span class="badge badge-<?= getStatusClass($demoReport['statut']); ?>">
                    <?= $demoReport['statut']; ?>
                </span>
            </p>
            <div class="description">
                <h4>Description</h4>
                <p><?= nl2br($demoReport['message']); ?></p>
            </div>
        </div>

        <!-- Pièces jointes -->
        <div class="section">
            <h3>Pièces jointes</h3>
            <div class="attachments">
                <?php foreach($demoReport['attachments'] as $attachment): ?>
                <div class="attachment">
                    <i class="fas fa-file"></i>
                    <a href="<?= Flight::get('flight.base_url') ?>/uploads/<?= $attachment['url']; ?>" target="_blank">
                        <?= $attachment['name']; ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button class="btn btn-primary" onclick="openTicketForm()" style="font-size: 16px;">Ticketage</button>
    </div>

    <!-- Formulaire de ticket -->
    <div class="ticket-form" id="ticketForm">
        <span class="close-ticket" onclick="closeTicketForm()">×</span>
        <center><h3 style="margin-bottom: 30px;">Nouveau Ticket</h3></center>
        
        <div class="status-messages">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success">Le ticket a été créé avec succès!</div>
            <?php endif; ?>
        </div>

        <form method="post" action="<?= Flight::get('flight.base_url') ?>/insertTicket">
            <div class="form-group">
                <label>Importance</label>
                <select class="form-control" name="id_importance">
                    <option value="">-- Séléctionner une priorité --</option>
                    <?php foreach ($demoReport['importance'] as $importance): ?>
                        <option value="<?= $importance->getidImportance(); ?>"><?= $importance->getNom(); ?></option>
                    <?php endforeach; ?>
                </select>
                </select>
            </div>
            <div class="form-group">
                <label>Categorie</label>
                <select class="form-control" name="id_categorie">
                    <option value="">-- Séléctionner une priorité --</option>
                    <?php foreach ($demoReport['categories'] as $categorie): ?>
                        <option value="<?= $categorie->getId(); ?>"><?= $categorie->getNom(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Sujet</label>
                <textarea name="sujet" class="form-control" rows="4"></textarea>
            </div>
            <input type="hidden" name="id_report" value="<?= $demoReport['id_report']; ?>">
            
            <button type="submit" class="btn btn-primary" style="font-size: 16px;">Créer le ticket</button>

        </form>
    </div>
</div>

<?php
function getStatusClass($status) {
    switch($status) {
        case 'En Cours': return 'warning';
        case 'Validé': return 'success';
        case 'Refusé': return 'danger';
        default: return 'secondary';
    }
}
?>

<script>
function openTicketForm() {
    document.getElementById('ticketForm').classList.add('active');
    document.querySelector('.content-wrapper').classList.add('shifted');
}

function closeTicketForm() {
    document.getElementById('ticketForm').classList.remove('active');
    document.querySelector('.content-wrapper').classList.remove('shifted');
}

// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    <?php if (isset($error)): ?>
        error();
        openTicketForm();
    <?php endif; ?>
    <?php if (isset($success)): ?>
        success();
    <?php endif; ?>
});
</script>
