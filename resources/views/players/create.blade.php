<x-guest-layout>

    <h2>Új játékos hozzáadása</h2>
    
    <form action="{{route('players.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        
        Név: <input type="text" name="name" value="{{old('name')}}"><br>
    @error('name')
    {{ $message }}
    @enderror 
    Mezszám: <input type="number" name="number" value="{{old('number')}}"><br>
    @error('number')
    {{ $message }}
    @enderror
    Csapat: <select name="team_id">
        @foreach($teams as $team)
        <option value="{{$team->id}}">{{$team->name}}</option>
        @endforeach   
    </select><br>
    @error('team_id')
    {{ $message }}
    @enderror

    Születési idő: <input type="date" name="birthdate" value="{{old('birthdate')}}"><br>
    @error('birth_date')
    {{ $message }}
    @enderror

    <br>

    <button type="submit" class="p-2 inline-block bg-sky-900 hover:bg-sky-700 text-white">Mentés</button>

    </form>
</x-guest-layout>