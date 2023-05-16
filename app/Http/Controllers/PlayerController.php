<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Team $team)
    {
        $this->authorize('create', Player::class);
        $players = Player::all();
        $teams = Team::all();
        return view('players.create', ['players' => $players, 'team' => $team, 'teams' => $teams]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Player::class);
        $validated = $request->validate([
            'name' => 'required|string|distinct',
            'number' => 'required|integer|between:1,99',
            'team_id' => 'required',
            'birthdate' => 'required|date|before:today'
        ],
        [
            'name.required' => 'A név megadása kötelező',
            'name.distinct' => 'A név nem lehet egyező',
            'number.required' => 'A mezszám megadása kötelező',
            'number.integer' => 'A mezszám csak szám lehet',
            'number.between' => 'A mezszám csak 1 és 99 között lehet',
            'team_id.required' => 'A csapat megadása kötelező',
            'birthdate.required' => 'A születési dátum megadása kötelező',
            'birthdate.date' => 'A születési dátum nem megfelelő',
            'birthdate.before' => 'A születési dátum nem lehet a mai napnál később'
        ]);

        $player = Player::create($validated);

        $player->teams()->associate(Team::all()->where('id', $request->team_id)->last())->save();

        Session::flash('player-created'); 
        return to_route('teams.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $this->authorize('delete', $player);
        $player-> delete();
        Session::flash('player-deleted');
        return to_route('teams.index');
    }
}
