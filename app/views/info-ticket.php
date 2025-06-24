
<div class="ticket-info-container">
    <div class="ticket-header">
        <img src="https://i.pravatar.cc/60?img=<?= rand(1, 70) ?>" alt="Client" class="ticket-avatar">
        <div>
            <h1 class="ticket-title"><?= htmlspecialchars($ticket['sujet']) ?></h1>
            <div class="ticket-meta">
                <span>Créé le : <?= date('d/m/Y H:i', strtotime($ticket['date_creation'])) ?></span>
                <span>Par : <?= htmlspecialchars($ticket['client']->getNom() . ' ' . $ticket['client']->getPrenom()) ?></span>
            </div>
        </div>
    </div>

    <div class="ticket-section">
        <span class="ticket-badge badge-category"><?= htmlspecialchars($ticket['categorie']) ?></span>
        <span class="ticket-badge badge-status"><?= ucfirst(htmlspecialchars($ticket['statut'])) ?></span>
        <span class="ticket-badge badge-priority"><?= ucfirst(htmlspecialchars($ticket['priorite'])) ?></span>
    </div>

    <div class="ticket-section">
        <div class="ticket-section-title">Description</div>
        <p class="ticket-description"><?= nl2br(htmlspecialchars($ticket['description'])) ?></p>
    </div>

    <div class="ticket-section">
        <div class="ticket-section-title">Informations complémentaires</div>
        <ul style="list-style:none; padding:0; margin:0;">
            <li><strong>Durée estimée :</strong> <?= htmlspecialchars($ticket['duree'] ?? 'Non renseignée') ?> h</li>
            <li><strong>Coût horaire :</strong> <?= htmlspecialchars($ticket['cout_horaire'] ?? 'Non renseigné') ?> Ar</li>
            <li><strong>Agent assigné :</strong> <?= htmlspecialchars($ticket['agent_affecte']) ?></li>
        </ul>
    </div>

    <div class="ticket-footer">
        <a href="<?= Flight::get('flight.base_url') ?>/tickets" class="btn">Retour à la liste</a>
    </div>
</div>