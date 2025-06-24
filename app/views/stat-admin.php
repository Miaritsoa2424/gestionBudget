<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        /* * { margin: 0; padding: 0; box-sizing: border-box; } */
        /* body { font-family: Arial, sans-serif; padding: 20px; } */
        .dashboard-container { max-width: 1200px; margin: 0 auto; }
        .dashboard-title { margin: 10px 0; }
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 20px;
            height: 90vh;
            margin-top: 20px;
        }
        .card { 
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-header { 
            padding: 15px;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }
        .card-body { 
            padding: 15px;
            flex: 1;
            overflow: auto;
        }
        table { 
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #ddd;
        }
        th, td { 
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f8f8f8;
            border-bottom: 2px solid #ddd;
        }
        .budget-info h5 { margin: 10px 0; }
        .budget-chart-container {
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2 class="dashboard-title">Dashboard Administrateur</h2>
    
    <div class="dashboard-grid">
        <!-- Top 5 Clients -->
        <div class="card">
            <div class="card-header">
                <h4>Top 5 Clients - Nombre de Tickets</h4>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Nombre de tickets</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                        <tr><td>Client A</td><td>45</td></tr>
                        <tr><td>Client B</td><td>38</td></tr>
                        <tr><td>Client C</td><td>32</td></tr>
                        <tr><td>Client D</td><td>28</td></tr>
                        <tr><td>Client E</td><td>25</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Temps traitement -->
        <div class="card">
            <div class="card-header">
                <h4>Temps de traitement moyen par catégorie</h4>
            </div>
            <div class="card-body">
                <canvas id="timeByCategory"></canvas>
            </div>
        </div>

        <!-- Satisfaction -->
        <div class="card">
            <div class="card-header">
                <h4>Satisfaction client par agent</h4>
            </div>
            <div class="card-body">
                <canvas id="satisfactionByAgent"></canvas>
            </div>
        </div>

        <!-- Budget -->
        <div class="card">
            <div class="card-header">
                <h4>Budget Prévisionnel</h4>
            </div>
            <div class="card-body">
                <div class="budget-info">
                    <h5>Budget total: 50 000.00 €</h5>
                    <h5>Dépenses: 32 450.00 €</h5>
                    <h5>Reste: 17 550.00 €</h5>
                </div>
                <div class="budget-chart-container">
                    <canvas id="budgetChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Données statiques pour les graphiques
const timeData = {
    categories: ['Bug', 'Feature', 'Support', 'Maintenance', 'Urgence'],
    times: [24, 48, 12, 36, 8]
};

const satisfactionData = {
    agents: ['Agent 1', 'Agent 2', 'Agent 3', 'Agent 4'],
    ratings: [4.5, 4.2, 4.8, 4.1]
};

// Graphique temps par catégorie
new Chart(document.getElementById('timeByCategory'), {
    type: 'line',
    data: {
        labels: timeData.categories,
        datasets: [{
            label: 'Temps moyen (heures)',
            data: timeData.times,
            borderColor: 'rgb(75, 192, 192)'
        }]
    }
});

// Graphique satisfaction par agent
new Chart(document.getElementById('satisfactionByAgent'), {
    type: 'bar',
    data: {
        labels: satisfactionData.agents,
        datasets: [{
            label: 'Satisfaction moyenne',
            data: satisfactionData.ratings,
            backgroundColor: 'rgb(54, 162, 235)'
        }]
    }
});

// Graphique budget
new Chart(document.getElementById('budgetChart'), {
    type: 'doughnut',
    data: {
        labels: ['Dépensé', 'Reste'],
        datasets: [{
            data: [32450, 17550],
            backgroundColor: ['#ff6384', '#36a2eb']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

</body>
</html>
