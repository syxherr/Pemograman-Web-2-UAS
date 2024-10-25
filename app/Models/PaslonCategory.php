<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaslonCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 'name', 'vision_mission',
    ];

    public function votings()
    {
        return $this->hasMany(VotingPaslon::class, 'id_paslon');
    }
}
