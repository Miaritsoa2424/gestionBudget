<div class="navigationTable">
    <h1>Fiche Budgétaire
    </h1>
    <div class="controls">
        <form action="budget" method="post">
            <label for="dateDeb">Debut :</label>
            <input type="date" name="dateDeb">
            <label for="dateFin">Fin :</label>
            <input type="date" name="dateFin">

            <select class="periode-select" name="idDept">
                <?php
                foreach ($departements as $departement) {
                    echo '<option value="' . $departement->getIdDept() . '">' . $departement->getNomDept() . '</option>';
                }
                ?>
            </select>

            <select class="periode-select" name="intervalle">
                <option value="">Intervalle de temps</option>
                <option value="1">Mensuelle</option>
                <option value="2">Bimestrielle</option>
                <option value="3">Trimestrielle</option>
                <option value="6">Semestrielle</option>
            </select>
            <button class="valider" type="submit">Valider</button>
        </form>
        <button class="pdf-btn"><i class="fas fa-file-pdf"></i><a href="<?= Flight::get('flight.base_url') ?>export">Exporter en PDF</a></button>

    </div>
</div>
<section class="budgetSection">
    <div class="enTeteTable">
        <button class="prev" id="openPopUpPrev"><i class="fas fa-plus-circle"></i> Ajout Prévision</button>
        <!-- Pagination Controls -->
        <div id="paginationControls">
            <h2>
                <?php if (isset($datDeb) && isset($dateFin)) {
                    echo date('F Y', strtotime($datDeb)) . ' - ' . date('F Y', strtotime($dateFin));
                }
                ?></h2>
            <div class="direction">
                <button id="prevPage" onclick="changePage(-1)"> <i class="fas fa-arrow-left"></i><span>Précédent</span></button>
                <span id="pageNumber">Page 1</span>
                <button id="nextPage" onclick="changePage(1)"><span>Suivant</span><i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
        <button class="real" id="openPopUpReal"><i class="fas fa-check-circle"></i> Ajout Réalisation</button>
    </div>

    <!-- Conteneur des tables pour pagination -->
    <div id="tablesContainer">
        <?php $soldeFin = 0 ;
        $soldeDebut = $soldeInitial;?>
        <?php if (isset($tablesData)) {
            foreach ($tablesData as $i => $table) { ?>
                <div class="tablePage">
                    <table>
                        <tr>
                            <th rowspan="2">Rubrique</th>
                            <th colspan="3"><?= $table['mois'] ?></th>
                        </tr>
                        <tr>
                            <th>Prévision</th>
                            <th>Réalisation</th>
                            <th>Écart</th>
                        </tr>
                        <?= $table['totalRecettes'] ?>
                        <tr class="numberRow">
                            <td>Solde debut</td>
                            <td colspan="3" class="cellNumber"><?= $soldeDebut ?></td>

                        </tr>
                        <?php foreach ($table['data'] as $row) { ?>
                            <tr class="numberRow">
                                <td><?= $row['rubrique'] ?></td>
                                <td class="cellNumber"><?= $row['prevision'] ?></td>
                                <td class="cellNumber"><?= $row['realisation'] ?></td>
                                <td class="cellNumber"><?= $row['realisation'] - $row['prevision'] ?></td>
                            </tr>
                        <?php } ?>
                        <?php $soldeFin = $soldeDebut + $table['totalRecettes'] - $table['totalDepenses']; ?>
                        <tr class="numberRow">
                            <td>Solde fin</td>
                            <td colspan="3" class="cellNumber"><?= $soldeFin ?></td>
                        </tr>
                        <?php $soldeDebut = $soldeFin; ?>
                    </table>
                </div>
        <?php }
        }
        ?>
    </div>


    <?php include 'prevForm.php'; ?>
    <?php include 'realForm.php'; ?>
    <?php include 'csvForm.php'; ?>

</section>
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/budget_next.js"></script>
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/pop_up_real_prev.js"></script>
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/pop_up_csv.js"></script>