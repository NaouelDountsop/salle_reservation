<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cherche uniquement par email admin, ne touche pas aux autres users
        $admin = User::where('email', 'admin@espaceidees.com')->first();

        if ($admin) {
            // Admin existe déjà → met juste à jour le rôle et mot de passe
            $admin->update([
                'role'     => 'admin',
                'password' => Hash::make('VotreMotDePasseSecret123!'),
            ]);
            $this->command->info('✅ Admin mis à jour : admin@espaceidees.com');
        } else {
            // Admin n'existe pas → on le crée proprement
            User::create([
                'name'              => 'Administrateur',
                'email'             => 'admin@gmail.com',
                'password'          => Hash::make('12345678'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]);
            $this->command->info('✅ Admin créé : admin@espaceidees.com');
        }
    }
}