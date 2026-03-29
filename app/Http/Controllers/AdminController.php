<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  // ✅ Import manquant
use App\Models\User;
use App\Models\Reservation;
use App\Models\Room;

class AdminController extends Controller
{
    /* ── Tableau de bord ── */
    public function dashboard()
    {
        $users            = User::latest()->take(5)->get();
        $reservations     = Reservation::with('room', 'user')->latest()->take(5)->get();
        $allUsers         = User::with('reservations')->latest()->get();
        $allReservations  = Reservation::with('room', 'user')->latest()->get();
        $rooms            = Room::with('reservations.user')->latest()->get();
        $totalUsers       = User::count();
        $totalReservations= Reservation::count();
        $totalRooms       = Room::count();

        return view('admin.dashboard', compact(
            'users', 'reservations',
            'allUsers', 'allReservations',
            'rooms',
            'totalUsers', 'totalReservations', 'totalRooms'
        ));
    }

    /* ── Créer un utilisateur ── */
    public function storeUser(Request $request)
    {
        $request->validate([
            'user_name'     => 'required|string|max:255',
            'user_email'    => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:8|confirmed',
            'user_role'     => 'required|in:user,admin',
        ]);

        User::create([
            'name'     => $request->user_name,
            'email'    => $request->user_email,
            'password' => Hash::make($request->user_password),
            'role'     => $request->user_role,
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Utilisateur créé avec succès.');
    }

    /* ── Supprimer un utilisateur ── */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Impossible de supprimer un administrateur.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Utilisateur supprimé.');
    }

    /* ── Modifier une salle ── */
    public function updateRoom(Request $request, Room $room)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type' => 'nullable|string|in:standard,premium,vip,conference,coworking',
            'capacity'    => 'required|integer|min:1',
            'prix'        => 'required|numeric|min:0',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only(['name' , 'capacity', 'prix', 'location', 'description','type']);

        if ($request->hasFile('image')) {
            if ($room->image) {
                \Storage::disk('public')->delete($room->image);
            }
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Salle mise à jour avec succès.');
    }
}