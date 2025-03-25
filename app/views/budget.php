<div class="navigationTable">
    <h1>Fiche Budgétaire
        <i class="fas fa-wallet"></i>
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
        <button type="submit">Valider</button>
        <button class="pdf-btn"><i class="fas fa-file-pdf"></i> Exporter en PDF</button>
    </div>
</div>
<section class="budgetSection">

    <?php for ($i=0; $i < 3; $i++) { ?>
        <h2>10/01/2025</h2>
        <table>
        <tr>
            <th rowspan="2">Rubrique</th>
            <th colspan="3">P1</th>
            <th colspan="3">P2</th>
            <th colspan="3">P3</th>

        </tr>
        <tr>
            <th>Prev</th>
            <th>Real</th>
            <th>Écart</th>
            <th>Prev</th>
            <th>Real</th>
            <th>Écart</th>
            <th>Prev</th>
            <th>Real</th>
            <th>Écart</th>
        </tr>

        <?php
        $rubriques = [
            ['nom' => 'Solde debut'],
            ['nom' => 'Alimentation'],
            ['nom' => 'Transport'],
            ['nom' => 'Logement'],
            ['nom' => 'Solde fin'],

        ];

        foreach ($rubriques as $rubrique) {
            $prevP1 = 1000;
            $realP1 = 900;
            $ecartP1 = $prevP1 - $realP1;

            $prevP2 = 1200;
            $realP2 = 1100;
            $ecartP2 = $prevP2 - $realP2;
            
            $prevP3 = 1200;
            $realP3 = 1100;
            $ecartP3 = $prevP3 - $realP3;


            echo "<tr class='numberRow'>
        <td>{$rubrique['nom']}</td>
        <td class='cellNumber'>$prevP1</td>
        <td class='cellNumber' >$realP1</td>
        <td class='cellNumber' >$ecartP1</td>
        <td class='cellNumber' >$prevP2</td>
        <td class='cellNumber' >$realP2</td>
        <td class='cellNumber' >$ecartP2</td>
        <td class='cellNumber' >$prevP3</td>
        <td class='cellNumber' >$realP3</td>
        <td class='cellNumber' >$ecartP3</td>
    </tr>";
        }
        ?>
    </table>
    <?php } ?>

</section>