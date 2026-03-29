<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'capacity',
        'location',
        'description',
        'image',
        'prix',

    ];


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
