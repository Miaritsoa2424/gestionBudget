<style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>

<div class="tickets-container">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= $_SESSION['success_message'] ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error_message'] ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <!-- Filtres -->
    <h1><?= $title ?></h1>
    <div class="filters-section">
        <div class="filters-group">
            <select class="filter-select">
                <option value="">Catégorie</option>
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?= $categorie->getId() ?>"><?= htmlspecialchars($categorie->getNom()) ?></option>
                <?php endforeach; ?>
            </select>

            <select class="filter-select">
                <option value="">Priorité</option>
                <?php foreach ($priorites as $priorite): ?>
                    <option value="<?= $priorite->getIdImportance() ?>"><?= htmlspecialchars($priorite->getNom()) ?></option>
                <?php endforeach; ?>
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
                    <th>Statut <i class="fas fa-sort"></i></th>
                    <th>Durée</th>
                    <th>Priorité <i class="fas fa-sort"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($tickets) && is_array($tickets)) : ?>
                    <?php foreach ($tickets as $ticket) : ?>
                        <tr data-ticket-id="<?= $ticket['id'] ?>" data-categorie-id="<?= htmlspecialchars($ticket['categorie_id'] ?? $ticket['categorie']) ?>">
                            <td><?= $ticket['id'] ?></td>
                            <td><?= htmlspecialchars($ticket['sujet']) ?></td>
                            <td><?= htmlspecialchars($ticket['categorie']) ?></td>
                            <td class="libelle"><?= htmlspecialchars($ticket['libelle']) ?></td>
                            <td><?= htmlspecialchars($ticket['client']->getNom()) . ' ' . htmlspecialchars($ticket['client']->getPrenom()) ?></td>
                            <td><?= htmlspecialchars($ticket['date']) ?></td>
                            <td><span class="status-badge <?= strtolower($ticket['statut']) ?>"><?= ucfirst($ticket['statut']) ?></span></td>
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
        <form id="updateDureeForm" action="/gestionBudget/updateDureeTicket" method="post" onsubmit="return validateForm()">
            <span class="close">&times;</span>
            <h2>Modifier la durée du ticket <span id="ticketIdDisplay"></span></h2>
            <div class="form-group">
                <p>Durée actuelle : <span id="currentDuration">0</span> h</p>
                <label for="duree">Nouvelle durée (en heures)</label>
                <input type="number" id="duree" name="duree" min="0.5" step="0.5" class="form-control" required>
                <input type="hidden" name="id_ticket" id="id_ticket" value="">
            </div>
            <button type="submit" class="btn-save">Enregistrer</button>
        </form>
    </div>
</div>

<script>
    // Fonction de filtrage des tickets
    function filterTickets() {
        const category = document.querySelectorAll('.filter-select')[0].value;
        const priority = document.querySelectorAll('.filter-select')[1].value.toLowerCase();
        const date = document.querySelector('.filter-date').value;
        const search = document.querySelector('.filter-search').value.toLowerCase();

        document.querySelectorAll('.tickets-table tbody tr').forEach(row => {
            const catId = row.getAttribute('data-categorie-id');
            const prio = row.children[8].textContent.toLowerCase();
            const dateRow = row.children[5].textContent.trim();
            const sujet = row.children[1].textContent.toLowerCase();
            const libelle = row.children[3].textContent.toLowerCase();
            const client = row.children[4].textContent.toLowerCase();

            let show = true;

            // Filtre catégorie (par ID)
            if (category && catId !== category) show = false;

            // Filtre priorité
            if (priority && prio !== priority) show = false;

            // Filtre date
            if (date) {
                const dateInput = date.split('-').reverse().join('/');
                if (!dateRow.includes(date) && !dateRow.includes(dateInput)) show = false;
            }

            // Filtre recherche
            if (search && !(sujet.includes(search) || libelle.includes(search) || client.includes(search))) show = false;

            row.style.display = show ? '' : 'none';
        });
    }

    // Ajout des écouteurs sur les filtres
    document.querySelectorAll('.filter-select, .filter-date, .filter-search').forEach(input => {
        input.addEventListener('input', filterTickets);
        input.addEventListener('change', filterTickets);
    });

    // Réinitialisation des filtres + affichage de tous les tickets
    document.querySelector('.filter-reset').addEventListener('click', () => {
        document.querySelectorAll('.filter-select, .filter-date, .filter-search')
            .forEach(filter => filter.value = '');
        filterTickets();
    });

    // Gestion du tri (à compléter si besoin)
    document.querySelectorAll('th i.fa-sort').forEach(icon => {
        icon.addEventListener('click', () => {
            // Ajoutez ici la logique de tri si nécessaire
        });
    });

    // Modal modification durée
    let currentTicketId = null;

    function validateForm() {
        const ticketId = document.getElementById('id_ticket').value;
        const duree = document.getElementById('duree').value;
        
        if (!ticketId || !duree) {
            alert('Le ID du ticket et la durée sont obligatoires');
            return false;
        }
        return true;
    }

    function openModal(ticketId) {
        if (!ticketId) return;
        
        const modal = document.getElementById('modifyModal');
        const row = document.querySelector(`tr[data-ticket-id="${ticketId}"]`);
        if (!row) return;
        
        const currentDuration = row.querySelector('td:nth-child(8)').textContent.trim().split(' ')[0];
        
        // Mettre à jour l'ID du ticket dans le formulaire
        document.getElementById('id_ticket').value = ticketId;
        document.getElementById('ticketIdDisplay').textContent = '#' + ticketId;
        document.getElementById('currentDuration').textContent = currentDuration;
        document.getElementById('duree').value = currentDuration;
        
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

    function affilierTicket(ticketId) {
        window.location.href = `affilierTicket/${ticketId}`;
    }
</script>
