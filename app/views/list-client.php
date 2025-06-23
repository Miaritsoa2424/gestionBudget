<div class="header-actions">
    <h1><?= $title ?></h1>
    <button class="btn btn-primary" id="addClientBtn">+ Ajouter un client</button>
</div>
<?php include 'form-client.php'; ?>
<div class="filter-bar">
    <div class="filters">
        <input type="text" placeholder="🔍" id="global-search">
        <button class="clear-btn" type="button">✖</button>
        <input type="text" placeholder="Réf." id="filter-ref">

        <!-- Auteur (Clients) -->
        <select id="filter-auteur">
            <option value="">Auteur</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?= htmlspecialchars($client->getNom()).' '.htmlspecialchars($client->getPrenom()) ?>"><?= htmlspecialchars($client->getNom()).' '.htmlspecialchars($client->getPrenom()) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" placeholder="Sujet" id="filter-sujet">

        <!-- Type -->
        <select id="filter-type">
            <option value="">Type</option>
            <option value="Bug">Bug</option>
            <option value="Feature">Feature</option>
            <option value="Support">Support</option>
        </select>

        <!-- Sévérité -->
        <select id="filter-severite">
            <option value="">Sévérité</option>
            <option value="Critique">Critique</option>
            <option value="Haute">Haute</option>
            <option value="Moyenne">Moyenne</option>
            <option value="Basse">Basse</option>
        </select>

        <input type="text" placeholder="Tiers" id="filter-tiers">

        <div class="date-range">
            <input type="date" placeholder="Du" id="filter-date-du">
            <input type="date" placeholder="au" id="filter-date-au">
        </div>

        <!-- État -->
        <select id="filter-etat">
            <option value="">-- Ouvert (tout)</option>
            <option value="Nouveau">Nouveau</option>
            <option value="En cours">En cours</option>
            <option value="Résolu">Résolu</option>
            <option value="Fermé">Fermé</option>
        </select>
    </div>

    <table class="results-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom du client</th>
                <th>Email</th>
                <th>Notifications</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($clients) === 0): ?>
                <tr class="empty"><td colspan="6">Aucun client trouvé.</td></tr>
            <?php else: ?>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= $client->getId() ?></td>
                        <td><?= htmlspecialchars($client->getNom()) ?></td>
                        <td><?= htmlspecialchars($client->getEmail()) ?></td>
                        <td>
                            <div class="notification-bell">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge">5</span>
                            </div>
                        </td>
                        <td>
                            <a href="detail-client" class="btn btn-info">Détails</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterInputs = [
        document.getElementById('global-search'),
        document.getElementById('filter-ref'),
        document.getElementById('filter-auteur'),
        document.getElementById('filter-sujet'),
        document.getElementById('filter-type'),
        document.getElementById('filter-severite'),
        document.getElementById('filter-tiers'),
        document.getElementById('filter-date-du'),
        document.getElementById('filter-date-au'),
        document.getElementById('filter-etat')
    ];
    const clearBtn = document.querySelector('.clear-btn');
    const tableRows = document.querySelectorAll('.results-table tbody tr');

    function normalize(str) {
        return (str || '').toString().toLowerCase().trim();
    }

    function filterTable() {
        const [
            globalSearch, ref, auteur, sujet, type, severite, tiers, dateDu, dateAu, assigne, etat
        ] = filterInputs.map(input => input ? normalize(input.value) : '');

        let visibleCount = 0;
        tableRows.forEach(row => {
            if (row.classList.contains('empty')) return;

            const cells = row.querySelectorAll('td');
            let show = true;

            // Colonnes : [0]=checkbox, [1]=Réf., [2]=Auteur, [3]=Sujet, [4]=Type, [5]=Sévérité, [6]=Tiers, [7]=Date création, [8]=État

            // Recherche globale (sur toutes les colonnes sauf checkbox)
            if (globalSearch) {
                let found = false;
                for (let i = 1; i < cells.length; i++) {
                    if (normalize(cells[i].textContent).includes(globalSearch)) {
                        found = true;
                        break;
                    }
                }
                if (!found) show = false;
            }
            // Réf.
            if (ref && !normalize(cells[1].textContent).includes(ref)) show = false;
            // Auteur
            if (auteur && !normalize(cells[2].textContent).includes(auteur)) show = false;
            // Sujet
            if (sujet && !normalize(cells[3].textContent).includes(sujet)) show = false;
            // Type
            if (type && !normalize(cells[4].textContent).includes(type)) show = false;
            // Sévérité
            if (severite && !normalize(cells[5].textContent).includes(severite)) show = false;
            // Tiers
            if (tiers && !normalize(cells[6].textContent).includes(tiers)) show = false;
            // Date création (du)
            if (dateDu && cells[7].textContent < dateDu) show = false;
            // Date création (au)
            if (dateAu && cells[7].textContent > dateAu) show = false;
            // État
            if (etat && !normalize(cells[8].textContent).includes(etat)) show = false;

            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        // Affiche ou masque la ligne "Aucun enregistrement trouvé"
        const emptyRow = document.querySelector('.results-table .empty');
        if (emptyRow) emptyRow.style.display = visibleCount === 0 ? '' : 'none';
    }

    filterInputs.forEach(input => {
        if (input) {
            input.addEventListener('input', filterTable);
            input.addEventListener('change', filterTable);
        }
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            filterInputs.forEach(input => {
                if (!input) return;
                if (input.tagName === 'SELECT') input.selectedIndex = 0;
                else input.value = '';
            });
            filterTable();
        });
    }

    // Modal handling
    const modal = document.getElementById('addClientModal');
    const addBtn = document.getElementById('addClientBtn');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('addClientForm');

    addBtn.onclick = function() {
        modal.style.display = "block";
    }

    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    cancelBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    form.onsubmit = function(e) {
        e.preventDefault();
        // Ici vous pouvez ajouter la logique pour sauvegarder le client
        const formData = {
            name: document.getElementById('clientName').value,
            email: document.getElementById('clientEmail').value,
            phone: document.getElementById('clientPhone').value
        };
        console.log('Client à sauvegarder:', formData);
        modal.style.display = "none";
        form.reset();
    }
});
</script>
