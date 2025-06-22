<!-- Modal d'ajout de client -->
<div id="addClientModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ajouter un nouveau client</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addClientForm">
                <div class="form-group">
                    <label for="clientName">Nom du client</label>
                    <input type="text" id="clientName" required>
                </div>
                <div class="form-group">
                    <label for="clientEmail">Email</label>
                    <input type="email" id="clientEmail" required>
                </div>
                <div class="form-group">
                    <label for="clientPhone">Téléphone</label>
                    <input type="tel" id="clientPhone" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
