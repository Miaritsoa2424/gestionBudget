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
                <?php

        use app\models\CategorieTicket;

 foreach ($categories as $categorie): ?>
                    <option value="<?= $categorie->getId() ?>"><?= htmlspecialchars($categorie->getNom()) ?></option>
                <?php endforeach; ?>
            </select>

            <select class="filter-select">
                <option value="">Priorité</option>
                <?php foreach ($priorites as $priorite): ?>
                    <option value="<?= $priorite->getIdImportance() ?>"><?= htmlspecialchars($priorite->getNom()) ?></option>
                <?php endforeach; ?>
            </select>

            <input type="date" class="filter-date-start" placeholder="Date début">
            <input type="date" class="filter-date-end" placeholder="Date fin">

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
                        <tr data-ticket-id="<?= $ticket['id'] ?>" data-categorie-id="<?= CategorieTicket::getCategorieByName($ticket['categorie'])->getId() ?>">
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
    // Fonction de filtrage des tickets optimisée
function filterTickets() {
    const categorySelect = document.querySelectorAll('.filter-select')[0];
    const prioritySelect = document.querySelectorAll('.filter-select')[1];
    const dateStartInput = document.querySelector('.filter-date-start');
    const dateEndInput = document.querySelector('.filter-date-end');
    const searchInput = document.querySelector('.filter-search');
    
    // Récupération des valeurs de filtre
    const category = categorySelect.value.trim();
    const priority = prioritySelect.value.trim();
    const dateStart = dateStartInput.value.trim();
    const dateEnd = dateEndInput.value.trim();
    const searchTerm = searchInput.value.toLowerCase().trim();
    
    console.log('Filtres appliqués:', { category, priority, dateStart, dateEnd, searchTerm });
    
    // Parcourir toutes les lignes du tableau
    const rows = document.querySelectorAll('.tickets-table tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        // Vérifier si c'est la ligne "Aucun ticket disponible"
        if (row.children.length === 1 && row.children[0].getAttribute('colspan')) {
            return; // Ignorer cette ligne
        }
        
        let shouldShow = true;

        // Filtre par catégorie
        if (category && category !== '') {
            const rowCategoryId = row.getAttribute('data-categorie-id');
            if (rowCategoryId !== category) {
                shouldShow = false;
            }
        }
        
        // Filtre par priorité
        if (priority && priority !== '' && shouldShow) {
            const priorityCell = row.children[8]; // Colonne priorité
            if (priorityCell) {
                const rowPriority = priorityCell.textContent.trim().toLowerCase();
                // Obtenir le nom de la priorité depuis l'option sélectionnée
                const selectedPriorityOption = prioritySelect.options[prioritySelect.selectedIndex];
                const priorityName = selectedPriorityOption ? selectedPriorityOption.textContent.toLowerCase() : '';
                
                if (priorityName && rowPriority !== priorityName) {
                    shouldShow = false;
                }
            }
        }
        
        // Nouveau filtre par plage de dates
        if ((dateStart || dateEnd) && shouldShow) {
            const dateCell = row.children[5]; // Colonne date
            if (dateCell) {
                const rowDateStr = dateCell.textContent.trim();
                let rowDateObj = null;
                if (rowDateStr.includes('/')) {
                    // Format DD/MM/YYYY
                    const parts = rowDateStr.split('/');
                    if (parts.length === 3) {
                        rowDateObj = new Date(parts[2], parts[1] - 1, parts[0]);
                    }
                } else if (rowDateStr.includes('-')) {
                    // Format YYYY-MM-DD
                    rowDateObj = new Date(rowDateStr);
                }
                if (!rowDateObj || isNaN(rowDateObj.getTime())) {
                    shouldShow = false;
                } else {
                    if (dateStart) {
                        const start = new Date(dateStart);
                        if (rowDateObj < start) shouldShow = false;
                    }
                    if (dateEnd) {
                        const end = new Date(dateEnd);
                        if (rowDateObj > end) shouldShow = false;
                    }
                }
            }
        }

        // Filtre par recherche textuelle
        if (searchTerm && shouldShow) {
            const sujetCell = row.children[1]; // Colonne sujet
            const libelleCell = row.children[3]; // Colonne libellé
            const clientCell = row.children[4]; // Colonne client
            
            const sujet = sujetCell ? sujetCell.textContent.toLowerCase() : '';
            const libelle = libelleCell ? libelleCell.textContent.toLowerCase() : '';
            const client = clientCell ? clientCell.textContent.toLowerCase() : '';
            
            const searchMatches = sujet.includes(searchTerm) || 
                                libelle.includes(searchTerm) || 
                                client.includes(searchTerm);
            
            if (!searchMatches) {
                shouldShow = false;
            }
        }
        
        // Afficher ou masquer la ligne
        row.style.display = shouldShow ? '' : 'none';
        if (shouldShow) {
            visibleCount++;
        }
    });
    
    console.log(`${visibleCount} tickets affichés après filtrage`);
}

// Fonction de réinitialisation des filtres
function resetFilters() {
    // Réinitialiser tous les champs de filtre
    document.querySelectorAll('.filter-select').forEach(select => {
        select.selectedIndex = 0;
    });
    document.querySelector('.filter-date-start').value = '';
    document.querySelector('.filter-date-end').value = '';
    document.querySelector('.filter-search').value = '';
    
    // Réappliquer le filtrage (affichera tous les tickets)
    filterTickets();
    
    console.log('Filtres réinitialisés');
}

// Fonction de tri des colonnes
function sortTable(columnIndex, ascending = true) {
    const table = document.querySelector('.tickets-table tbody');
    const rows = Array.from(table.querySelectorAll('tr')).filter(row => 
        !(row.children.length === 1 && row.children[0].getAttribute('colspan'))
    );
    
    rows.sort((a, b) => {
        const cellA = a.children[columnIndex];
        const cellB = b.children[columnIndex];
        
        if (!cellA || !cellB) return 0;
        
        let valueA = cellA.textContent.trim();
        let valueB = cellB.textContent.trim();
        
        // Traitement spécial pour les colonnes numériques
        if (columnIndex === 0 || columnIndex === 7) { // ID et Durée
            valueA = parseFloat(valueA) || 0;
            valueB = parseFloat(valueB) || 0;
            return ascending ? valueA - valueB : valueB - valueA;
        }
        
        // Traitement spécial pour les dates
        if (columnIndex === 5) {
            const dateA = new Date(valueA);
            const dateB = new Date(valueB);
            if (!isNaN(dateA.getTime()) && !isNaN(dateB.getTime())) {
                return ascending ? dateA - dateB : dateB - dateA;
            }
        }
        
        // Tri alphabétique par défaut
        return ascending ? 
            valueA.localeCompare(valueB, 'fr', { numeric: true }) : 
            valueB.localeCompare(valueA, 'fr', { numeric: true });
    });
    
    // Réinsérer les lignes triées
    rows.forEach(row => table.appendChild(row));
}

// Gestion des événements de tri
let sortStates = {}; // Pour suivre l'état de tri de chaque colonne

function setupSortHandlers() {
    document.querySelectorAll('th i.fa-sort').forEach((icon, index) => {
        const th = icon.parentElement;
        const columnIndex = Array.from(th.parentElement.children).indexOf(th);
        
        sortStates[columnIndex] = true; // true = ascending, false = descending
        
        icon.addEventListener('click', () => {
            // Réinitialiser les icônes
            document.querySelectorAll('th i.fa-sort').forEach(i => {
                i.className = 'fas fa-sort';
            });
            
            // Appliquer le tri
            const ascending = sortStates[columnIndex];
            sortTable(columnIndex, ascending);
            
            // Mettre à jour l'icône
            icon.className = ascending ? 'fas fa-sort-up' : 'fas fa-sort-down';
            
            // Inverser l'état pour le prochain clic
            sortStates[columnIndex] = !ascending;
            
            console.log(`Tri colonne ${columnIndex}, croissant: ${ascending}`);
        });
    });
}

// Modal pour modification de durée
let currentTicketId = null;


function openModal(ticketId) {
    currentTicketId = ticketId;
    const modal = document.getElementById('modifyModal');
    const row = document.querySelector(`tr[data-ticket-id="${ticketId}"]`);
    
    if (row) {
        const durationCell = row.children[7]; // Colonne durée
        const currentDuration = durationCell ? durationCell.textContent.trim().split(' ')[0] : '0';
        document.getElementById('currentDuration').textContent = currentDuration;
        document.getElementById('duration').value = currentDuration;

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
}

function saveDuration() {
    const duration = document.getElementById('duration').value;
    if (duration && currentTicketId) {
        // Mettre à jour l'affichage dans le tableau
        const row = document.querySelector(`tr[data-ticket-id="${currentTicketId}"]`);
        if (row) {
            const durationCell = row.children[7];
            if (durationCell) {
                durationCell.textContent = `${duration} h`;
            }
        }
        
        // Ici vous pouvez ajouter l'appel AJAX pour sauvegarder en base
        console.log(`Ticket ${currentTicketId}: ${duration} heures`);
        
        // Fermer la modal
        document.getElementById('modifyModal').style.display = 'none';
        document.getElementById('duration').value = '';
        currentTicketId = null;
    } else {
        alert('Veuillez saisir une durée valide');
    }
}

function affilierTicket(ticketId) {
    window.location.href = `affilierTicket/${ticketId}`;
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Configuration des événements de filtrage
    document.querySelectorAll('.filter-select, .filter-date-start, .filter-date-end, .filter-search').forEach(input => {
        input.addEventListener('input', filterTickets);
        input.addEventListener('change', filterTickets);
    });
    
    // Configuration du bouton de réinitialisation
    const resetButton = document.querySelector('.filter-reset');
    if (resetButton) {
        resetButton.addEventListener('click', resetFilters);
    }
    
    // Configuration des gestionnaires de tri
    setupSortHandlers();
    
    // Configuration de la modal
    const modal = document.getElementById('modifyModal');
    const closeBtn = document.querySelector('.close');
    
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }
    
    // Fermer la modal en cliquant en dehors
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    
    // Configuration des boutons de sauvegarde
    const saveBtn = document.querySelector('.btn-save');
    if (saveBtn) {
        saveBtn.addEventListener('click', saveDuration);
    }
    
    // Permettre la sauvegarde avec Enter dans le champ durée
    const durationInput = document.getElementById('duration');
    if (durationInput) {
        durationInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                saveDuration();
            }
        });

    function affilierTicket(ticketId) {
        window.location.href = `affilierTicket/${ticketId}`;

    }
    
    console.log('Système de filtrage des tickets initialisé');
});
</script>
