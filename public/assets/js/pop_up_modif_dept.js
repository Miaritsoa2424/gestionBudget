document.addEventListener('DOMContentLoaded', function () {
    const formModif = document.querySelector('.modif-departement-container');
    const modifIdDept = document.getElementById('idDept');
    const modifNomDept = document.getElementById('nomDept');
    const modifMdp = document.getElementById('mdp'); // Si vous avez besoin de ce champ
    const editButtons = document.querySelectorAll('.edit-btn');
    const closePopupBtn = document.querySelector('.close-popup-btn');

    // Boutons "Modifier"
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Récupérer les données du département
            const idDept = this.getAttribute('data-id');
            const nomDept = this.getAttribute('data-nom');
            const mdp = this.getAttribute('data-mdp'); // Si vous avez besoin de ce champ

            // Pré-remplir le formulaire
            modifIdDept.value = idDept;
            modifNomDept.value = nomDept;
            modifMdp.value= mdp; // Si vous avez besoin de ce champ

            // Afficher le formulaire
            formModif.style.display = 'block';
        });
    });

    // Bouton pour fermer le formulaire (si nécessaire)
    document.addEventListener('click', function (event) {
        if (event.target.matches('.modif-departement-container') || event.target.matches('.close-form-btn')) {
            formModif.style.display = 'none';
        }
    });

    // Fermer le popup lorsque le bouton "X" est cliqué
    closePopupBtn.addEventListener('click', function () {
        formModif.style.display = 'none';
    });

    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('mdp');

    togglePasswordBtn.addEventListener('click', function () {
        // Basculer entre "password" et "text"
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Changer l'icône ou le texte du bouton
        this.textContent = type === 'password' ? '👁️' : '🙈';
    });
});