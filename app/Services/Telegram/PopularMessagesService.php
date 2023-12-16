<?php

namespace App\Services\Telegram;

class PopularMessagesService extends Telegram
{
    public function get()
    {
        try{
            $response = $this->client->get(env('TELEGRAM_LINK') . 'getUpdates');
            $result = json_decode($response->getBody(), true);
            $data = $result['result'];
            $popular_messages = [];
            foreach ($data as $item)
            {
                if(array_key_exists('message', $item))
                {
                    if(array_key_exists('reply_to_message', $item['message']))
                    {
                        if(array_key_exists($item['message']['reply_to_message']['message_id'], $popular_messages))
                        {
                            $popular_messages[$item['message']['reply_to_message']['message_id']]['count'] += 1;
                        }
                        else{
                            $popular_messages[$item['message']['reply_to_message']['message_id']] = ['text' => $item['message']['reply_to_message']['text'], 'count' => 1];
                        }
                    }
                }
            }
            usort($popular_messages, function ($a, $b) {
                return $b['count'] - $a['count'];
            });

            $top10 = array_slice($popular_messages, 0, 10);
            return ['result' => $top10, 'code' => 200];
        }
        catch (\Exception $e)
        {
            return ['result' => $e->getMessage(), 'code' => $e->getCode()];
        }

    }
}
