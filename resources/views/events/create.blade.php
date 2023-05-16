<x-guest-layout>

    <h2>Új esemény hozzáadása</h2>
    
    <form action="{{route('events.store', ['game'=>$game])}}" method="POST" enctype="multipart/form-data">
        @csrf
    
        Mérkőzés: <select name="game_id">
        <option value="{{$game->id}}">{{$game->home_team_id}} - {{$game->away_team_id}}</option>
        
    </select><br>
    Perc: <input type="number" name="minute" value="{{old('minute')}}"><br>
    @error('minute')
    {{ $message }}
    @enderror
    Esemény típusa: <select name="type">
        <option value="goal">Gól</option>
        <option value="self goal">Öngól</option>
        <option value="yellow card">Sárga lap</option>
        <option value="red card">Piros lap</option>
    </select>
    <br>

    @error('type')
    {{ $message }}
    @enderror


    Játékos: 
    <select name="player_id">
        @foreach($players as $player)
        <option value="{{$player->number}}">{{$player->name}}</option>
        @endforeach

    </select>
    <br>

    <button type="submit" class="p-2 inline-block bg-sky-900 hover:bg-sky-700 text-white">Mentés</button>

    </form>
</x-guest-layout>