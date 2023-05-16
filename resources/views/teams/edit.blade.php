<x-guest-layout>

<h2>{{$team -> name}} szerkesztése</h2>

<form action="{{ route('teams.update', ['team' => $team]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    
    Név: <input type="text" name="name" value="{{old('name')}}"><br>
    @error('name')
    {{ $message }}
    @enderror
    Név rövidítése: <input type="text" name="shortname" value="{{old('shortname')}}"><br>
    @error('shortname')
    {{ $message }} 
    @enderror
    Logo: <input type="file" name="image"><br>
    @error('file')
    {{ $message }}
    @enderror
    <br>

    <button type="submit" class="p-2 inline-block bg-sky-900 hover:bg-sky-700 text-white">Mentés</button>

    </form>
</x-guest-layout>