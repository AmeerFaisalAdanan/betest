<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

use App\Models\User;

use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function randomUser()
    {
        $response = Http::get('https://randomuser.me/api/?results=20');
        return $response->json();
    }

    public function createUser(Request $request)
    {
        $json = $this->randomUser();

        $countMale = 0;
        $countFemale = 0;

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

                if($result['gender'] == 'male')
                {
                    $countMale++;
                } else {
                    $countFemale++;
                }

                $user->save();

                
            }        
        
        }
    
    }

    public function checkKeyExists(){

        $maleKey = 'male';
        $femaleKey = 'female';

        if($redis->exists($maleKey))
        {
            $redis->del($maleKey);
        }
        else{
            return 'Key does not exist';
        }
    }


    public function dailyRecord(){

        // //query today record
        // $todayRecord = DB::table('users')
        //     ->whereDate('created_at', Carbon::today())
        //     ->
        //     ->get();


        // dd($todayRecord);



    }
}
