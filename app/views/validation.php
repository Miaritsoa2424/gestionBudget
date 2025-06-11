<div class="navigationTable">
    <h1><i class="fas fa-check-circle"></i> Validation</h1>
    <div class="controls">
        <input type="text" placeholder="Rechercher..." class="search-input">
        <select  class="sort-select">
            <option value="">Trier par</option>
            <option value="nom">Nom Département</option>
            <option value="date">Date</option>
            <option value="montant">Montant</option>
        </select>
        <button class="pdf-btn"><i class="fas fa-file-pdf"></i> Exporter en PDF</button>
    </div>
</div>

<section class="validationList">
    <table>
        <thead>
            <tr>
                <th>Département</th>
                <th>Rubrique</th>
                <th>Date</th>
                <th>Recette/Dépense</th>
                <th>Montant</th>
                <th class="thAction">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($validations as $validation) { ?>
                <tr>
                    <td><?= htmlspecialchars($validation['nomDept']) ?></td>
                    <td><?= htmlspecialchars($validation['nomRubrique']) ?></td>
                    <td><?= htmlspecialchars($validation['date']) ?></td>
                    <td><?= $validation['recetteOuDepense'] == 0 ? "Recette" : "Dépense" ?></td>
                    <td><?= number_format($validation['montant'], 2, ',', ' ') ?> MGA</td>
                    <td class="action-buttons">
                        <a href="#"><button class="edit-btn">Details</button></a>
                        <a href="<?= Flight::get('flight.base_url') ?>/validation/valider/<?= $validation['idValeur'] ?>">
                            <button class="edit-btn">Valider</button>
                        </a>
                        <a href="<?= Flight::get('flight.base_url') ?>/validation/refuser/<?= $validation['idValeur'] ?>">
                            <button class="delete-btn">Refuser</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

<script>
// Recherche en temps réel
document.querySelector('.search-input').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('.validationList tbody tr');

    rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        row.style.display = rowText.includes(searchValue) ? '' : 'none';
    });
});

// Tri des colonnes
document.querySelector('.sort-select').addEventListener('change', function () {
    const sortBy = this.value;
    const rows = Array.from(document.querySelectorAll('.validationList tbody tr'));
    const tbody = document.querySelector('.validationList tbody');

    const getCellValue = (row, column) => row.children[column].textContent.trim();

    let columnIndex;
    switch (sortBy) {
        case 'nom':
            columnIndex = 0; // Colonne "Nom Département"
            break;
        case 'date':
            columnIndex = 2; // Colonne "Date"
            break;
        case 'montant':
            columnIndex = 4; // Colonne "Montant"
            break;
        default:
            return; // Pas de tri
    }

    rows.sort((a, b) => {
        const aValue = getCellValue(a, columnIndex);
        const bValue = getCellValue(b, columnIndex);

        if (sortBy === 'montant') {
            // Convertir les montants en nombres pour le tri
            return parseFloat(aValue.replace(/\s/g, '').replace(',', '.')) - parseFloat(bValue.replace(/\s/g, '').replace(',', '.'));
        } else if (sortBy === 'date') {
            // Comparer les dates
            return new Date(aValue) - new Date(bValue);
        } else {
            // Comparer les chaînes de texte
            return aValue.localeCompare(bValue);
        }
    });

    // Réinsérer les lignes triées dans le tableau
    rows.forEach(row => tbody.appendChild(row));
});
</script>