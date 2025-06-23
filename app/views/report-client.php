<div class="report-container">
    <h2>Nouveau Rapport</h2>
    <?php if (isset($success) && $success): ?>
        <div class="alert alert-success" style="color: #155724; background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px;">
            Rapport envoyé avec succès !
        </div>
    <?php elseif (isset($error) && $error): ?>
        <div class="alert alert-danger" style="color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px;">
            Une erreur est survenue lors de l'envoi du rapport.
        </div>
    <?php endif; ?>
    
    <form class="report-form" action="submit-report" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" required class="form-control">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" required class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="attachments">Pièces jointes</label>
            <input type="file" id="attachments" name="attachments[]" multiple class="form-control-file" onchange="handleFiles(this.files)">
            <small class="form-text text-muted">Vous pouvez sélectionner plusieurs fichiers</small>
            <div id="preview-container" class="preview-container"></div>
        </div>

        <div class="form-actions">
            <!-- <button type="submit" class="btn-submit">Envoyer le rapport</button> -->
            <button type="button" class="btn-submit" onclick="showLoginPopup()">Envoyer le rapport</button>
            <button type="reset" class="btn-reset">Réinitialiser</button>
        </div>
    </form>
</div>

<div id="loginPopup" class="login-popup-overlay" style="display:none;">
    <div class="login-popup-content">
        <span class="close-login-popup" onclick="closeLoginPopup()">&times;</span>
        <?php
            // Inclure le contenu de login.php SANS <html>, <head>, <body>
            $base_url = Flight::get('flight.base_url');
        ?>
        <form action="client-login" method="POST">
            <fieldset>
                <h1>Veuillez vous connecter pour envoyer votre rapport</h1>
                <label for="nom">Nom : </label>
                <input type="text" name="nom" id="nom" placeholder="Ex: Marie">

                <label for="mdp">Mot de passe : </label>
                <input type="password" name="mdp" id="mdp" placeholder="************************">

                <button type="submit">Se connecter</button>
                <?php
                    if (isset($erreur)) { ?>
                        <div class="error">
                            <?= $erreur; ?>
                        </div>
                    <?php } ?>
            </fieldset>
        </form>
    </div>
</div>

<style>
.login-popup-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}
.login-popup-content {
    background: #fff;
    padding: 30px 40px;
    border-radius: 8px;
    min-width: 320px;
    position: relative;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 28vw;
}

.login-popup-content fieldset {
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
  padding: 10px;
  border: none;
}
.close-login-popup {
    position: absolute;
    top: 8px;
    right: 12px;
    font-size: 24px;
    cursor: pointer;
}
.login-popup-content input, .login-popup-content select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-top: 10px;
  margin-bottom: 10px;
}
.login-popup-content button {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-top: 10px;
  margin-bottom: 10px;
  background-color: #007bff;
  color: #fff;
  cursor: pointer;
}
.login-popup-content button:hover {
  background-color: #0056b3;
}/*# sourceMappingURL=loginEmp.css.map */
</style>

<script>
    function showLoginPopup() {
        document.getElementById('loginPopup').style.display = 'flex';
    }
    function closeLoginPopup() {
        document.getElementById('loginPopup').style.display = 'none';
    }

    function handleFiles(files) {
        const previewContainer = document.getElementById('preview-container');
        
        Array.from(files).forEach(file => {
            // Vérifier si le fichier existe déjà
            const existingFiles = previewContainer.querySelectorAll('.file-preview');
            let isDuplicate = false;
            
            existingFiles.forEach(existingFile => {
                if (existingFile.querySelector('.file-name').textContent === file.name) {
                    isDuplicate = true;
                }
            });

            if (!isDuplicate) {
                const preview = document.createElement('div');
                preview.className = 'file-preview';
                
                let fileIcon = 'fa-file';
                if (file.type.startsWith('image/')) fileIcon = 'fa-file-image';
                else if (file.type === 'application/pdf') fileIcon = 'fa-file-pdf';
                else if (file.type.includes('word')) fileIcon = 'fa-file-word';
                else if (file.type.includes('excel')) fileIcon = 'fa-file-excel';

                preview.innerHTML = `
                    <div>
                        <i class="fas ${fileIcon}"></i>
                        <span class="file-name">${file.name}</span>
                        <span class="file-size">(${(file.size / 1024).toFixed(2)} KB)</span>
                    </div>
                    <button type="button" class="remove-file" onclick="removeFile(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                previewContainer.appendChild(preview);
            }
        });
    }

    function removeFile(button) {
        const filePreview = button.parentElement;
        filePreview.remove();
    }
</script>
