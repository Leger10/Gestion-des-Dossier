<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme de Gestion du Personnel - DGTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --dgt-red: #c62828;
            --dgt-blue: hsl(212, 72%, 43%);
            --dgt-dark: #2c3e50;
            --dgt-light: #f8f9fa;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 100px;
        }

        .dgt-header {
            background: linear-gradient(135deg, var(--dgt-blue) 0%, var(--dgt-dark) 100%);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .dgt-logo {
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .dgt-logo i {
            font-size: 2.5rem;
            color: var(--dgt-blue);
        }

        .dgt-title {
            font-weight: 900;
            text-transform: uppercase;
            color: white;
            text-shadow:
                0 1px 0 rgba(0, 0, 0, 0.1),
                0 2px 0 rgba(0, 0, 0, 0.1),
                0 3px 0 rgba(0, 0, 0, 0.1),
                0 4px 0 rgba(0, 0, 0, 0.1),
                0 5px 0 rgba(0, 0, 0, 0.1),
                0 6px 1px rgba(0, 0, 0, 0.1),
                0 0 5px rgba(0, 0, 0, 0.1),
                0 1px 3px rgba(0, 0, 0, 0.3),
                0 3px 5px rgba(0, 0, 0, 0.2),
                0 5px 10px rgba(0, 0, 0, 0.25),
                0 10px 10px rgba(0, 0, 0, 0.2),
                0 20px 20px rgba(0, 0, 0, 0.15);
            animation: float 3s ease-in-out infinite;
            transform: perspective(500px) rotateX(15deg);
            letter-spacing: 2px;
            font-size: 2.2rem;
        }

        @keyframes float {

            0%,
            100% {
                transform: perspective(500px) rotateX(15deg) translateY(0);
            }

            50% {
                transform: perspective(500px) rotateX(15deg) translateY(-10px);
            }
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
            border: none;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card-header {
            background: var(--dgt-blue);
            color: white;
            padding: 1rem;
            font-weight: 600;
            text-align: center;
        }

        .stat-card-body {
            padding: 1.5rem;
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0.5rem 0;
            color: var(--dgt-blue);
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .gender-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 1rem;
        }

        .gender-stat {
            text-align: center;
        }

        .gender-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .male-icon {
            color: #1976d2;
        }

        .female-icon {
            color: #d81b60;
        }

        .gender-count {
            font-weight: 600;
            font-size: 1.2rem;
        }

        .gender-label {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .table-title {
            color: var(--dgt-blue);
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--dgt-blue);
            display: flex;
            align-items: center;
        }

        .table-title i {
            margin-right: 10px;
        }

        .stats-table {
            width: 100%;
            margin-bottom: 0;
        }

        .stats-table th {
            background-color: var(--dgt-blue);
            color: white;
            font-weight: 600;
        }

        .stats-table td,
        .stats-table th {
            text-align: center;
            vertical-align: middle;
            padding: 12px 15px;
        }

        .stats-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .stats-table .table-total {
            background-color: #e3f2fd;
            font-weight: 700;
        }

        .chart-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
            height: 100%;
        }

        .footer {
            background: var(--dgt-dark);
            color: white;
            padding: 1.5rem 0;
            text-align: center;
            position: relative;
            margin-top: 2rem;
            width: 100%;
        }

        .copyright {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .refresh-btn {
            background: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            transform: rotate(360deg);
            background: var(--dgt-blue);
            color: white;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: var(--dgt-blue);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .error-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #ff6b6b;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-width: 400px;
            display: none;
        }

        .close-error {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .dgt-title {
                font-size: 1.8rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .stats-table td,
            .stats-table th {
                padding: 8px 10px;
                font-size: 0.9rem;
            }

            .error-message {
                left: 10px;
                right: 10px;
                top: 70px;
                max-width: none;
            }
        }
    </style>
</head>

<body>

    <!-- Overlay de chargement -->
    <div class="loading-overlay">
        <div class="spinner"></div>
        <p class="mt-3">Chargement des données en cours...</p>
    </div>

    <!-- Message d'erreur -->
    <div class="error-message">
        <span class="close-error">&times;</span>
        <div id="error-content"></div>
    </div>

    <div class="dgt-header">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo à gauche -->
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <div class="dgt-logo">
                        <i class="fas fa-users-cog"></i>
                    </div>
                </div>

                <!-- Titre au centre -->
                <div class="col-md-8 text-center">
                    <h1 class="dgt-title mb-2">Plateforme de Gestion du Personnel</h1>
                    <h4 class="text-light">Direction Générale des Transmissions et de l'Informatique</h4>
                </div>

                <!-- Boutons à droite -->
                <div class="col-md-2 text-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <!-- Bouton de rafraîchissement -->
                        <button class="btn btn-sm btn-light me-2 refresh-btn" id="refreshData"
                            title="Rafraîchir les données">
                            <i class="fas fa-sync-alt"></i>
                        </button>

                        <!-- Menu de connexion/déconnexion -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="{{ route('login') }}" title="Connexion">
                                    <i class="fa fa-sign-in-alt"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Statistiques générales -->
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <i class="fas fa-building me-2"></i> Statistiques des Directions
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-number" id="total-directions">0</div>
                        <div class="stat-label">Agents dans les directions</div>
                        <div class="gender-stats">
                            <div class="gender-stat">
                                <div class="gender-icon male-icon">
                                    <i class="fas fa-mars"></i>
                                </div>
                                <div class="gender-count" id="hommes-directions">0</div>
                                <div class="gender-label">Hommes</div>
                            </div>
                            <div class="gender-stat">
                                <div class="gender-icon female-icon">
                                    <i class="fas fa-venus"></i>
                                </div>
                                <div class="gender-count" id="femmes-directions">0</div>
                                <div class="gender-label">Femmes</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <i class="fas fa-network-wired me-2"></i> Statistiques des Services
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-number" id="total-services">0</div>
                        <div class="stat-label">Agents dans les services</div>
                        <div class="gender-stats">
                            <div class="gender-stat">
                                <div class="gender-icon male-icon">
                                    <i class="fas fa-mars"></i>
                                </div>
                                <div class="gender-count" id="hommes-services">0</div>
                                <div class="gender-label">Hommes</div>
                            </div>
                            <div class="gender-stat">
                                <div class="gender-icon female-icon">
                                    <i class="fas fa-venus"></i>
                                </div>
                                <div class="gender-count" id="femmes-services">0</div>
                                <div class="gender-label">Femmes</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques par catégorie -->
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="table-container">
                    <h3 class="table-title"><i class="fas fa-building me-2"></i> Catégories - Directions</h3>
                    <table class="table table-striped stats-table">
                        <thead>
                            <tr>
                                <th>Catégorie</th>
                                <th>Hommes</th>
                                <th>Femmes</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="categorie-directions-body">
                            <tr>
                                <td colspan="4">Chargement des données...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="table-container">
                    <h3 class="table-title"><i class="fas fa-network-wired me-2"></i> Catégories - Services</h3>
                    <table class="table table-striped stats-table">
                        <thead>
                            <tr>
                                <th>Catégorie</th>
                                <th>Hommes</th>
                                <th>Femmes</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="categorie-services-body">
                            <tr>
                                <td colspan="4">Chargement des données...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Détail par direction -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="table-container">
                    <h3 class="table-title"><i class="fas fa-chart-bar me-2"></i> Répartition par Direction</h3>
                    <table class="table table-striped stats-table">
                        <thead>
                            <tr>
                                <th>Direction</th>
                                <th>Hommes</th>
                                <th>Femmes</th>
                                <th>Total</th>
                                <th>% Hommes</th>
                                <th>% Femmes</th>
                            </tr>
                        </thead>
                        <tbody id="repartition-body">
                            <tr>
                                <td colspan="6">Chargement des données...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Visualisation graphique -->
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="chart-container">
                    <h3 class="table-title"><i class="fas fa-chart-pie me-2"></i> Répartition par Genre</h3>
                    <canvas id="genreChart"></canvas>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="chart-container">
                    <h3 class="table-title"><i class="fas fa-chart-bar me-2"></i> Agents par Direction</h3>
                    <canvas id="directionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-md-start mb-3 mb-md-0">
                    <h5>Direction Générale des Transmissions et de l'Informatique</h5>
                    <p class="mb-0">Ministère de la sécurité</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="copyright mb-0">© 2025 Plateforme de Gestion du Personnel DGTI</p>
                    <p class="mb-0">Version 2.0</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Éléments du DOM
        const refreshBtn = document.getElementById('refreshData');
        const errorMessage = document.querySelector('.error-message');
        const errorContent = document.getElementById('error-content');
        const closeError = document.querySelector('.close-error');
        const loadingOverlay = document.querySelector('.loading-overlay');
        
        // Initialisation des graphiques
        let genreChart = null;
        let directionChart = null;
        
        // Fonction pour afficher/masquer le chargement
        function showLoading(show) {
            loadingOverlay.style.display = show ? 'flex' : 'none';
        }
        
        // Fonction pour afficher les erreurs
        function showError(message) {
            errorContent.innerHTML = message;
            errorMessage.style.display = 'block';
            
            // Masquer automatiquement après 10 secondes
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 10000);
        }
        
        // Fermer le message d'erreur
        closeError.addEventListener('click', () => {
            errorMessage.style.display = 'none';
        });
        
        // Fonction pour simuler les données de démonstration
        function getDemoData() {
            return {
                success: true,
                directions: {
                    total: 23,
                    hommes: 18,
                    femmes: 6,
                    categories: {
                        homme: {
                            'I': 5,
                            'II': 4,
                            'III': 12,
                            'Néant': 0
                        },
                        femme: {
                            'I': 0,
                            'II': 1,
                            'III':5,
                            'Néant': 0
                        }
                    }
                },
                services: {
                    total: 70,
                    hommes: 61,
                    femmes:9,
                    categories: {
                        homme: {
                            'I': 0,
                            'II': 12,
                            'III': 57,
                            'Néant': 0
                        },
                        femme: {
                            'I':0,
                            'II':0,
                            'III': 8,
                            'Néant': 0
                        }
                    }
                },
                repartition: [
                    { nom: "DGTI", hommes:11, femmes: 2 },
                    { nom: "DSI", hommes: 14, femmes: 0},
                    { nom: "DT", hommes: 28, femmes: 6 },
                    { nom: "DASP", hommes:9, femmes: 1 },
                    { nom: "DSEF", hommes: 11, femmes: 2 },
                    { nom: "DIG", hommes:7, femmes: 2 }
                ]
            };
        }
        
        // Fonction pour récupérer les données depuis le serveur
        async function fetchData() {
            try {
                showLoading(true);
                
                // Utiliser des données de démonstration pour simuler une réponse
                const demoData = getDemoData();
                
                // Simuler un délai réseau
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Masquer l'overlay de chargement
                showLoading(false);
                
                // Mettre à jour le tableau de bord
                updateDashboard(demoData);
            } catch (error) {
                console.error('Erreur complète:', error);
                showLoading(false);
                showError(`Erreur: ${error.message}`);
                
                // Réessayer après 10 secondes
                setTimeout(fetchData, 10000);
            }
        }

        // Fonction pour mettre à jour le tableau de bord avec de nouvelles données
        function updateDashboard(data) {
            // Mise à jour des cartes statistiques
            document.getElementById('total-directions').textContent = formatNumber(data.directions.total);
            document.getElementById('hommes-directions').textContent = formatNumber(data.directions.hommes);
            document.getElementById('femmes-directions').textContent = formatNumber(data.directions.femmes);
            
            document.getElementById('total-services').textContent = formatNumber(data.services.total);
            document.getElementById('hommes-services').textContent = formatNumber(data.services.hommes);
            document.getElementById('femmes-services').textContent = formatNumber(data.services.femmes);
            
            // Mise à jour des tableaux de catégories
            populateCategoryTable('categorie-directions-body', data.directions.categories);
            populateCategoryTable('categorie-services-body', data.services.categories);
            
            // Mise à jour de la répartition par direction
            updateRepartitionTable(data.repartition);
            
            // Mise à jour des graphiques
            updateCharts(data);
        }
        
        // Fonction pour mettre à jour le tableau de répartition
        function updateRepartitionTable(repartition) {
            const repartitionBody = document.getElementById('repartition-body');
            repartitionBody.innerHTML = '';
            
            let totalHommesRepartition = 0;
            let totalFemmesRepartition = 0;
            
            repartition.forEach(dir => {
                const total = dir.hommes + dir.femmes;
                const percentHommes = calculatePercentage(dir.hommes, total);
                const percentFemmes = calculatePercentage(dir.femmes, total);
                
                totalHommesRepartition += dir.hommes;
                totalFemmesRepartition += dir.femmes;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><strong>${dir.nom}</strong></td>
                    <td>${formatNumber(dir.hommes)}</td>
                    <td>${formatNumber(dir.femmes)}</td>
                    <td>${formatNumber(total)}</td>
                    <td>${percentHommes}%</td>
                    <td>${percentFemmes}%</td>
                `;
                repartitionBody.appendChild(row);
            });
            
            // Ajouter la ligne de total
            const totalRepartition = totalHommesRepartition + totalFemmesRepartition;
            const totalPercentHommes = calculatePercentage(totalHommesRepartition, totalRepartition);
            const totalPercentFemmes = calculatePercentage(totalFemmesRepartition, totalRepartition);
            
            const totalRow = document.createElement('tr');
            totalRow.className = 'table-total';
            totalRow.innerHTML = `
                <td><strong>Total</strong></td>
                <td>${formatNumber(totalHommesRepartition)}</td>
                <td>${formatNumber(totalFemmesRepartition)}</td>
                <td>${formatNumber(totalRepartition)}</td>
                <td>${totalPercentHommes}%</td>
                <td>${totalPercentFemmes}%</td>
            `;
            repartitionBody.appendChild(totalRow);
        }
        
        // Fonction pour peupler les tableaux de catégories
        function populateCategoryTable(tableId, categories) {
            const tableBody = document.getElementById(tableId);
            tableBody.innerHTML = '';
            
            const categoriesList = ['I', 'II', 'III', 'Néant'];
            let totalHommes = 0;
            let totalFemmes = 0;
            
            categoriesList.forEach(cat => {
                const hommes = categories.homme[cat] || 0;
                const femmes = categories.femme[cat] || 0;
                const total = hommes + femmes;
                
                totalHommes += hommes;
                totalFemmes += femmes;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><strong>Catégorie ${cat}</strong></td>
                    <td>${formatNumber(hommes)}</td>
                    <td>${formatNumber(femmes)}</td>
                    <td>${formatNumber(total)}</td>
                `;
                tableBody.appendChild(row);
            });
            
            // Ajouter la ligne de total
            const totalRow = document.createElement('tr');
            totalRow.className = 'table-total';
            totalRow.innerHTML = `
                <td><strong>Total</strong></td>
                <td>${formatNumber(totalHommes)}</td>
                <td>${formatNumber(totalFemmes)}</td>
                <td>${formatNumber(totalHommes + totalFemmes)}</td>
            `;
            tableBody.appendChild(totalRow);
        }
        
        // Fonction pour mettre à jour les graphiques
        function updateCharts(data) {
            // Détruire les anciens graphiques s'ils existent
            if (genreChart) genreChart.destroy();
            if (directionChart) directionChart.destroy();
            
            // Créer de nouveaux graphiques avec les nouvelles données
            
            // Graphique de répartition par genre
            const genreCtx = document.getElementById('genreChart');
            if (genreCtx) {
                const hommesTotal = data.directions.hommes + data.services.hommes;
                const femmesTotal = data.directions.femmes + data.services.femmes;
                
                genreChart = new Chart(genreCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Hommes', 'Femmes'],
                        datasets: [{
                            data: [hommesTotal, femmesTotal],
                            backgroundColor: ['#1976d2', '#d81b60'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${formatNumber(value)} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Graphique par direction
            const directionCtx = document.getElementById('directionChart');
            if (directionCtx) {
                directionChart = new Chart(directionCtx, {
                    type: 'bar',
                    data: {
                        labels: data.repartition.map(dir => dir.nom),
                        datasets: [
                            {
                                label: 'Hommes',
                                data: data.repartition.map(dir => dir.hommes),
                                backgroundColor: '#1976d2'
                            },
                            {
                                label: 'Femmes',
                                data: data.repartition.map(dir => dir.femmes),
                                backgroundColor: '#d81b60'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return formatNumber(value);
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const value = context.raw || 0;
                                        return `${label}: ${formatNumber(value)}`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
        
        // Fonction pour calculer les pourcentages
        function calculatePercentage(part, total) {
            return total > 0 ? Math.round((part / total) * 100) : 0;
        }
        
        // Fonction pour formater les nombres
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
        
        // Événements
        refreshBtn.addEventListener('click', fetchData);
        
        // Charger les données initiales
        document.addEventListener('DOMContentLoaded', fetchData);
        
        // Rafraîchir les données toutes les 5 minutes
        setInterval(fetchData, 5 * 60 * 1000);
    </script>
</body>
</html>