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
}



?>