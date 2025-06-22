<div class="report-container">
    <h2>Nouveau Rapport</h2>
    
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
            <button type="submit" class="btn-submit">Envoyer le rapport</button>
            <button type="reset" class="btn-reset">Réinitialiser</button>
        </div>
    </form>
</div>

<script>
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
