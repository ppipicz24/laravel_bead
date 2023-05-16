<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'minute',
        'player_id',
        'game_id',
    ];

    public function players()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function games()
    {
        return $this->belongsTo(Game::class, 'game_id');

    }
}
