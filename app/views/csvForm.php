<div class="csvForm" id="csvForm">
        <form action="importer" method="POST" enctype="multipart/form-data">
            <fieldset>
                <h1>Importation d'un fichier CSV</h1>
               
                <label for="montantPrev">Fichier csv : </label>
                <input type="file" name="filePath" id="montantPrev" placeholder="Selectionner un fichier csv">

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