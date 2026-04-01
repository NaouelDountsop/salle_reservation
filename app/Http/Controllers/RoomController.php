<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'capacity'    => 'required|integer',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'prix'        => 'required|numeric',
            'type'        => 'nullable|string|in:standard,premium,vip,conference,coworking,mariage',
        ]);

        $data = $request->only(['name', 'capacity', 'location', 'description', 'prix', 'type']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request);
        }

        Room::create($data);

        return redirect()->route('rooms.index')->with('success', 'Salle créée avec succès !');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'nullable|string|in:standard,premium,vip,conference,coworking,mariage',
            'capacity'    => 'required|integer',
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'prix'        => 'required|numeric',
        ]);

        $data = $request->only(['name', 'capacity', 'location', 'description', 'prix', 'type']);

        if ($request->hasFile('image')) {
            
            if ($room->image && !str_starts_with($room->image, 'data:')) {
                \Storage::disk('public')->delete($room->image);
            }
            $data['image'] = $this->handleImageUpload($request);
        }

        $room->update($data);

        return redirect()->route('rooms.index')->with('success', 'Salle mise à jour avec succès !');
    }

    public function destroy(string $id) {}

    /* ══ HELPER — gère les deux environnements ══ */
    private function handleImageUpload(Request $request): string
    {
        $file = $request->file('image');

        // Production (Laravel Cloud) → base64
        if (app()->environment('production')) {
            $mime   = $file->getMimeType();
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            return "data:{$mime};base64,{$base64}";
        }

        // Local → storage/public
        return $file->store('rooms', 'public');
    }
}