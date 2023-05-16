<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Game;
use App\Models\Event;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class EventController extends Controller
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
    public function create(Game $game)
    {
        $this->authorize('create', Event::class);
        $events= Event::all();
        $teams = Team::all();
        $games = Game::all();
        $players= Player::all()->sortBy('team_id')->sortBy('id');
        return view('events.create', ['events' => $events, 'players'=>$players, 'teams' => $teams, 'games' => $games, 'game' => $game]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);
        $validated= $request->validate(
            [
                'minute' => 'required|digits_between:1,90',
                'type' => 'required',
                'player_id' => 'required'
            ],
            [
                'minute.required' => 'Az idő megadása kötelező', 
                'minute.digit_between' => 'Az idő csak 1 és 90 között lehet',
                'type.required' => 'A típus megadása kötelező',
                'player_id.required' => 'A játékos megadása kötelező'
            ]
        );

        $validated['game_id'] = $request->game_id;
        $events = Event::create($validated);
        $events->players()->associate(Player::all()->where('id', $request->player_id)->first()
        )->save();
        $events->games()->associate(Game::all()->random()->id)->save();   
        
        Session::flash('event-created');     

        return to_route('games.show');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event-> delete();
        Session::flash('event-deleted');
        return to_route('games.index');
    }
}
