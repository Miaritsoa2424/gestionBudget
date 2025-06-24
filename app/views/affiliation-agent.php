<div class="tickets-container">
    <!-- Filtres -->
    <h1><?= $title ?></h1>
    <div class="filters-section">
        <div class="filters-group">
            <select class="filter-select">
                <option value="">Catégorie</option>
                <option value="technique">Technique</option>
                <option value="commercial">Commercial</option>
                <option value="facturation">Facturation</option>
            </select>

            <select class="filter-select">
                <option value="">Priorité</option>
                <option value="haute">Haute</option>
                <option value="moyenne">Moyenne</option>
                <option value="basse">Basse</option>
            </select>

            <input type="date" class="filter-date" placeholder="Date">
            
            <input type="text" class="filter-search" placeholder="Rechercher un ticket...">
        </div>

        <button class="filter-reset">
            <i class="fas fa-redo"></i> Réinitialiser
        </button>
    </div>

    <!-- Tableau des tickets -->
    <div class="tickets-table-container">
        <table class="tickets-table">
            <thead>
                <tr>
                    <th>ID <i class="fas fa-sort"></i></th>
                    <th>Sujet <i class="fas fa-sort"></i></th>
                    <th>Catégorie <i class="fas fa-sort"></i></th>
                    <th>Libellé</th>
                    <th>Client <i class="fas fa-sort"></i></th>
                    <th>Date <i class="fas fa-sort"></i></th>
                    <th>État <i class="fas fa-sort"></i></th>
                    <th>Durée (Heure)</th>
                    <th>Priorité <i class="fas fa-sort"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($tickets) && is_array($tickets)) : ?>
                    <?php foreach ($tickets as $ticket) : ?>
                        <tr data-ticket-id="<?= $ticket['id'] ?>">
                            <td><?= $ticket['id'] ?></td>
                            <td><?= htmlspecialchars($ticket['sujet']) ?></td>
                            <td><?= htmlspecialchars($ticket['categorie']) ?></td>
                            <td class="libelle"><?= htmlspecialchars($ticket['libelle']) ?></td>
                            <td><?= htmlspecialchars($ticket['client']) ?></td>
                            <td><?= htmlspecialchars($ticket['date']) ?></td>
                            <td><span class="status-badge <?= strtolower($ticket['etat']) ?>"><?= ucfirst($ticket['etat']) ?></span></td>
                            <td><?= $ticket['duree'] ?? '0' ?> </td>
                            <td>
                                <span class="priority <?= strtolower($ticket['priorite']) ?>">
                                    <?= ucfirst($ticket['priorite']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-affiliate" onclick="affilierTicket(<?= $ticket['id'] ?>)">Affilier</button>
                                    <button class="btn-modify" onclick="openModal(<?= $ticket['id'] ?>)">Modifier</button>
                                    <button class="btn-delete">Supprimer</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Aucun ticket disponible</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal pour la modification de la durée -->
<div id="modifyModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Modifier la durée</h2>
        <div class="form-group">
            <p>Durée actuelle : <span id="currentDuration">0</span> h</p>
            <label for="duration">Nouvelle durée (en heures)</label>
            <input type="number" id="duration" min="1" step="0.5" class="form-control">
        </div>
        <button onclick="saveDuration()" class="btn-save">Enregistrer</button>
    </div>
</div>

<script>
    // Gestion du tri
    document.querySelectorAll('th i.fa-sort').forEach(icon => {
        icon.addEventListener('click', () => {
            // Ajoutez ici la logique de tri
        });
    });

    // Réinitialisation des filtres
    document.querySelector('.filter-reset').addEventListener('click', () => {
        document.querySelectorAll('.filter-select, .filter-date, .filter-search')
            .forEach(filter => filter.value = '');
    });

    let currentTicketId = null;

    function openModal(ticketId) {
        currentTicketId = ticketId;
        const modal = document.getElementById('modifyModal');
        const row = document.querySelector(`tr[data-ticket-id="${ticketId}"]`);
        const currentDuration = row.querySelector('td:nth-child(8)').textContent.split(' ')[0];
        document.getElementById('currentDuration').textContent = currentDuration;
        modal.style.display = 'block';
    }

    // Fermer la modal
    document.querySelector('.close').addEventListener('click', () => {
        document.getElementById('modifyModal').style.display = 'none';
    });

    // Fermer la modal si on clique en dehors
    window.addEventListener('click', (event) => {
        const modal = document.getElementById('modifyModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    function saveDuration() {
        const duration = document.getElementById('duration').value;
        if (duration && currentTicketId) {
            // Ici, ajoutez votre logique pour sauvegarder la durée
            console.log(`Ticket ${currentTicketId}: ${duration} heures`);
            document.getElementById('modifyModal').style.display = 'none';
            document.getElementById('duration').value = '';
        }
    }

    function affilierTicket(ticketId) {
        window.location.href = `affilierTicket/${ticketId}`;
    }
</script>
