<?php

namespace App\Models;
use App\Models\Room;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'room_id',
        'start_time',
        'end_time',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function getTotalPriceAttribute()
    {
        if (!$this->start_time || !$this->end_time || !$this->room) {
            return 0;
        }

        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);

        
        $hours = $start->floatDiffInHours($end);

       
        return round($hours * $this->room->prix, 2);
    }
}
