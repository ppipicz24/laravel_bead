@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
@endphp

<x-guest-layout>

<div class="text-2xl text-center bg-green-800 rounded-lg shadow-md shadow-green-500 mb-4 text-white">
    @if (Session::get('player-created'))
    <p class="p-2">A játékos sikeresen létrehozva!</p>
    @endif
    @if (Session::get('player-deleted'))
    <p class="p-2">A játékos sikeresen törölve!</p>
    @endif
    @if (Session::get('team-updated'))
    <p class="p-2">A csapat sikeresen módosítva!</p>
    @endif
    @if (Session::get('team-created'))
    <p class="p-2">A csapat sikeresen létrehozva!</p>
    @endif

</div>

    <h2>A csapatok listája</h2>

    <table>
        <th></th>
        <th>Név</th>
        <th>Rövidítés</th>
        <th>Logo</th>
        <th>Részletek</th>

        @foreach($teams as $team)
        <tr>
            <!--ha be vagyunk jelentkezve akkor adjuk hozza a kedvencekhez a csapatot ha rákattintunk-->

            @auth
            <td><a href="{{route('kedvencek.index', ['team'=> $team])}}" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">

    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
</svg></a></td>
            @else
            <td><a href="{{route('login')}}" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">

    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
</svg></a></td>
            @endauth

            <td>{{$team->name}}</td>
            <td>{{$team->shortname}}</td>
            @if ($team -> image === null)
            <td><img src="https://via.placeholder.com/50x50/c47bd1/000000?text=Sport"></td>
            @else
            <td><img src="{{ $team->image}}"></td>
            @endif

            <td><a href="{{ route('teams.show', $team->id) }}">Részletek</td>
        </tr>
        @endforeach


</table>

@auth
    @if (Auth::user()->name == 'admin')
    <button type="submit" class="p-2 inline-block mb-4 bg-red-900 hover:bg-red-700 text-white"><a href="{{ route('teams.create') }}">Új csapat hozzáadása</a></button>
    @endif
@endauth
</x-guest-layout>