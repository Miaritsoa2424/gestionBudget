<!-- filepath: c:\xampp\htdocs\gestionBudget\app\views\departement.php -->
<div class="departement-container">
    <h1>Liste des Départements</h1>
    <table class="departement-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($depts as $dept) { ?>
                <tr>
                    <td><?= htmlspecialchars($dept->getIdDept()) ?></td>
                    <td><?= htmlspecialchars($dept->getNomDept()) ?></td>
                    <td>
                        <!-- Bouton Modifier -->
                        <button 
                            class="edit-btn" 
                            data-id="<?= $dept->getIdDept() ?>" 
                            data-nom="<?= htmlspecialchars($dept->getNomDept()) ?> "
                            data-mdp="<?= htmlspecialchars($dept->getMdp()) ?>">
                            Modifier
                        </button>
                        <!-- Bouton Supprimer -->
                        <button 
                            class="delete-btn" 
                            data-id="<?= $dept->getIdDept() ?>" 
                            data-url="<?= Flight::get('flight.base_url') ?>/departement/supprimer/<?= $dept->getIdDept() ?>">
                            Supprimer
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'formModifDepartement.php'; ?>

<script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/pop_up_modif_dept.js"></script>
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/pop_up_suppr_dept.js"></script>