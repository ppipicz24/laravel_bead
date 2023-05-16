<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Team;
use \App\Models\User;
use \App\Models\Event;
use \App\Models\Game;
use \App\Models\Player;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = collect();
        $userCount = rand(10,15);
        $users -> add(User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@szerveroldali.hu',
            'password' => 'adminpwd',
            'is_admin' => true
        ]));

        for($i = 2; $i <= $userCount; $i++){
            $users -> add(User::factory()->create([
             'email' => 'user' . $i . '@szerveroldali.hu',
             'password' => 'password'
            ]));
        }

        $teams = collect();
        $teamCount = rand(10,15);
        for($i = 1; $i <= $teamCount; $i++){
            $t = Team::factory() -> create();
            $t -> users() -> sync($users -> random( rand(1, $users -> count())) -> pluck('id'));
            $teams -> add($t);
        }


        $players = collect();
        $playerCount = rand(35,40);
        for($i = 1; $i <= $playerCount; $i++){
            $p =Player::factory()->create([
                'team_id' => $teams-> random() -> id
            ]);
            $players -> add($p);
        }

        $games = collect();
        $gameCount = rand(20,25);
        
        for($i = 1; $i <= $gameCount; $i++){
            $g= Game::factory()->create([
                'home_team_id' => $teams->random()->id,
                'away_team_id' => $teams->random()->id
            ]);

            if($g->start < now()->subMinutes(90)){
                $g->finished = true;
                $g->save();
            }
            else{
                $g->finished = false;
                $g->save();
            }
            
            while($g->home_team_id == $g->away_team_id){
                $g->away_team_id = $teams->random()->id;
                $g->save();
            }
            $games -> add($g);
        }

        $events = collect();
        $eventCount = rand(20,25);
        for($i = 1; $i <= $eventCount; $i++){
            $e = Event::factory()->create([
                'player_id' => $players->random()->id,
                'game_id' => $games->random()->id
            ]);
            $events -> add($e);
        }
    }

}