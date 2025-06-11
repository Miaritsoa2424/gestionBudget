<div class="ticketForm" id="ticketForm">
    <!-- Bouton de fermeture -->
    <button type="button" id="closeTicketForm"><a href="ticket">&times;</a></button>

    <form action="insertTicket" method="POST">
        <fieldset>
            <h1>Création d’un Ticket</h1>

            <label for="demande">Demande</label>
            <select name="idDemande" id="demande">
                <?php foreach ($demandes as $demande) { ?>
                    <option value="<?= $demande->getIdDemande() ?>"><?= $demande->getSujet() ?></option>
                <?php } ?>
            </select>

            <label for="importance">Importance</label>
            <select name="idImportance" id="importance">
                <?php foreach ($importances as $importance) { ?>
                    <option value="<?= $importance->getIdImportance() ?>"><?= $importance->getNom() ?></option>
                <?php } ?>
            </select>

            <label for="typeDemande">Type de Demande</label>
            <select name="idTypeDemande" id="typeDemande">
                <?php foreach ($typeDemandes as $type) { ?>
                    <option value="<?= $type->getIdTypeDemande() ?>"><?= $type->getNom() ?></option>
                <?php } ?>
            </select>

            <label for="etat">Etat</label>
            <select name="idEtat" id="etat">
                <?php foreach ($etats as $etat) { ?>
                    <option value="<?= $etat->getIdEtat() ?>"><?= $etat->getNom() ?></option>
                <?php } ?>
            </select>

            <label for="dept">Département</label>
            <select name="idDept" id="dept">
                <?php foreach ($departements as $dept) { ?>
                    <option value="<?= $dept->getIdDept() ?>"><?= $dept->getNomDept() ?></option>
                <?php } ?>
            </select>

            <label for="dateDebut">Date de début</label>
            <input type="date" name="dateDebut" id="dateDebut" required>

            <label for="dateFin">Date de fin (optionnelle)</label>
            <input type="date" name="dateFin" id="dateFin">

            <button type="submit">Créer le Ticket</button>

            <?php if (isset($erreur)) { ?>
                <div class="error">
                    <?= $erreur; ?>
                </div>
            <?php } ?>
        </fieldset>
    </form>
</div>

