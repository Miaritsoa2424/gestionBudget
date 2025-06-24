<!-- Modal d'ajout de client -->
<div id="addClientModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ajouter un nouveau client</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addClientForm" action="<?php echo Flight::get('flight.base_url'); ?>/ajouterClient" method="post">
                <div class="form-group">
                    <label for="clientName">Nom du client</label>
                    <input type="text" id="clientName" name="clientName" required>
                </div>
                <div class="form-group">
                    <label for="clientPhone">Prenom</label>
                    <input type="text" id="clientPhone" name="clientPhone" required>
                </div>
                <div class="form-group">
                    <label for="clientEmail">Email</label>
                    <input type="email" id="clientEmail" name="clientEmail" required>
                </div>
                <div class="form-group">
                    <label for="clientPassword">Mot de passe</label>
                    <input type="password" id="clientPassword" name="clientPassword" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
