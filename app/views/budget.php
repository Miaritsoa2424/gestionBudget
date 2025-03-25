<div class="navigationTable">
    <h1>Fiche Budgétaire
    </h1>
    <div class="controls">
        <label for="dateDeb">Debut :</label>
        <input type="date" name="dateDeb">
        <label for="dateFin">Fin :</label>
        <input type="date" name="dateFin">


        <select class="periode-select">
            <option value="">Departements</option>
            <option value="">Finance</option>
            <option value="">IT</option>
            <option value="">Securite</option>
            <option value="">Ressource humaine</option>
        </select>

        <select class="periode-select">
            <option value="">Intervalle de temps</option>
            <option value="">Mensuelle</option>
            <option value="">Bimestrielle</option>
            <option value="">Trimestrielle</option>
            <option value="">Semestrielle</option>
        </select>
        <button class="valider" type="submit">Valider</button>
        <button class="pdf-btn" id="openPopUpCsv" style="background-color: #1ea162;"><i class="fas fa-file-csv"></i> Import Csv</button>
        <button class="pdf-btn"><i class="fas fa-file-pdf"></i> Exporter en PDF</button>
    </div>
</div>
<section class="budgetSection">
    <div class="enTeteTable">
        <button class="prev" id="openPopUpPrev"><i class="fas fa-plus-circle"></i> Ajout Prévision</button>
        <!-- Pagination Controls -->
        <div id="paginationControls">
            <h2>Janvier 2025 - Mars 2025</h2>
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
        <?php for ($i = 0; $i < 9; $i++) { // 9 tables au total 
        ?>
            <div class="tablePage">
                <table>
                    <tr>
                        <th rowspan="2">Rubrique</th>
                        <th colspan="3">Janvier 2025(table numero:<?= $i ?>)</th>
                    </tr>
                    <tr>
                        <th>Prevision</th>
                        <th>Realisation</th>
                        <th>Écart</th>
                    </tr>
                    <tr class="numberRow">
                        <td>Solde début</td>
                        <td class="cellNumber">1000</td>
                        <td class="cellNumber">900</td>
                        <td class="cellNumber">1000 - 900</td>
                    </tr>
                    <tr class="numberRow">
                        <td>Alimentation</td>
                        <td class="cellNumber">1000</td>
                        <td class="cellNumber">900</td>
                        <td class="cellNumber">1000 - 900</td>
                    </tr>
                    <tr class="numberRow">
                        <td>Transport</td>
                        <td class="cellNumber">1000</td>
                        <td class="cellNumber">900</td>
                        <td class="cellNumber">1000 - 900</td>
                    </tr>
                    <tr class="numberRow">
                        <td>Logement</td>
                        <td class="cellNumber">1000</td>
                        <td class="cellNumber">900</td>
                        <td class="cellNumber">1000 - 900</td>
                    </tr>
                    <tr class="numberRow">
                        <td>Solde fin</td>
                        <td class="cellNumber">1000</td>
                        <td class="cellNumber">900</td>
                        <td class="cellNumber">1000 - 900</td>
                    </tr>
                </table>
            </div>
        <?php } ?>
    </div>

    <?php include 'prevForm.php'; ?>
    <?php include 'realForm.php'; ?>
    <?php include 'csvForm.php'; ?>

</section>
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/budget_next.js"></script>
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/pop_up_real_prev.js"></script>
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/pop_up_csv.js"></script>
