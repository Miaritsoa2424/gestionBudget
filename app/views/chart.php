<div class="container mt-4">
        <h1 class="mb-4">Statistiques des Ventes</h1>
        
        <div class="row mb-4">
            <div class="col-md-6">
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
        </div>
        
        <div class="row">
            <div class="col-md-12">
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
                                    <td><?= number_format($customer['total_achats'], 2) ?> €</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
<!-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard des Ventes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
            margin-bottom: 30px;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Statistiques des Ventes</h1>
        
        <div class="row mb-4">
            <div class="col-md-6">
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
        </div>
        
        <div class="row">
            <div class="col-md-12">
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
                                    <td><?= number_format($customer['total_achats'], 2) ?> €</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
</body>
</html> -->