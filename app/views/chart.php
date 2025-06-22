<div class="container mt-4">
    <h1 class="mb-4">Statistiques des Ventes</h1>

    <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-success text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Chiffre d'affaires Total - <?= $year ?></h4>
                        <h3 class="mb-0"> <?= number_format($chiffreAffaire, 2, '.', ' ') ?> MGA</h3>

                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Ventes par Mois - <?= $year ?>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <form class="form-inline">
                            <div class="input-group">
                                <label class="input-group-text" for="yearSelect">Année:</label>
                                <select class="form-select" id="yearSelect" onchange="changeYear(this.value)">
                                    <?php
                                    $currentYear = date('Y');
                                    for ($i = $currentYear - 5; $i <= $currentYear; $i++) {
                                        $selected = ($i == $year) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Meilleurs Produits
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité Vendue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bestProducts as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['nomProduit']) ?></td>
                                    <td><?= $product['total_vendu'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- <div class="row"> -->
            <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Meilleurs Clients
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Total des Achats</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topCustomers as $customer): ?>
                                <tr>
                                    <td><?= htmlspecialchars($customer['nomClient']) ?></td>
                                    <td><?= number_format($customer['total_achats'], 2, '.', ' ') ?> MGA</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>

<script>
    // Données pour le graphique
    const months = <?= $months ?>;
    const salesData = <?= $sales ?>;

    // Création du graphique
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Quantité Vendue',
                data: salesData,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Quantité Vendue'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mois'
                    }
                }
            }
        }
    });

    // Fonction pour changer l'année
    function changeYear(year) {
        window.location.href = '?year=' + year;
    }
</script>