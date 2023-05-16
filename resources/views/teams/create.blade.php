<x-guest-layout>

<h2>Új csapat hozzáadása</h2>

<form action="{{route('teams.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    
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