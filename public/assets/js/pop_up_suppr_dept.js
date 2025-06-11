document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            // Récupérer l'URL de suppression
            const deleteUrl = this.getAttribute('data-url');

            // Afficher une boîte de confirmation
            const confirmDelete = confirm('Êtes-vous sûr de vouloir supprimer ce département ?');

            if (confirmDelete) {
                // Rediriger vers l'URL de suppression
                window.location.href = deleteUrl;
            }
        });
    });
});