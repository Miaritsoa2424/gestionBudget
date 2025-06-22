
<div class="report-detail">
    <div class="content-wrapper">
        <!-- Coordonnées de l'envoyeur -->
        <div class="section">
            <h3>Coordonnées de l'envoyeur</h3>
            <div class="photo-container">
                    <img src="https://placehold.co/200x250/CCCCCC/000000/png?text=Portrait+Test" alt="" class="client-photo">
                </div>
            <p><strong>Nom:</strong> <?php echo $demoReport['client']['nom']; ?></p>
            <p><strong>Email:</strong> <?php echo $demoReport['client']['email']; ?></p>
            <p><strong>Téléphone:</strong> <?php echo $demoReport['client']['telephone']; ?></p>
        </div>

        <!-- Détails du report -->
        <div class="section">
            <h3>Détails du report</h3>
            <p><strong>Date d'envoi:</strong> <?php echo $demoReport['date']; ?></p>
            <p><strong>Statut:</strong> 
                <span class="badge badge-<?php echo getStatusClass($demoReport['statut']); ?>">
                    <?php echo $demoReport['statut']; ?>
                </span>
            </p>
            <div class="description">
                <h4>Description</h4>
                <p><?php echo nl2br($demoReport['message']); ?></p>
            </div>
        </div>

        <!-- Pièces jointes -->
        <div class="section">
            <h3>Pièces jointes</h3>
            <div class="attachments">
                <?php foreach($demoReport['attachments'] as $attachment): ?>
                <div class="attachment">
                    <i class="fas fa-file"></i>
                    <a href="<?php echo $attachment['url']; ?>" target="_blank">
                        <?php echo $attachment['name']; ?>
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
        <h3>Nouveau Ticket</h3>
        <form>
            <div class="form-group">
                <label>Priorité</label>
                <select class="form-control">
                    <option value="low">Basse</option>
                    <option value="medium">Moyenne</option>
                    <option value="high">Haute</option>
                </select>
            </div>
            <div class="form-group">
                <label>Assigné à</label>
                <select class="form-control">
                    <option value="">Sélectionner un agent</option>
                    <!-- Options des agents -->
                </select>
            </div>
            <div class="form-group">
                <label>Commentaire</label>
                <textarea class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Créer le ticket</button>
        </form>
    </div>
</div>

<?php
function getStatusClass($status) {
    switch($status) {
        case 'en_cours': return 'warning';
        case 'valide': return 'success';
        case 'refuse': return 'danger';
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
</script>
