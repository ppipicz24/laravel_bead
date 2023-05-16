@php
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
@endphp
<x-guest-layout>

@auth
    @if (Auth::user()->name == 'admin')
    <button type="submit" class="p-2 inline-block mb-4 bg-red-900 hover:bg-red-700 text-white"><a href="{{ route('teams.edit', [ 'team' => $team]) }}">Csapat szerkesztése</a></button>
    @endif
@endauth

    <h2>{{$team->name}} mérkőzései</h2>


    <table>
            <th>Kezdési idő</th>
            <th></th>
            <th>Hazai csapat</th>
            <th>Eredmény</th>
            <th>Vendég csapat</th>
            <th></th>

            @foreach($games as $game)      
            @if($game->home_team_id == $team->id || $game->away_team_id==$team->id)
            <tr>
                <td>{{ $game->start }}</td>
                @foreach($teams as $t)
                @if($game->home_team_id == $t->id)
                @if ($t -> image === null)
            <td><img src="https://via.placeholder.com/50x50/c47bd1/000000?text=Sport"></td>
            
            @else
            <td><img src="{{ $t->image}}"></td>
            @endif
    
                <td>{{ $t->name }}</td>
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

                @foreach($teams as $t)
                @if($game->away_team_id == $t->id)
                <td>{{ $t->name }}</td>
                @if ($t -> image === null)
            <td><img src="https://via.placeholder.com/50x50/c47bd1/000000?text=Sport"></td>
            @else
            <td><img src="{{ $t->image}}"></td>
            @endif
                @endif
                @endforeach


            </tr>
                @endif
                @endforeach


</table>

<h2>Játékosok</h2>

<!--A csapatban lévő összes játékos adatai: neve, születési dátuma, statisztikái (hány gólt, öngólt rúgott, illetve hány sárga és piros lapot kapott)-->
<table>
    <th>Név</th>
    <th>Születési dátum</th>
    <th>Gól</th>
    <th>Öngól</th>
    <th>Sárga lap</th>
    <th>Piros lap</th>
    @auth
    @if (Auth::user()->name == 'admin')
    <th></th>
    @endif
    @endauth

    @foreach($players as $player)
    @if($player->team_id == $team->id)
    <tr>
        <td>{{ $player->name }}</td>
        <td>{{ $player->birthdate }}</td>
        @php
        $countg=0;
        $counts=0;
        $countp=0;
        $countsg=0;
        foreach($games as $game)
        {
        if($game->home_team_id == $team->id || $game->away_team_id ==  $team->id)
        {
        foreach($events as $event)
        {
        if($event->player_id == $player->id)
        {
        if($event->type == 'goal')
        {
            $countg++;
        }
        if($event->type == "self goal")
        {
            $countsg++;
        }
        if($event->type == "yellow card")
        {
            $counts++;
        }
        if($event->type=="red card")
        {
            $countp++;
        }
    }}}}
    @endphp
    <td>{{$countg}}</td>
    <td>{{$countsg}}</td>
    <td>{{$counts}}</td>
    <td>{{$countp}}</td>
    @auth
    @if (Auth::user()->name == 'admin')
    @if($countg==0 && $counts==0 && $countp==0 && $countsg==0)
    <td><form action="{{ route('players.destroy', ['player' => $player])}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-block p-2 mb-4 bg-red-700 hover:bg-red-900 text-white">Törlés</button>
    </form>
    @endif
    @endif
    @endauth
    </tr>
    @endif
    @endforeach
</table>
@auth
    @if (Auth::user()->name == 'admin')
<button type="submit" class="p-2 inline-block mb-4 bg-red-900 hover:bg-red-700 text-white"><a href="{{ route('players.create') }}">Új játékos hozzáadása</a></button>
@endif
@endauth

</x-guest-layout>