
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
                        <p><strong>Téléphone:</strong> <?php echo $client['telephone']; ?></p>
                        <p><strong>Date d'inscription:</strong> <?php echo $client['date_inscription']; ?></p>
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
            <!-- Filtres en haut -->
            <form method="GET" class="mb-4">
                <div class="grid">
                    <div class="form-group">
                        <label>Date début</label>
                        <input type="date" name="date_debut" class="form-control" value="<?php echo $_GET['date_debut'] ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Date fin</label>
                        <input type="date" name="date_fin" class="form-control" value="<?php echo $_GET['date_fin'] ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Statut</label>
                        <select name="statut" class="form-control">
                            <option value="">Tous</option>
                            <option value="en_cours">En cours</option>
                            <option value="valide">Validé</option>
                            <option value="refuse">Refusé</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>

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
                        <tr>
                            <td><?php echo $report['date']; ?></td>
                            <td><?php echo $report['message']; ?></td>
                            <td>
                                <span class="badge badge-<?php echo getStatusClass($report['statut']); ?>">
                                    <?php echo $report['statut']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="detail-report/<?= 1 ?>" class="btn btn-sm btn-info">Voir</a>
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
