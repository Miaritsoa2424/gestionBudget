<div class="realForm" id="realForm">
        <form action="doLogin" method="POST">
            <fieldset>
                <h1>Ajout de realisation</h1>

                <label for="budget">Type</label>
                    <select name="" id="">
                        <option value="">Achat de materiel de bureau</option>
                        <option value="">Vente de sable</option>
                    </select>

                <input type="hidden" name="prevReal" value="1">

                <label for="natureReal">Nature : </label>
                <input type="text" name="nature" id="natureReal" placeholder="Ex: Ordinateur Asus Vivobook">

                <label for="montantReal">Montant : </label>
                <input type="text" name="montant" id="montantReal" placeholder="Ex: 1000000">

                <button type="submit">Ajouter</button>
                <button id="closePopUpReal" type="reset">Quitter</button>
                <?php
                    if (isset($erreur)) { ?>
                        <div class="error">
                            <?= $erreur; ?>
                        </div>
                    <?php } ?>
            </fieldset>
        </form>
    </div>