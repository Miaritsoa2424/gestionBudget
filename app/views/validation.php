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