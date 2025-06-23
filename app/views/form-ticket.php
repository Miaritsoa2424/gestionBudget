
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
                    <a href="<?= $attachment['url']; ?>" target="_blank">
                        <?= $attachment['name']; ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button class="btn btn-primary" onclick="openTicketForm()">Ticketage</button>
    </div>

    <!-- Formulaire de ticket -->
    <div class="ticket-form" id="ticketForm">
        <span class="close-ticket" onclick="closeTicketForm()">×</span>
        <center><h3 style="margin-bottom: 30px;">Nouveau Ticket</h3></center>
        <form method="post" action="insertTicket">
            <div class="form-group">
                <label>Importance</label>
                <select class="form-control" name="priorite">
                    <option value="">-- Séléctionner une priorité --</option>
                </select>
            </div>
            <div class="form-group">
                <label>Categorie</label>
                <select class="form-control" name="priorite">
                    <option value="">-- Séléctionner une priorité --</option>
                </select>
            </div>

            <div class="form-group">
                <label>Sujet</label>
                <textarea name="sujet" class="form-control" rows="4"></textarea>
            </div>
            <div class="cout form-group">
                <label>Coût horaire estimé</label>
                <input type="number" class="form-control" name="cout_horaire" placeholder="Ex: 1000">
            </div>
            <button type="submit" class="btn btn-primary">Créer le ticket</button>

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

function success () {
    alert('Ticket créé avec succès !');
}

function error () {
    alert('Erreur lors de la création du ticket.');
}

<?php if (isset($error)): ?>
    error();
<?php endif; ?>
<?php if (isset($success)): ?>
    success();
<?php endif; ?>

</script>
