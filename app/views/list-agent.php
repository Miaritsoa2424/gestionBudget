<div class="header-actions">
    <h1><?= $title ?></h1>
    <!-- <button class="btn btn-primary" id="addAgentBtn">+ Ajouter un agent</button> -->
</div>
<div class="filter-bar">
    <div class="filters">
        <input type="text" placeholder="🔍" id="global-search">
        <button class="clear-btn" type="button">✖</button>
    </div>

    <table class="results-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom de l'agent</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($agents) === 0): ?>
                <tr class="empty"><td colspan="4">Aucun agent trouvé.</td></tr>
            <?php else: ?>
                <?php foreach ($agents as $agent): ?>
                    <tr>
                        <td><?= $agent->getIdAgent() ?></td>
                        <td><?= htmlspecialchars($agent->getNom()) ?></td>
                        <td><?= htmlspecialchars($agent->getEmail()) ?></td>
                        <td>
                            <a href="fiche-paie/<?= $agent->getIdAgent() ?>" class="btn btn-info">Voir fiche de paie</a>
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
    const modal = document.getElementById('addAgentModal');
    const addBtn = document.getElementById('addAgentBtn');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('addAgentForm');

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
        const formData = {
            name: document.getElementById('agentName').value,
            email: document.getElementById('agentEmail').value,
            departement: document.getElementById('agentDepartement').value
        };
        console.log('Agent à sauvegarder:', formData);
        modal.style.display = "none";
        form.reset();
    }
});
</script>
