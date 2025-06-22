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
                    <th>Priorité <i class="fas fa-sort"></i></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($tickets) && is_array($tickets)) : ?>
                    <?php foreach ($tickets as $ticket) : ?>
                        <tr>
                            <td><?= $ticket['id'] ?></td>
                            <td><?= htmlspecialchars($ticket['sujet']) ?></td>
                            <td><?= htmlspecialchars($ticket['categorie']) ?></td>
                            <td class="libelle"><?= htmlspecialchars($ticket['libelle']) ?></td>
                            <td><?= htmlspecialchars($ticket['client']) ?></td>
                            <td><?= htmlspecialchars($ticket['date']) ?></td>
                            <td>
                                <span class="priority <?= strtolower($ticket['priorite']) ?>">
                                    <?= ucfirst($ticket['priorite']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-affiliate">Affilier</button>
                                    <button class="btn-delete">Supprimer</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucun ticket disponible</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .tickets-container {
        padding: 20px;
    }

    .filters-section {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .filters-group {
        display: flex;
        gap: 15px;
    }

    .filter-select, .filter-date, .filter-search {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        min-width: 150px;
    }

    .filter-reset {
        padding: 8px 15px;
        background: #f5f5f5;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .tickets-table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: auto;
    }

    .tickets-table {
        width: 100%;
        border-collapse: collapse;
    }

    .tickets-table th, 
    .tickets-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .tickets-table th {
        background: #f8f9fa;
        font-weight: 600;
    }

    .tickets-table th i {
        margin-left: 5px;
        cursor: pointer;
    }

    .libelle {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .priority {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }

    .priority.high {
        background: #ffebee;
        color: #c62828;
    }

    .priority.moyenne {
        background: #fff3e0;
        color: #e65100;
    }

    .priority.basse {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .btn-action {
        padding: 5px;
        margin: 0 2px;
        border: none;
        background: none;
        cursor: pointer;
        color: #666;
    }

    .btn-action:hover {
        color: #0A6CF6;
    }

    .text-center {
        text-align: center;
        padding: 20px;
        color: #666;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-delete, .btn-affiliate {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 18px;
        border: none;
        font-size: 12px;
        cursor: pointer;    
        transition: all 0.3s ease;
    }

    .btn-delete {
        background-color: #ED244E;
        color: white;
    }

    .btn-affiliate {
        background-color: #13325E;
        color: white;
    }
    
    .btn-delete:hover {
        background-color:rgb(238, 2, 53);
    }
    
    .btn-affiliate:hover {
        background-color:rgb(1, 35, 83);
    }
</style>

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
</script>
