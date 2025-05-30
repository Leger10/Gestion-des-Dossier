@extends('layouts.admin', ['titrePage' => 'DGTI - Gestion des agents'])

@section('content')
@include('partials.back-admin._nav')

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tableau de board
            <small>Direction générale des Transmissions et de l'informatique</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
            <li class="active"><i class="fa fa-users"></i> Gestion des agents</li>
        </ol>
    </section>

    <style>
        :root {
            --primary: #1a3a6c;
            --primary-light: #2a4d8e;
            --secondary: #4c8bf5;
            --accent: #00c0ef;
            --success: #00a65a;
            --warning: #f39c12;
            --danger: #dd4b39;
            --light: #f8f9fc;
            --dark: #2c3e50;
            --gray: #6c757d;
            --light-gray: #eef2f7;
            --border: #dee2e6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        .dashboard-body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: var(--dark);
            padding: 20px;
        }
        
        .dashboard-container {
            max-width: 1600px;
            margin: 0 auto;
        }
        
        /* Header Styles */
        .dashboard-header {
            background: linear-gradient(120deg, var(--primary), var(--primary-light));
            color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-left h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .header-left p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .header-right {
            display: flex;
            align-items: center;
        }
        
        .date-display {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            margin-right: 20px;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .user-profile:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }
        
        .user-profile span {
            font-weight: 500;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
        }
        
        .stat-card.direction::before {
            background: var(--primary);
        }
        
        .stat-card.service::before {
            background: var(--secondary);
        }
        
        .stat-card.total::before {
            background: var(--success);
        }
        
        .stat-card.recap::before {
            background: var(--accent);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .stat-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(26, 58, 108, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.4rem;
        }
        
        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark);
        }
        
        .stat-label {
            font-size: 0.95rem;
            color: var(--gray);
            margin-bottom: 15px;
        }
        
        .stat-details {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid var(--border);
            padding-top: 15px;
            margin-top: 15px;
        }
        
        .detail-item {
            text-align: center;
        }
        
        .detail-value {
            font-size: 1.4rem;
            font-weight: 700;
        }
        
        .detail-label {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .chart-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .chart-actions button {
            background: var(--light-gray);
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .chart-actions button:hover {
            background: var(--border);
        }
        
        .chart-wrapper {
            height: 300px;
            position: relative;
        }
        
        /* Tables Section */
        .tables-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .table-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }
        
        .table-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
        }
        
        .table-title i {
            margin-right: 10px;
            color: var(--primary);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: var(--primary);
            color: white;
            text-align: left;
            padding: 12px 15px;
            font-weight: 600;
        }
        
        tr:nth-child(even) {
            background: var(--light-gray);
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border);
        }
        
        .bg-gray {
            background: #f1f5f9 !important;
            font-weight: 700;
        }
        
        .text-right {
            text-align: right;
        }
        
        /* Summary Table */
        .summary-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow-x: auto;
        }
        
        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .summary-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .charts-section,
            .tables-section {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                text-align: center;
            }
            
            .header-right {
                margin-top: 20px;
                width: 100%;
                justify-content: center;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .stat-value {
                font-size: 1.8rem;
            }
        }
    </style>

    <div class="dashboard-body">
        <div class="dashboard-container">
            <!-- Header -->
            <header class="dashboard-header">
                <div class="header-left">
                    <h1>Direction Générale des Transmissions et de l'Informatique</h1>
                    <p>Tableau de bord de gestion et de suivi des effectifs</p>
                </div>
                <div class="header-right">
                    <div class="date-display">
                        <i class="fas fa-calendar-alt"></i> 
                        {{ ucfirst(now()->locale('fr_FR')->isoFormat('D MMMM YYYY')) }}
                    </div>
                    <div class="user-profile">
                        <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="Admin">
                        <span>Administrateur DGTI</span>
                    </div>
                </div>
            </header>
            
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card direction">
                    <div class="stat-header">
                        <div class="stat-title">AGENTS DE LA DGTI</div>
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value">17</div>
                    <div class="stat-label">Nombre total des agents</div>
                    <div class="stat-details">
                        <div class="detail-item">
                            <div class="detail-value">13</div>
                            <div class="detail-label">Hommes</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-value">4</div>
                            <div class="detail-label">Femmes</div>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card service">
                    <div class="stat-header">
                        <div class="stat-title">AGENTS PAR SERVICE</div>
                        <div class="stat-icon">
                            <i class="fas fa-network-wired"></i>
                        </div>
                    </div>
                    <div class="stat-value">76</div>
                    <div class="stat-label">Nombre total des agents</div>
                    <div class="stat-details">
                        <div class="detail-item">
                            <div class="detail-value">67</div>
                            <div class="detail-label">Hommes</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-value">9</div>
                            <div class="detail-label">Femmes</div>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card total">
                    <div class="stat-header">
                        <div class="stat-title">TOTAUX GÉNÉRAUX</div>
                        <div class="stat-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                    <div class="stat-value">93</div>
                    <div class="stat-label">Agents au total</div>
                    <div class="stat-details">
                        <div class="detail-item">
                            <div class="detail-value">80</div>
                            <div class="detail-label">Hommes</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-value">13</div>
                            <div class="detail-label">Femmes</div>
                        </div>
                    </div>
                </div>
                
                <!-- Carte Répartition par Genre -->
                
            </div>
            
            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-container">
                    <div class="chart-header">
                        <div class="chart-title">RÉPARTITION PAR CATÉGORIE - DIRECTION</div>
                        <div class="chart-actions">
                            <button><i class="fas fa-download"></i> Exporter</button>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="categoryDirectionChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container">
                    <div class="chart-header">
                        <div class="chart-title">RÉPARTITION PAR CATÉGORIE - SERVICE</div>
                        <div class="chart-actions">
                            <button><i class="fas fa-download"></i> Exporter</button>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="categoryServiceChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Tables Section -->
            <div class="tables-section">
                <div class="table-container">
                    <div class="table-title">
                        <i class="fas fa-dice-d4"></i> DIRECTIONS - RÉPARTITION PAR CATÉGORIE
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Catégorie</th>
                                <th>Hommes</th>
                                <th>Femmes</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>I</b></td>
                                <td>5</td>
                                <td>0</td>
                                <td><b>5</b></td>
                            </tr>
                            <tr>
                                <td><b>II</b></td>
                                <td>2</td>
                                <td>1</td>
                                <td><b>3</b></td>
                            </tr>
                            <tr>
                                <td><b>III</b></td>
                                <td>6</td>
                                <td>3</td>
                                <td><b>9</b></td>
                            </tr>
                            <tr>
                                <td><b>Néant</b></td>
                                <td>0</td>
                                <td>0</td>
                                <td><b>0</b></td>
                            </tr>
                            <tr class="bg-gray">
                                <td><b>TOTAL</b></td>
                                <td><b>13</b></td>
                                <td><b>4</b></td>
                                <td><b>17</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="table-container">
                    <div class="table-title">
                        <i class="fas fa-dice-d4"></i> SERVICES - RÉPARTITION PAR CATÉGORIE
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Catégorie</th>
                                <th>Hommes</th>
                                <th>Femmes</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>I</b></td>
                                <td>0</td>
                                <td>0</td>
                                <td><b>0</b></td>
                            </tr>
                            <tr>
                                <td><b>II</b></td>
                                <td>8</td>
                                <td>1</td>
                                <td><b>9</b></td>
                            </tr>
                            <tr>
                                <td><b>III</b></td>
                                <td>72</td>
                                <td>12</td>
                                <td><b>84</b></td>
                            </tr>
                            <tr>
                                <td><b>Néant</b></td>
                                <td>0</td>
                                <td>0</td>
                                <td><b>0</b></td>
                            </tr>
                            <tr class="bg-gray">
                                <td><b>TOTAL</b></td>
                                <td><b>80</b></td>
                                <td><b>13</b></td>
                                <td><b>93</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="stat-card recap">
                    <div class="stat-header">
                        <div class="stat-title">RÉPARTITION PAR GENRE</div>
                        <div class="stat-icon">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            <!-- Summary Table -->
            <div class="summary-container">
                <div class="summary-header">
                    <div class="summary-title">RÉCAPITULATIF PAR DIRECTIONS</div>
                    <div class="chart-actions">
                        <button><i class="fas fa-print"></i> Imprimer</button>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Directions</th>
                            <th>DGTI</th>
                            <th>DT</th>
                            <th>DSI</th>
                            <th>DASP</th>
                            <th>DSEF</th>
                            <th>DIG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Total Agents</b></td>
                            <td>13</td>
                            <td>34</td>
                            <td>22</td>
                            <td>13</td>
                            <td>13</td>
                            <td>9</td>
                        </tr>
                        <tr>
                            <td><b>Hommes</b></td>
                            <td>11</td>
                            <td>26</td>
                            <td>22</td>
                            <td>11</td>
                            <td>11</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td><b>Femmes</b></td>
                            <td>2</td>
                            <td>8</td>
                            <td>0</td>
                            <td>2</td>
                            <td>2</td>
                            <td>2</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gender Distribution Chart
        const genderCtx = document.getElementById('genderChart');
        const genderChart = new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hommes', 'Femmes'],
                datasets: [{
                    data: [80, 13],
                    backgroundColor: ['#1a3a6c', '#4c8bf5'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 13,
                                family: "'Montserrat', sans-serif"
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        bodyFont: {
                            family: "'Montserrat', sans-serif",
                            size: 14
                        }
                    }
                },
                cutout: '70%'
            }
        });
        
        // Category Distribution Chart - Direction
        const catDirectionCtx = document.getElementById('categoryDirectionChart');
        const catDirectionChart = new Chart(catDirectionCtx, {
            type: 'bar',
            data: {
                labels: ['Catégorie I', 'Catégorie II', 'Catégorie III', 'Néant'],
                datasets: [
                    {
                        label: 'Hommes',
                        data: [5, 2, 6, 0],
                        backgroundColor: '#1a3a6c',
                        barThickness: 30
                    },
                    {
                        label: 'Femmes',
                        data: [0, 1, 3, 0],
                        backgroundColor: '#4c8bf5',
                        barThickness: 30
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 2
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 13,
                                family: "'Montserrat', sans-serif"
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });
        
        // Category Service Chart
        const catServiceCtx = document.getElementById('categoryServiceChart');
        const catServiceChart = new Chart(catServiceCtx, {
            type: 'bar',
            data: {
                labels: ['Catégorie I', 'Catégorie II', 'Catégorie III', 'Néant'],
                datasets: [
                    {
                        label: 'Hommes',
                        data: [0, 8, 72, 0],
                        backgroundColor: '#1a3a6c',
                        barThickness: 30
                    },
                    {
                        label: 'Femmes',
                        data: [0, 1, 12, 0],
                        backgroundColor: '#4c8bf5',
                        barThickness: 30
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 20
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 13,
                                family: "'Montserrat', sans-serif"
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });
    </script>
</div>
@endsection