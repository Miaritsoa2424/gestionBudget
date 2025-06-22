<section>

<div class="filter-bar">
    <div class="filters">
        <input type="text" placeholder="🔍" id="global-search">
        <button class="clear-btn" type="button">✖</button>
        <input type="text" placeholder="Réf." id="filter-ref">

        <!-- Auteur (Clients) -->
        <select id="filter-auteur">
            <option value="">Auteur</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?= htmlspecialchars($client['nomClient']) ?>">
                    <?= htmlspecialchars($client['nomClient']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" placeholder="Sujet" id="filter-sujet">

        <!-- Type (Types de demande) -->
        <select id="filter-type">
            <option value="">Type</option>
            <?php foreach ($types as $type): ?>
                <option value="<?= htmlspecialchars($type['nom']) ?>">
                    <?= htmlspecialchars($type['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Sévérité (Importance) -->
        <select id="filter-severite">
            <option value="">Sévérité</option>
            <?php foreach ($importances as $importance): ?>
                <option value="<?= htmlspecialchars($importance['nom']) ?>">
                    <?= htmlspecialchars($importance['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" placeholder="Tiers" id="filter-tiers">

        <div class="date-range">
            <input type="date" placeholder="Du" id="filter-date-du">
            <input type="date" placeholder="au" id="filter-date-au">
        </div>

        <!-- Assigné à (Départements) -->
        <select id="filter-assigne">
            <option value="">Assigné à</option>
            <?php foreach ($depts as $dept): ?>
                <option value="<?= htmlspecialchars($dept['nomDept']) ?>">
                    <?= htmlspecialchars($dept['nomDept']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- État -->
        <select id="filter-etat">
            <option value="">-- Ouvert (tout)</option>
            <?php foreach ($etats as $etat): ?>
                <option value="<?= htmlspecialchars($etat['nom']) ?>">
                    <?= htmlspecialchars($etat['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

        <table class="results-table">
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Réf.</th>
                    <th>Auteur</th>
                    <th>Sujet</th>
                    <th>Type</th>
                    <th>Sévérité</th>
                    <th>Tiers</th>
                    <th>Date création</th>
                    <th>Assigné à</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tickets)): ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <tr>
                            <td><input type="checkbox" value="<?= htmlspecialchars($ticket['idTicket']) ?>"></td>
                            <td><?= htmlspecialchars($ticket['idTicket']) ?></td>
                            <td><?= htmlspecialchars($ticket['nomClient']) ?></td>
                            <td><?= htmlspecialchars($ticket['sujet']) ?></td>
                            <td><?= htmlspecialchars($ticket['nomTypeDemande']) ?></td>
                            <td><?= htmlspecialchars($ticket['nomImportance']) ?></td>
                            <td><?= htmlspecialchars($ticket['description']) ?></td>
                            <td><?= htmlspecialchars($ticket['dateDemande']) ?></td>
                            <td><?= htmlspecialchars($ticket['nomDept']) ?></td>
                            <td><?= htmlspecialchars($ticket['nomEtat']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="empty">
                        <td colspan="10">Aucun enregistrement trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
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
        document.getElementById('filter-assigne'),
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

            // Colonnes : [0]=checkbox, [1]=Réf., [2]=Auteur, [3]=Sujet, [4]=Type, [5]=Sévérité, [6]=Tiers, [7]=Date création, [8]=Assigné à, [9]=État

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
            // Assigné à
            if (assigne && !normalize(cells[8].textContent).includes(assigne)) show = false;
            // État
            if (etat && !normalize(cells[9].textContent).includes(etat)) show = false;

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
});
</script>
