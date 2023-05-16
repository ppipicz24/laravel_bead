<x-guest-layout>

<h2>Új esemény hozzáadása</h2>

<form action="{{route('games.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    Kezdési idő: <input type="datetime-local" name="start" value="{{old('start')}}"><br>
    @error('start')
    {{ $message }}
    @enderror
    <br>
    
    Hazai csapat: <select name="home_team_id">
        @foreach($teams as $team)
        <option value="{{$team->id}}">{{$team->name}}</option>
        @endforeach
    </select><br>
    @error('home_team_id')
    {{ $message }}
    @enderror

    Vendég csapat: <select name="away_team_id">
        @foreach($teams as $team)
        <option value="{{$team->id}}">{{$team->name}}</option>
        @endforeach

    </select><br>

    @error('away_team_id')
    {{ $message }}
    @enderror

    <br>


    
    <button type="submit" class="p-2 inline-block bg-sky-900 hover:bg-sky-700 text-white">Mentés</button>

    </form>
</x-guest-layout>