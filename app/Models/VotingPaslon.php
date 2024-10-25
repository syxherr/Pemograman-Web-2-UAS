<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingPaslon extends Model
{
    protected $table = 'voting_paslon';

    protected $fillable = [
        'id_user', 'id_paslon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function paslon()
    {
        return $this->belongsTo(PaslonCategory::class, 'id_paslon');
    }
}
