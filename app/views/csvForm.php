<div class="csvForm" id="csvForm">
        <form action="doLogin" method="POST">
            <fieldset>
                <h1>Importation d'un fichier CSV</h1>
               
                <label for="montantPrev">Fichier csv : </label>
                <input type="file" name="montant" id="montantPrev" placeholder="Selectionner un fichier csv">

                <button type="submit">Importer</button>
                <button id="closePopUpCsv" type="reset">Quitter</button>
                
                <?php
                    if (isset($erreur)) { ?>
                        <div class="error">
                            <?= $erreur; ?>
                        </div>
                        <?php } ?>
                    </fieldset>
                </form>
    </div>