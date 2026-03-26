<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create($roomId)
    {
        $room = Room::findOrFail($roomId);
        return view('reservations.create', compact('room'));
    }

    public function index()
{
    if (!auth()->check()) {
        return redirect()->route('login')
            ->with('error', 'Veuillez vous connecter');
    }

    $reservations = auth()->user()->reservations()->with('room')->get();


    return view('reservations.index', compact('reservations'));

}

    public function store(Request $request)
    {
        // 🚨 BLOQUER SI NON CONNECTÉ
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez vous connecter pour réserver');
        }

        $request->validate([
            'room_id' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time'
        ]);

        $conflict = Reservation::where('room_id', $request->room_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })->exists();

        if ($conflict) {
            return back()->with('error', 'Salle déjà réservée à cet horaire');
        }

        Reservation::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('rooms.index')
            ->with('success', 'Réservation réussie');
    }
}