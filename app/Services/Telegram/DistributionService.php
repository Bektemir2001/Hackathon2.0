<?php

namespace App\Services\Telegram;

class DistributionService extends Telegram
{
    public function distribution($data)
    {
        $text = $data['text'];
        $data = $data['users'];

        try{
            $response = $this->client->get(env('TELEGRAM_LINK') . 'getUpdates');
            $result = json_decode($response->getBody(), true);
            foreach($result['result'] as $item)
            {
                if(array_key_exists('message', $item))
                {
                    if($item['message']['from']['is_bot'] == false)
                    {
                        if(array_key_exists($item['message']['from']['username'], $data))
                        {
                            $this->sendMessage($text, $item['message']['from']['id']);
                            unset($data[$item['message']['from']['username']]);
                        }
                    }
                }

                if(count($data) == 0){
                    break;
                }
            }


            return ['result' => 'success', 'code' => 200];
        }
        catch (\Exception $e)
        {
            return ['result' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }

    function sendMessage($text, $chat_id)
    {
        $this->client->get(env('TELEGRAM_LINK') . 'sendMessage', [
            'query' => [
                'chat_id' => $chat_id,
                'text' => $text
            ]
        ]);
    }
}
