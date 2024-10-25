<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaslonCategory;
use App\Models\VotingPaslon;

class VoteController extends Controller
{
    public function index()
    {
        $hasilvoting = VotingPaslon::all();
        $paslonCategories = PaslonCategory::withCount('votings')->get();

        // Data untuk Chart.js
        $chartData = [
            'labels' => $paslonCategories->pluck('name'),
            'data' => $paslonCategories->pluck('votings_count'),
        ];

        return view('layouts/admin/hasilvoting', compact('hasilvoting','paslonCategories','chartData'));
    }

    public function votePaslon(PaslonCategory $paslon)
    {
        $user = auth()->user();

        // Periksa apakah user sudah melakukan voting pada paslon ini
        if ($user->hasVoted($paslon->id)) {
            return redirect('/user/votingpaslon')->with('error', 'Anda sudah melakukan voting.');
        }

        // Buat record voting baru
        VotingPaslon::create([
            'id_user' => $user->id,
            'id_paslon' => $paslon->id,
        ]);

        return redirect('/user/votingpaslon')->with('success', 'Voting berhasil.');
    }
}