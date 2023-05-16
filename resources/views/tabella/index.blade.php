<?php
$teams = App\Models\Team::all();
$gevents=App\Models\Event::all()->where('type','goal');
$sgevents=App\Models\Event::all()->where('type','self goal');?>

<x-guest-layout>
<h2>Tabella</h2>

<table>
    <th></th>
        <th>Hely</th>
        <th>Név</th>
        <th>Lejátszott mérkőzés</th>
        <th>Győzelem</th>
        <th>Döntetlen</th>
        <th>Vereség</th>
        <th>Lőtt gól</th>
        <th>Kapott gól</th>
        <th>Gólkülönbség</th>
        <th>Pont</th>
        @php
            $hely=0;
            @endphp
        @foreach($teams as $team)
        @php
        $hely++
        @endphp
        <?php

$sum=App\Models\Game::all()->where('finished', true)->where('home_team_id',$team->id)->count() + App\Models\Game::all()->where('finished',true)->where('away_team_id',$team->id)->count();

foreach($gevents as $ge){
$homegoals1=App\Models\Game::all()->where('finished',true)->where('home_team_id',$team->id)->where('id',$ge->game_id)->count();
$awaygoals1=App\Models\Game::all()->where('finished',true)->where('away_team_id',$team->id)->where('id',$ge->game_id)->count();
}

foreach($sgevents as $sge){
$homegoals2=App\Models\Game::all()->where('finished',true)->where('home_team_id',$team->id)->where('id',$sge->game_id)->count();
$awaygoals2=App\Models\Game::all()->where('finished',true)->where('away_team_id',$team->id)->where('id',$sge->game_id)->count();
}

$homegoals=$homegoals1+$homegoals2;
$awaygoals=$awaygoals1+$awaygoals2;
$goals=$homegoals+$awaygoals;

$win1=0;
$win2=0;
$lose1=0;
$lose2=0;
$draw1=0;
$draw2=0;

if($homegoals>$awaygoals){
    $win1=App\Models\Game::all()->where('finished',true)->where('home_team_id',$team->id)->count();
    $lose1=App\Models\Game::all()->where('finished',true)->where('away_team_id',$team->id)->count();
}
if($homegoals<$awaygoals){
    $win2=App\Models\Game::all()->where('finished',true)->where('away_team_id',$team->id)->count();
    $lose2=App\Models\Game::all()->where('finished',true)->where('home_team_id',$team->id)->count();
}
if($homegoals==$awaygoals){
    $draw1=App\Models\Game::all()->where('finished',true)->where('home_team_id',$team->id)->count();
    $draw2=App\Models\Game::all()->where('finished',true)->where('away_team_id',$team->id)->count();
}

$win=$win1+$win2;
$lose=$lose1+$lose2;
$draw=$draw1+$draw2;

$point=$win*3+$draw;
$gk=$homegoals-$awaygoals;

//pont alapján csökkenő sorrend
$tomb[$team->id]=$point;
$valami=arsort($tomb);
$sorted=array_keys($tomb);
$sorted2=array_values($tomb);






?>

<tr>
@auth
            <td><a href="{{route('kedvencek.index', ['team'=> $team])}}" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">

    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
</svg></a></td>
            @else
            <td><a href="{{route('login')}}" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">

    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
</svg></a></td>
            @endauth
    <td>{{$hely}}</td>
    <td>{{$team->name}}</td>
    <td>{{$sum}}</td>
    <td>{{$win}}</td>
    <td>{{$draw}}</td>
    <td>{{$lose}}</td>
    <td>{{$homegoals}}</td>
    <td>{{$awaygoals}}</td>
    <td>{{$gk}}</td>
    <td>{{$point}}</td>
    
    
    
</tr>
@endforeach
</table>

<table>
    @php

$hely2=0
@endphp
@foreach($sorted as $sort)
@foreach($teams as $team)
@if($sort==$team->id)
@php
$hely2++
@endphp
<tr>
<td>{{$hely2}}</td>
<td>{{$team->name}}</td>
<td>{{$sum}}</td>
    <td>{{$win}}</td>
    <td>{{$draw}}</td>
    <td>{{$lose}}</td>
    <td>{{$homegoals}}</td>
    <td>{{$awaygoals}}</td>
    <td>{{$gk}}</td>
    <td>{{$points}}</td>
<tr>
@endif
@endforeach
@endforeach

</table>
<br>

@foreach($sorted2 as $sort2)
{{$sort2}}
@endforeach
</x-guest-layout>