@php
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

@endphp

<x-guest-layout>

<div class="text-2xl text-center bg-green-800 rounded-lg shadow-md shadow-green-500 mb-4 text-white">
    @if (Session::get('event-created'))
    <p class="p-2">Az esemény sikeresen létrehozva!</p>
    @endif
    @if (Session::get('event-deleted'))
    <p class="p-2">Az esemény sikeresen törölve!</p>
    @endif
</div>

<div class="text-2xl text-center bg-green-800 rounded-lg shadow-md shadow-green-500 mb-4 text-white">
    @if (Session::get('game-created'))
    <p class="p-2">A mérkőzés sikeresen létrehozva!</p>
    @endif
    @if (Session::get('game-updated'))
    <p class="p-2">A mérkőzés sikeresen módosítva!</p>
    @endif
    @if (Session::get('game-deleted'))
    <p class="p-2">A mérkőzés sikeresen törölve!</p>
    @endif
</div>


    @auth
    @if (Auth::user()->name == 'admin')
    <button type="submit" class="p-2 inline-block mb-4 bg-red-900 hover:bg-red-700 text-white"><a href="{{ route('games.create') }}">Új mérkőzés hozzáadása</a></button>
    @endif
    @endauth

    <h2>A mérkőzések listája</h2>

    <h3>A még jelenleg is tartó mérkőzések listája</h3>

    <table>
            <th>Kezdési idő</th>
            <th></th>
            <th>Hazai csapat</th>
            <th>Eredmény</th>
            <th>Vendég csapat</th>
            <th></th>
            <th></th>
            @foreach ($games as $game)
            @if(($game->finished==false && ($game->start < now() && Carbon::parse($game->start)->addMinute(90) > now())))
            <tr>

                <td>{{ $game->start }}</td>
                @foreach ($teams as $team)
                    @if ($game->home_team_id == $team->id)
                    @if ($team -> image === null)
            <td><img src="https://via.placeholder.com/50x50/c47bd1/000000?text=Sport"></td>
            @else
            <td><img src="{{ $team->image}}"></td>
            @endif
                        <td>{{ $team->name }}</td>
                    @endif
                @endforeach
                @php
                    $home_team_goals = 0;
                    $away_team_goals = 0;
                    foreach ($events as $event){
                        if ($event->game_id == $game->id)
                        {
                            if ($event->type == 'goal')
                            {
                                foreach ($players as $player)
                                {
                                    if ($event->player_id == $player->id)
                                    {
                                        foreach ($teams as $team)
                                        {
                                            if ($player->team_id == $team->id)
                                            {
                                                if ($team->id == $game->home_team_id)
                                                {
                                                    $home_team_goals++;
                                                }
                                                else
                                                    $away_team_goals++;
                                            }
                                        }
                                    }
                                }
                            }
                            else if ($event->type == 'self goal')
                            {
                                foreach ($players as $player)
                                {
                                    if ($event->player_id == $player->id)
                                    {
                                        foreach ($teams as $team)
                                        {
                                            if ($player->team_id == $team->id)
                                            {
                                                if ($team->id == $game->home_team_id)
                                                {
                                                    $away_team_goals++;
                                                }
                                                else
                                                    $home_team_goals++;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                                                
                @endphp

                <td>{{ $home_team_goals }} - {{ $away_team_goals }}</td>
                @foreach ($teams as $team)
                    @if ($game->away_team_id == $team->id)
                        <td>{{ $team->name }}</td>
                        @if ($team -> image === null)
            <td><img src="https://via.placeholder.com/50x50/c47bd1/000000?text=Sport"></td>
            @else
            <td><img src="{{ $team->image}}"></td>
            @endif
                    @endif
                @endforeach

                <td><a href="{{ route('games.show', $game->id) }}">Részletek</a></td>


            </tr>
            @endif
            @endforeach
    </table>
        <div>
    <br><h3>Az összes mérkőzés</h3>
        <table>
            <th>Kezdési idő</th>
            <th></th>
            <th>Hazai csapat</th>
            <th>Eredmény</th>
            <th>Vendég csapat</th>
            <th></th>
            <th></th>
            @foreach ($games as $game)
            <tr>

                <td>{{ $game->start }}</td>
                @foreach ($teams as $team)
                @if($game->home_team_id == $team->id)
                @if ($team -> image === null)
            <td><img src="https://via.placeholder.com/50x50/c47bd1/000000?text=Sport"></td>
            @else
            <td><img src="{{ $team->image}}"></td>
            @endif
                <td>{{ $team->name }}</td>
                @endif
                @endforeach
                
                @if(($game->finished==false && ($game->start < now() && Carbon::parse($game->start)->addMinute(90) > now())) || $game->finished == true)
                @php
                    $home_team_goals = 0;
                    $away_team_goals = 0;
                    foreach ($events as $event){
                        if ($event->game_id == $game->id)
                        {
                            if ($event->type == 'goal')
                            {
                                foreach ($players as $player)
                                {
                                    if ($event->player_id == $player->id)
                                    {
                                        foreach ($teams as $team)
                                        {
                                            if ($player->team_id == $team->id)
                                            {
                                                if ($team->id == $game->home_team_id)
                                                {
                                                    $home_team_goals++;
                                                }
                                                else
                                                    $away_team_goals++;
                                            }
                                        }
                                    }
                                }
                            }
                            else if ($event->type == 'self goal')
                            {
                                foreach ($players as $player)
                                {
                                    if ($event->player_id == $player->id)
                                    {
                                        foreach ($teams as $team)
                                        {
                                            if ($player->team_id == $team->id)
                                            {
                                                if ($team->id == $game->home_team_id)
                                                {
                                                    $away_team_goals++;
                                                }
                                                else
                                                    $home_team_goals++;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                                                
                @endphp

                <td>{{ $home_team_goals }} - {{ $away_team_goals }}</td>
                @else
                <td>-</td>
                @endif

                @foreach ($teams as $team)
                @if ($game->away_team_id == $team->id)
                <td>{{ $team->name }}</td>
                @if ($team -> image === null)
            <td><img src="https://via.placeholder.com/50x50/c47bd1/000000?text=Sport"></td>
            @else
            <td><img src="{{ $team->image}}"></td>
            @endif
                @endif
                @endforeach
                <td><a href="{{ route('games.show', $game->id) }}">Részletek</a></td>
            </tr>
            @endforeach
    </table>

    <br><h3>A már befejezett mérkőzések listája</h3>
    <table>
            <th>Kezdési idő</th>
            <th></th>
            <th>Hazai csapat</th>
            <th>Eredmény</th>
            <th>Vendég csapat</th>
            <th></th>
            <th></th>
            @foreach ($games as $game)
            @if($game->finished==true)
            <tr>
                <td>{{ $game->start }}</td>
                @foreach ($teams as $team)
                @if ($game->home_team_id == $team->id)
                @if ($team -> image === null)
            <td><img src="https://via.placeholder.com/50x50/c47bd1/000000?text=Sport"></td>
            @else
            <td><img src="{{ $team->image}}"></td>
            @endif
                <td>{{ $team->name }}</td>
                @endif
                @endforeach
                    @php
                        $home_team_goals = 0;
                        $away_team_goals = 0;
                        foreach ($events as $event){
                            if ($event->game_id == $game->id)
                            {
                                if ($event->type == 'goal')
                                {
                                    foreach ($players as $player)
                                    {
                                        if ($event->player_id == $player->id)
                                        {
                                            foreach ($teams as $team)
                                            {
                                                if ($player->team_id == $team->id)
                                                {
                                                    if ($team->id == $game->home_team_id)
                                                    {
                                                    $home_team_goals++;
                                                }
                                                else
                                                    $away_team_goals++;
                                            }
                                        }
                                    }
                                }
                            }
                            else if ($event->type == 'self goal')
                            {
                                foreach ($players as $player)
                                {
                                    if ($event->player_id == $player->id)
                                    {
                                        foreach ($teams as $team)
                                        {
                                            if ($player->team_id == $team->id)
                                            {
                                                if ($team->id == $game->home_team_id)
                                                {
                                                    $away_team_goals++;
                                                }
                                                else
                                                    $home_team_goals++;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                                                
                @endphp

                <td>{{ $home_team_goals }} - {{ $away_team_goals }}</td>
                @foreach ($teams as $team)
                @if ($game->away_team_id == $team->id)
                <td>{{ $team->name }}</td>
                @if ($team -> image === null)
            <td><img src="https://via.placeholder.com/50x50/c47bd1/000000?text=Sport"></td>
            @else
            <td><img src="{{ $team->image}}"></td>
            
            @endif
                @endif
                @endforeach
                <td><a href="{{ route('games.show', $game->id) }}">Részletek</a></td>
            </tr>
            @endif
            @endforeach
        </table>
    </div>



{{ $games->links()}}
</x-guest-layout>