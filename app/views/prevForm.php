<div class="prevForm" id="prevForm">
        <form action="doLogin" method="POST">
            <fieldset>
                <h1>Ajout de prevision</h1>
                <label for="budget">Type</label>
                    <select name="" id="">
                        <option value="">Achat de materiel de bureau</option>
                        <option value="">Vente de sable</option>
                    </select>

                <input type="hidden" name="prevPrev" value="1">

                <label for="naturePrev">Nature : </label>
                <input type="text" name="nature" id="naturePrev" placeholder="Ex: Ordinateur Asus Vivobook">

                <label for="montantPrev">Montant : </label>
                <input type="text" name="montant" id="montantPrev" placeholder="Ex: 1000000">

                <button type="submit">Ajouter</button>
                <button id="closePopUpPrev" type="reset">Quitter</button>
                
                <?php
                    if (isset($erreur)) { ?>
                        <div class="error">
                            <?= $erreur; ?>
                        </div>
                        <?php } ?>
                    </fieldset>
                </form>
    </div>