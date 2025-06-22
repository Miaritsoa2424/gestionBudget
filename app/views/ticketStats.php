<div class="container mt-4">
    <h2 class="mb-4">📊 Statistiques des tickets</h2>
    <div class="row">
        <!-- Formulaire de filtres -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Filtres
                </div>
                <div class="card-body">
                    <form id="filterForm">
                        <div class="mb-3">
                            <label for="dept" class="form-label">D&eacute;partement</label>
                            <select class="form-select" id="dept" name="dept">
                                <option value="">S&eacute;lectionner un d&eacute;partement</option>
                                <?php foreach ($departements as $dept) { ?>
                                    <option value="<?= $dept['idDept'] ?>"><?= htmlspecialchars($dept['nomDept']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createur" class="form-label">Cr&eacute;&eacute; par</label>
                            <input type="text" class="form-control" id="createur" value="Admin" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="etat" class="form-label">&Eacute;tat</label>
                            <select class="form-select" name="etat" id="etat">
                                <option value="">Tous</option>
                                <?php foreach ($etats as $etat) { ?>
                                    <option value="<?= htmlspecialchars($etat['idEtat']) ?>"><?= htmlspecialchars($etat['nom']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="annee" class="form-label">Ann&eacute;e</label>
                            <select class="form-select" name="annee" id="annee">
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025" selected>2025</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Rafraîchir</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Graphique -->
        <div class="col-md-8 mt-4 mt-md-0">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Nombre de tickets par mois
                </div>
                <div class="card-body">
                    <canvas id="ticketChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let chart;

    function loadChart(data) {
        const ctx = document.getElementById('ticketChart').getContext('2d');
        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
            labels: data.mois,
            datasets: [{
                label: 'Nombre de tickets',
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                data: data.valeurs
            }]
            }
        });
    }

    function fetchStats() {
        const form = $('#filterForm').serialize();
        $.get('ticketStats/data', form, function (data) {
            loadChart(data);
        });
    }

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        fetchStats();
    });

    $(document).ready(() => {
        fetchStats(); // chargement initial
    });
</script>
