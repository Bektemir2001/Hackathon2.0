<?php

namespace App\Services\Telegram;

class PollService extends Telegram
{
    public function get()
    {
        try{
            $response = $this->client->get(env('TELEGRAM_LINK') . 'getUpdates');
            $result = json_decode($response->getBody(), true);
            $data = $result['result'];
            $polls = [];

            foreach ($data as $item)
            {
                if(array_key_exists('poll', $item))
                {
                    $is_new = true;
                    for($i = 0; $i < count($polls); $i++)
                    {
                        if($polls[$i]['poll']['id'] == $item['poll']['id'])
                        {
                            $polls[$i] = $item;
                            $is_new = false;
                            break;
                        }
                    }
                    if($is_new == true)
                    {
                        $polls[] = $item;
                    }


                }

            }

            return ['result' => $polls, 'code' => 200];
        }
        catch (\Exception $e)
        {
            return ['result' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }
}
