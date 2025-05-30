<?php
namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request)
{
    $query = Agent::query();

    if ($request->filled('nom')) {
        $query->where('nom', 'like', '%' . $request->nom . '%');
    }

    if ($request->filled('matricule')) {
        $query->where('matricule', 'like', '%' . $request->matricule . '%');
    }

    if ($request->filled('service')) {
        $query->where('service_id', $request->service);
    }

    $agents = $query->orderBy('nom')->paginate(10);

    // Charger la liste des services
    $services = Service::orderBy('name')->get();

    return view('dashboard.agents.index', compact('agents', 'services'));
}

public function show($id)
{
    $agent = Agent::with(['actes_Administratifs', 'evaluations', 'sanctions', 'recompenses', 'conge_absences', 'formations', 'affectations'])->findOrFail($id);

    $sections = [
        'actes_administratifs'  => [
            'title' => '📜 Actes administratifs',
            'icon'  => 'file-alt',
            'color' => 'primary',
        ],
        'evaluations' => [
            'title' => '📈 Évaluations',
            'icon'  => 'chart-line',
            'color' => 'success',
        ],
        'sanctions' => [
            'title' => '⚠️ Sanctions',
            'icon'  => 'exclamation-triangle',
            'color' => 'danger',
        ],
        'recompenses' => [
            'title' => '🏆 Récompenses',
            'icon'  => 'award',
            'color' => 'warning',
        ],
         'conge_absences' => [
        'title' => 'Congés & Absences',
        'icon'  => 'calendar-check',
        'color' => 'warning',
    ],
        'formations' => [
            'title' => '🎓 Formations',
            'icon'  => 'graduation-cap',
            'color' => 'purple',
        ],
        'affectations' => [
            'title' => '🏢 Affectations',
            'icon'  => 'building',
            'color' => 'secondary',
        ],
    ];

    return view('dashboard.agents.show', compact('agent', 'sections'));
}

}
