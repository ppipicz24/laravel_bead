<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Game;
use App\Models\Event;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();
        $teams = Team::all()->sortBy('name');
        $events= Event::all();
        $players= Player::all();

        return view('teams.index', ['games'=>$games, 'teams'=>$teams, 'events'=>$events, 'players'=>$players]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Team::class);
        $teams= Team::all();
        return view('teams.create', ['teams' => $teams]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Team::class);
        $validated = $request->validate(
            [
                'name' => 'required|string|distinct',
                'shortname' => 'required|string|distinct|max:4',
                'image' => 'image',
            ],
            [
                'name.required' => 'A név megadása kötelező!',
                'name.string' => 'A név nem lehet szám!',
                'name.distinct' => 'A név nem lehet ismétlődő!',
                'shortname.distinct' => 'A név rövidítése nem lehet ismétlődő!',
                'shortname.string' => 'A név rövidítése nem lehet szám!',
                'shortname.required' => 'A név rövidítése megadása kötelező!',
                'shortname.max' => 'A név rövidítése maximum 4 karakter lehet!',
                'image.image' => 'A logo csak kép lehet!',
            ]);

            $teams = Team::create($validated);;

            if ($request -> hasFile('image')){
                $file = $request -> file('image');
                $fname = $file -> hashName();
                Storage::disk('public') -> put('images/' . $fname, $file -> get());
                $validated['image'] = $fname;
            }

            $teams-> users()->sync($request->id);


            Session::flash('team-created');

        return to_route('teams.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $games = Game::all()->sortBy('start');
        $events= Event::all();
        $players= Player::all();
        $teams = Team::all();

        return view('teams.show', ['games'=>$games, 'team'=>$team, 'events'=>$events, 'players'=>$players, 'teams'=>$teams]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $this->authorize('update', $team);
        $teams= Team::all();
        return view('teams.edit', ['teams' => $teams, 'team' => $team]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $this->authorize('update', $team);
        $validated = $request->validate(
            [
                'name' => 'required|string|distinct',
                'shortname' => 'required|string|distinct',
                'image' => 'image',
            ],
            [
                'name.required' => 'A név megadása kötelező!',
                'name.string' => 'A név nem lehet szám!',
                'name.distinct' => 'A név nem lehet ismétlődő!',
                'shortname.distinct' => 'A név rövidítése nem lehet ismétlődő!',
                'shortname.string' => 'A név rövidítése nem lehet szám!',
                'shortname.required' => 'A név rövidítése megadása kötelező!',
                'image.image' => 'A logo csak kép lehet!',
            ]);

            $team -> update($validated);
            if($request->name == null){
                $request->name = $team->name;
            }


            if ($request -> hasFile('image')){
                $file = $request -> file('image');
                $fname = $file -> hashName();
                Storage::disk('public') -> put('images/' . $fname, $file -> get());
                $validated['image'] = $fname;
            }else{
                $validated['image'] = $team->image;
            }

            $team-> users()->sync($request->id);

            Session::flash('team-updated');

        return to_route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
