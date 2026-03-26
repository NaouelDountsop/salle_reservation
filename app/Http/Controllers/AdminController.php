<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Room;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 🔹 Aperçu (dashboard rapide)
        $users = User::latest()->take(5)->get();
        $reservations = Reservation::with('room', 'user')->latest()->take(5)->get();

        // 🔹 Données complètes
        $allUsers = User::with('reservations')->latest()->get(); // ✅ AJOUTÉ
        $allReservations = Reservation::with('room', 'user')->latest()->get();

        // 🔹 Salles
        $rooms = Room::all();

        // 🔹 Statistiques
        $totalUsers = User::count();
        $totalReservations = Reservation::count();
        $totalRooms = Room::count();

        return view('admin.dashboard', compact(
            'users',
            'reservations',
            'allUsers',          
            'allReservations',   
            'rooms',
            'totalUsers',
            'totalReservations',
            'totalRooms'
        ));
    }

    public function destroyUser($id)
{
    $user = User::findOrFail($id);

    // ❗ sécurité : éviter de supprimer un admin
    if ($user->role === 'admin') {
        return back()->with('error', 'Impossible de supprimer un admin');
    }

    $user->delete();

    return back()->with('success', 'Utilisateur supprimé');
}
}