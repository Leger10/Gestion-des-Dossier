@extends('layouts.admin', ['titrePage' => 'Détail acte administratif'])

@section('content')
    @include('partials.back-admin._nav')
    
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --primary-light: #5d74f1;
            --secondary: #f8f9ff;
            --text: #2d3748;
            --text-light: #718096;
            --success: #38a169;
            --warning: #ecc94b;
            --border: #e2e8f0;
            --card-bg: #ffffff;
            --shadow: 0 10px 30px rgba(67, 97, 238, 0.15);
            --transition: all 0.3s ease;
        }
        
        /* Ajustements pour éviter le chevauchement */
        .content-wrapper {
            padding-top: 20px;
            background: linear-gradient(135deg, #f0f4ff 0%, #e6edff 100%);
            min-height: calc(100vh - 60px); /* Ajustement pour le topbar */
        }
        
        .detail-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 30px;
            transition: var(--transition);
            margin-left: 15px; /* Ajustement pour le sidebar */
            margin-right: 15px;
        }
        
        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(67, 97, 238, 0.2);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 25px 30px;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .card-header::after {
            content: "";
            position: absolute;
            bottom: -70px;
            left: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }
        
        .header-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .header-text h1 {
            font-size: 1.6rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .header-text p {
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .actions {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }
        
        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
        }
        
        .card-body {
            padding: 25px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-group {
            position: relative;
        }
        
        .info-label {
            font-size: 0.9rem;
            color: var(--primary);
            margin-bottom: 6px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            background: var(--secondary);
            border-radius: 12px;
            padding: 15px 18px;
            font-size: 1rem;
            border-left: 4px solid var(--primary-light);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }
        
        .agent-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .agent-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .description-box {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid var(--primary-light);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            font-size: 1rem;
            line-height: 1.6;
        }
        
        .section-title {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            padding-left: 15px;
        }
        
        .section-title::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 24px;
            width: 5px;
            background: var(--primary);
            border-radius: 10px;
        }
        
        .history-timeline {
            padding-left: 25px;
        }
        
        .timeline-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 25px;
        }
        
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        
        .timeline-item::before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: var(--primary);
            border: 4px solid var(--secondary);
            box-shadow: 0 0 0 2px var(--primary);
            z-index: 2;
        }
        
        .timeline-item::after {
            content: "";
            position: absolute;
            left: 8px;
            top: 24px;
            height: calc(100% + 10px);
            width: 2px;
            background: var(--border);
        }
        
        .timeline-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1rem;
        }
        
        .timeline-details {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }
        
        .document-card {
            background: var(--card-bg);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            border: 1px solid var(--border);
        }
        
        .document-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.15);
            border-color: var(--primary-light);
        }
        
        .doc-icon {
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0f4ff 0%, #e6edff 100%);
        }
        
        .pdf-icon {
            color: #e53e3e;
            font-size: 3rem;
        }
        
        .word-icon {
            color: #2b6cb0;
            font-size: 3rem;
        }
        
        .doc-content {
            padding: 15px;
        }
        
        .doc-title {
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 1rem;
        }
        
        .doc-meta {
            color: var(--text-light);
            font-size: 0.85rem;
            margin-bottom: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .doc-actions {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            flex: 1;
            padding: 8px;
            border-radius: 8px;
            background: var(--secondary);
            color: var(--primary);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .action-btn:hover {
            background: var(--primary);
            color: white;
        }
        
        .card-footer {
            background: var(--card-bg);
            padding: 20px 25px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }
        
        .footer-actions {
            display: flex;
            gap: 12px;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 18px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .badge-published {
            background: rgba(56, 161, 105, 0.15);
            color: var(--success);
        }
        
        .badge-draft {
            background: rgba(236, 201, 75, 0.15);
            color: var(--warning);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .card-body > div {
                grid-template-columns: 1fr;
            }
            
            .history-section, .documents-section {
                margin-bottom: 30px;
            }
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .card-header {
                padding: 20px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .card-footer {
                flex-direction: column;
            }
            
            .footer-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .btn-outline {
                flex: 1;
                text-align: center;
            }
        }
    </style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>
                <i class="fas fa-file-contract text-primary"></i>
               Acte administratif
            </h1>
        </div>
    </section>

    <div class="detail-card">
        <div class="card-header">
            <div class="header-content">
                <div class="header-text">
                    <h1>
                        <i class="fas fa-file-alt"></i>
                        Détail de l'acte administratif
                    </h1>
                    <p>Référence: {{ $acte->reference }}</p>
                </div>
                <div class="actions">
                    <a href="{{ route('actes_administratifs.edit', $acte) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="info-grid">
                <div class="info-group">
                    <div class="info-label">
                        <i class="fas fa-hashtag"></i> RÉFÉRENCE
                    </div>
                    <div class="info-value">{{ $acte->reference }}</div>
                </div>
                
                <div class="info-group">
                    <div class="info-label">
                        <i class="fas fa-tag"></i> TYPE D'ACTE
                    </div>
                    <div class="info-value">{{ $acte->type }}</div>
                </div>
                
                <div class="info-group">
                    <div class="info-label">
                        <i class="fas fa-calendar-day"></i> DATE DE L'ACTE
                    </div>
                    <div class="info-value">{{ $acte->date_acte->format('d/m/Y') }}</div>
                </div>
                
                <div class="info-group">
                    <div class="info-label">
                        <i class="fas fa-user-tie"></i> AGENT CONCERNÉ
                    </div>
                    <div class="info-value">
                        <a href="{{ route('agents.show', $acte->agent) }}" class="agent-link">
                            <i class="fas fa-user-circle"></i>
                            {{ $acte->agent->nom }} {{ $acte->agent->prenom }}
                        </a>
                        <div class="text-muted small" style="margin-top: 8px;">
                            <i class="fas fa-id-card"></i>
                            Matricule: {{ $acte->agent->matricule ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="description-box">
                <div class="info-label" style="margin-bottom: 15px;">
                    <i class="fas fa-align-left"></i> DESCRIPTION
                </div>
                <p>{{ $acte->description }}</p>
            </div>
            
            <div class="grid-section">
                <div class="history-section">
                    <h2 class="section-title">
                        <i class="fas fa-history"></i> Historique de l'acte
                    </h2>
                    
                    <div class="history-timeline">
                        <div class="timeline-item">
                            <div class="timeline-title">Création de l'acte</div>
                            <div class="timeline-details">
                                <i class="fas fa-clock"></i> {{ $acte->created_at->format('d/m/Y à H:i') }}
                                <div style="margin-top: 5px;">
                                    <i class="fas fa-user"></i> {{ $acte->created_by->name ?? 'Système' }}
                                </div>
                            </div>
                        </div>
                        
                        @if($acte->created_at != $acte->updated_at)
                        <div class="timeline-item">
                            <div class="timeline-title">Dernière mise à jour</div>
                            <div class="timeline-details">
                                <i class="fas fa-clock"></i> {{ $acte->updated_at->format('d/m/Y à H:i') }}
                                <div style="margin-top: 5px;">
                                    <i class="fas fa-user"></i> {{ $acte->updated_by->name ?? 'Système' }}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="timeline-item">
                            <div class="timeline-title">Statut actuel</div>
                            <div class="timeline-details">
                                @if($acte->is_published)
                                    <span class="status-badge badge-published">
                                        <i class="fas fa-check-circle"></i> Publié
                                    </span>
                                    <div style="margin-top: 8px;">
                                        <i class="fas fa-calendar-check"></i> le {{ $acte->published_at->format('d/m/Y') }}
                                    </div>
                                @else
                                    <span class="status-badge badge-draft">
                                        <i class="fas fa-edit"></i> Brouillon
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="documents-section">
                    <h2 class="section-title">
                        <i class="fas fa-file-alt"></i> Documents associés
                    </h2>
                    
                    <div class="documents-grid">
                        <div class="document-card">
                            <div class="doc-icon">
                                <i class="fas fa-file-pdf pdf-icon"></i>
                            </div>
                            <div class="doc-content">
                                <div class="doc-title">Acte administratif {{ $acte->reference }}.pdf</div>
                                <div class="doc-meta">
                                    <span><i class="fas fa-weight"></i> 1.5 Mo</span>
                                    <span><i class="fas fa-calendar"></i> {{ $acte->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="doc-actions">
                                    <button class="action-btn">
                                        <i class="fas fa-download"></i> Télécharger
                                    </button>
                                    <button class="action-btn">
                                        <i class="fas fa-eye"></i> Voir
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="document-card">
                            <div class="doc-icon">
                                <i class="fas fa-file-word word-icon"></i>
                            </div>
                            <div class="doc-content">
                                <div class="doc-title">Fiche agent.docx</div>
                                <div class="doc-meta">
                                    <span><i class="fas fa-weight"></i> 350 Ko</span>
                                    <span><i class="fas fa-calendar"></i> {{ $acte->agent->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="doc-actions">
                                    <button class="action-btn">
                                        <i class="fas fa-download"></i> Télécharger
                                    </button>
                                    <button class="action-btn">
                                        <i class="fas fa-eye"></i> Voir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <a href="{{ route('actes_administratifs.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            <div class="footer-actions">
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-download"></i> Télécharger l'acte
                </a>
                <button class="btn btn-outline">
                    <i class="fas fa-share-alt"></i> Partager
                </button>
            </div>
        </div>
    </div>

    <script>
        // Animation pour les boutons de téléchargement
        document.querySelectorAll('.action-btn, .btn-outline').forEach(button => {
            button.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    
                    if(this.textContent.includes('Télécharger')) {
                        const toast = document.createElement('div');
                        toast.style.cssText = `
                            position: fixed;
                            bottom: 20px;
                            right: 20px;
                            background: var(--primary);
                            color: white;
                            padding: 15px 25px;
                            border-radius: 12px;
                            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                            z-index: 1000;
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            animation: fadeIn 0.3s, fadeOut 0.3s 2.7s;
                        `;
                        
                        toast.innerHTML = `
                            <i class="fas fa-check-circle"></i>
                            <span>Téléchargement lancé avec succès</span>
                        `;
                        
                        document.body.appendChild(toast);
                        
                        setTimeout(() => {
                            toast.remove();
                        }, 3000);
                    }
                }, 1500);
            });
        });
        
        // Ajout des styles d'animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(20px); }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection