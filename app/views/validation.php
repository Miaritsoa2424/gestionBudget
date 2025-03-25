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
            <?php for ($i=0; $i < 20; $i++) { ?>
                <tr>
                    <td>Finance</td>
                    <td>Carburant</td>
                    <td>2025-03-25</td>
                    <td>Recette</td>
                    <td>100 000 MGA</td>
                    <td class="action-buttons">
                        <button class="edit-btn">Details</button>
                        <button class="edit-btn">Valider</button>
                        <button class="delete-btn">Refuser</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>