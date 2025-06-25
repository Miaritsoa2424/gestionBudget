<div class="client-detail">
    <div class="card">
        <div class="card-header">
            <h3>Détails du client</h3>
        </div>
        <div class="card-body">
            <div class="client-info-container">
                <div class="photo-container">
                    <img src="https://placehold.co/200x250/CCCCCC/000000/png?text=Portrait+Test" alt="Photo de <?php echo $client['nom']; ?>" class="client-photo">
                </div>
                <div class="grid">
                    <div>
                        <p><strong>Nom:</strong> <?php echo $client['nom']; ?></p>
                        <p><strong>Email:</strong> <?php echo $client['email']; ?></p>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Reports du client</h4>
        </div>
        <div class="card-body">
                <div class="grid">
                    <div class="form-group">
                        <label>Date début</label>
                        <input type="date" name="date_debut" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Date fin</label>
                        <input type="date" name="date_fin" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Statut</label>
                        <select name="statut" class="form-control">
                            <option value="">Tous</option>
                            <?php foreach($statuts as $statut): ?>
                                <option value="<?php echo $statut['id']; ?>"><?php echo ucfirst($statut['libelle']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            <!-- Tableau des reports -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Message</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($client['reports'] as $report): ?>
                        <tr data-idstatut="<?php echo $report['idStatut']; ?>">
                            <td><?php echo $report['date']; ?></td>
                            <td><?php echo $report['message']; ?></td>
                            <td>
                                <span class="badge badge-<?php echo getStatusClass($report['idStatut']); ?>">
                                    <?php echo $report['statut']; ?>
                                </span>
                            </td>
                            <td>

                                <a href="<?= Flight::get('flight.base_url') ?>/detail-report/<?= $report['id']?>" class="btn btn-sm btn-info">Voir</a>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
function getStatusClass($status) {
    switch($status) {
        case 'en_cours': return 'warning';
        case 'valide': return 'success';
        case 'refuse': return 'danger';
        default: return 'secondary';
    }
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateDebut = document.querySelector('input[name="date_debut"]');
    const dateFin = document.querySelector('input[name="date_fin"]');
    const statut = document.querySelector('select[name="statut"]');
    const rows = document.querySelectorAll('.table tbody tr');

    function filterRows() {
        const dDeb = dateDebut.value;
        const dFin = dateFin.value;
        const stat = statut.value;

        rows.forEach(row => {
            const date = row.children[0].textContent.trim();
            const idStatut = row.getAttribute('data-idstatut');
            let show = true;

            // Filtre date début
            if (dDeb && date < dDeb) show = false;
            // Filtre date fin
            if (dFin && date > dFin) show = false;
            // Filtre statut (par ID)
            if (stat && idStatut !== stat) show = false;

            row.style.display = show ? '' : 'none';
        });
    }

    dateDebut.addEventListener('change', filterRows);
    dateFin.addEventListener('change', filterRows);
    statut.addEventListener('change', filterRows);
});
</script>
