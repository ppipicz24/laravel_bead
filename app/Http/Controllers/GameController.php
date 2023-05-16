<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Player;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $games = Game::orderBy('start')->paginate(10);

        $teams = Team::all();
        $events= Event::all();
        $players= Player::all();

        return view('games.index', ['games'=>$games, 'teams'=>$teams, 'events'=>$events, 'players'=>$players]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Game::class);
        $games = Game::all();
        $teams = Team::all();
        return view('games.create', ['games' => $games, 'teams' => $teams]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Game::class);

        $validated = $request->validate(
            [
                'start' => 'required|date',
                'finished' => 'boolean',
                'home_team_id' => 'required|integer',
                'away_team_id' => 'required|integer',

            ],
            [
                'start.required' => 'A kezdési idő megadása kötelező!',
                'start.date' => 'A kezdési idő nem megfelelő formátumú!',
                'finished.boolean' => 'A befejezési idő nem megfelelő formátumú!',
                'home_team_id.required' => 'A hazai csapat megadása kötelező!',
                'home_team_id.integer' => 'A hazai csapat nem megfelelő formátumú!',
                'away_team_id.required' => 'A vendég csapat megadása kötelező!',
                'away_team_id.integer' => 'A vendég csapat nem megfelelő formátumú!',

            ]);



            $games = Game::create($validated);
            if($games->start > now())
            {
                $games->finished = false;
            }
            else
            {
                $games->finished = true;
            }

            $games->homeTeam()->associate(Team::all()->random()->id)->save();
            $games->awayTeam()->associate(Team::all()->random()->id)->save();
            Session::flash('game-created'); 
            return to_route('games.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $events = Event::all()->sortBy('minute');
        $players = Player::all();
        $teams = Team::all();
        return view('games.show', ['game'=>$game, 'events'=>$events, 'players'=>$players, 'teams'=>$teams]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $this->authorize('update', $game);
        $games = Event::all();
        $teams = Team::all();
        return view('games.edit', ['game' => $game, 'games' => $games, 'teams' => $teams]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $this->authorize('update', $game);
        $validated = $request->validate(
            [
                'start' => 'required|date',
                'finished' => 'boolean',
                'home_team_id' => 'required|integer',
                'away_team_id' => 'required|integer',

            ],
            [
                'start.required' => 'A kezdési idő megadása kötelező!',
                'start.date' => 'A kezdési idő nem megfelelő formátumú!',
                'finished.boolean' => 'A befejezési idő nem megfelelő formátumú!',
                'home_team_id.required' => 'A hazai csapat megadása kötelező!',
                'home_team_id.integer' => 'A hazai csapat nem megfelelő formátumú!',
                'away_team_id.required' => 'A vendég csapat megadása kötelező!',
                'away_team_id.integer' => 'A vendég csapat nem megfelelő formátumú!',

            ]);



            $game = update($validated);
            if($game->start > now())
            {
                $game->finished = false;
            }
            else
            {
                $game->finished = true;
            }

            $game->homeTeam()->associate(Team::all()->random()->id)->save();
            $game->awayTeam()->associate(Team::all()->random()->id)->save();
            Session::flash('game-updated'); 
            return to_route('games.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $this->authorize('delete', $game);
        $game-> delete();
        Session::flash('game-deleted');
        return to_route('games.index');
    }
}
