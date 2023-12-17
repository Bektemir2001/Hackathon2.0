<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\DB;

class ActiveUsersService extends Telegram
{
    public function get()
    {
        try{
            $response = $this->client->get(env('TELEGRAM_LINK') . 'getUpdates');
            $result = json_decode($response->getBody(), true);
            $data = $result['result'];
            $active_users = [];
            foreach ($data as $item)
            {
                if(array_key_exists('message', $item))
                {
                    if(array_key_exists($item['message']['from']['username'], $active_users))
                    {
                        $active_users[$item['message']['from']['username']]['count'] += 1;
                    }
                    else{
                        $active_users[$item['message']['from']['username']]['count'] = 1;
                        $active_users[$item['message']['from']['username']]['user'] = DB::table('employee')
                        ->join('employee_social_medias as e', 'employee.id', '=', 'e.employee_id')
                        ->where('e.social_medias_key', '=', 'TELEGRAM')
                        ->where('e.social_medias', '=', $item['message']['from']['username'])
                        ->select('employee.id', 'employee.firstname', 'employee.lastname')->first();
                    }
                }

            }


            uasort($active_users, function ($a, $b) {
                return $b['count'] - $a['count'];
            });

            return ['result' => $active_users, 'code' => 200];
        }
        catch (\Exception $e)
        {
            return ['result' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }
}
