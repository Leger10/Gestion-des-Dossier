<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  // Assurez-vous d'importer Hash
use App\Models\User; // Assurez-vous d'importer le modèle User

class UserController extends Controller
{
    // Affiche le formulaire de changement de mot de passe
    public function showChangePasswordForm()
    {
        return view('auth.passwords.change');  // La vue à créer
    }

    
public function changePassword(Request $request)
{
    // Validation des données
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',  // Validation de la confirmation du mot de passe
    ]);

    // Vérifier si le mot de passe actuel est correct
    if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }

    $user = Auth::user();
    if (!$user instanceof User) {
        $user = User::find(Auth::id());
    }

    // Vérification si la colonne 'is_admin' est transmise dans la requête avant de la mettre à jour
    $user->password = Hash::make($request->new_password);  // Hacher le mot de passe
    // Si tu ne veux pas modifier 'is_admin', tu peux l'omettre
    if ($request->has('is_admin')) {
        $user->is_admin = $request->is_admin;
    }
    if ($user instanceof User) {
        $user->save();
    } else {
        return back()->withErrors(['user' => 'Utilisateur introuvable ou non valide.']);
    }

    // Retour avec un message de succès
    return redirect()->route('password.change')->with('status', 'Mot de passe mis à jour avec succès.');
}

public function index()
{
    $adminUsers = User::whereHas('role', function($query) {
        $query->where('name', 'Administrateur');
    })->get();

    return view('dashbord.utilisateur', compact('adminUsers'));
}
}
