@php
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
@endphp
<x-guest-layout>
@auth
    @if (Auth::user()->name == 'admin')
<button type="submit" class="p-2 inline-block mb-4 bg-red-900 hover:bg-red-700 text-white">
        <a href="{{route('games.edit', ['game'=>$game])}}">Mérkőzés szerkesztése</a>
    </button>
@endif
@endauth
    <table>
        <th>Kezdési időpont</th>
        <th></th>
        <th>Hazai csapat</th>
        <th>Eredmény</th>
        <th>Vendég csapat</th>
        <th></th>

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

        </tr>
    </table>

    <h2>Események</h2>
    <table>
        <th>Perc</th>
        <th>Csapat</th>
        <th>Név</th>
        <th>Esemény</th>
        @auth
    @if (Auth::user()->name == 'admin')
        <th></th>
    @endif
    @endauth
        @foreach($events as $event)
        @if($game->id==$event->game_id)
                <tr>
                    <td>{{$event->minute}}. perc</td>

                    @foreach($players as $player)
                    @if($event->player_id == $player->id)
                    @foreach($teams as $team)
                    @if($player->team_id==$team->id)
                    <td>{{$team->name}}</td>
                    @endif
                    @endforeach
                    <td>{{$player->name}}</td>
                    @endif
                    @endforeach

                    <td>{{$event->type}}</td>
                    @auth
                    @if (Auth::user()->name == 'admin')
                    @if($game->finished==false)
                    <td>
                        <form action="{{ route('events.destroy', ['event' => $event])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-block p-2 mb-4 bg-red-700 hover:bg-red-900 text-white">Törlés</button>
                        </form>
                    </td>

                    @endif

                    @endif
                    @endauth
                </tr>
        @endif
        @endforeach

    </table>

    @auth
    @if (Auth::user()->name == 'admin')
    <button type="submit" class="p-2 inline-block mb-4 bg-red-900 hover:bg-red-700 text-white">
        <a href="{{route('events.create')}}">Új esemény hozzáadása</a>
    </button>

    @php
    $eventss = App\Models\Event::all()->where('game_id', $game->id)->count();
@endphp
    @if($eventss == 0)
        <form action="{{ route('games.destroy', ['game' => $game])}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-block p-2 mb-4 bg-red-700 hover:bg-red-900 text-white">Törlés</button>
    </form>
    @endif
    @endif
    @endauth


   

</x-guest-layout>