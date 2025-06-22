<!-- filepath: c:\xampp\htdocs\gestionBudget\app\views\formModifDepartement.php -->
<div class="modif-departement-container">
    <button class="close-popup-btn" aria-label="Fermer">&times;</button>

    <h1>Modifier un Département</h1>
    <form action="<?= Flight::get('flight.base_url') ?>/departement/modifier" method="POST" class="modif-departement-form">
        <!-- Champ caché pour l'ID du département -->
        <input type="hidden" id="idDept" name="idDept" value="">

        <label for="nomDept">Nom du Département :</label>
        <input type="text" id="nomDept" name="nomDept" value="" required>

        <label for="mdp">Mot de Passe :</label>
        <div class="password-container">
            <input type="password" id="mdp" name="mdp" placeholder="Laisser vide pour ne pas modifier">
            <button type="button" id="togglePassword" class="toggle-password-btn" aria-label="Afficher/Masquer le mot de passe">
                👁️
            </button>
        </div>

        <button type="submit" class="modif-departement-submit-btn">Modifier</button>
    </form>
</div>