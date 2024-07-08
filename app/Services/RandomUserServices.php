<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class RandomUserServices
{
    public function randomUser()
    {
        $response = Http::get('https://randomuser.me/api/?results=20');
        return $response->json();
    }

    public function createUser(Request $request)
    {
        $json = $this->randomUser();

        foreach ($json['results'] as $result) {

            if(User::where('uuid', $result['login']['uuid'])->exists()) {
                continue;
            } else {

            // dd($user['login']['uuid']);
                $user = new User;

                $user->uuid = $result['login']['uuid'];
                $user->gender = $result['gender'];
                $user->name = json_encode($result['name']);
                $user->location = json_encode($result['location']);
                $user->age = $result['dob']['age'];

                $user->save();
            }        
        
        }
    }

    public function countRecord(){

        //get today date
        $today = date('Y-m-d');

        //get total users

        $getCount = DB::table('users')
                    ->select(DB::raw('gender, COUNT(*) as count'))
                    ->groupBy('gender')
                    ->get();

        // store record of male and female count in redis
        $redis = Redis::connection();

        $redis->set('hourly_record', json_encode([
            'female' => $getCount[0]->count,
            'male' => $getCount[1]->count
            ]
        ));

        //retrieve record from redis
        $record = $redis->get('hourly_record');

        return response()->json([
            'status' => true,
            'data' => json_decode($record)
        ]
        );
    }

    public function eod(){

        $today = date('Y-m-d');

        $redis = Redis::connection();

        $record = $redis->get('hourly_record');
        $malecount = json_decode($record)->male;
        $femalecount = json_decode($record)->female;


        $maleAvgAge = User::whereDate('created_at', $today)
                                    ->where('gender', 'male')
                                    ->avg('age');

        $femaleAvgAge = User::whereDate('created_at', $today)
                                    ->where('gender', 'female')
                                    ->avg('age');



        $getDailyRecord = DailyRecord::where('date', $today)->first();

        if($getDailyRecord == null){

            $dailyCount = new DailyRecord;

            $dailyCount->date = $today;
            $dailyCount->male_count = $malecount;
            $dailyCount->female_count = $femalecount;
            $dailyCount->male_avg_age = round($maleAvgAge, 0);
            $dailyCount->female_avg_age = round($femaleAvgAge, 0);
            $dailyCount->save();

        }
        else{

            $maleUserCount = User::where('gender', 'male')->count();
            $femaleUserCount = User::where('gender', 'female')->count();

            if($maleUserCount != $malecount || $femaleUserCount != $femalecount){
                
                $dailyCount = DailyRecord::where('date', $today)->first();
                
                $dailyCount->date = $today;
                $dailyCount->male_count = $maleUserCount;
                $dailyCount->female_count = $femaleUserCount;
                $dailyCount->male_avg_age = round($maleAvgAge, 0);
                $dailyCount->female_avg_age = round($femaleAvgAge, 0);
                $dailyCount->save();

            }
        }

    }

}



?>