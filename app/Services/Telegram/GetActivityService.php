<?php

namespace App\Services\Telegram;


use Carbon\Carbon;
use GuzzleHttp\Client;

class GetActivityService extends Telegram
{


    public function get()
    {
        try{
            $currentDateTime = Carbon::now();
            $last24Hours = [];
            for ($i = 15; $i >= 0; $i--) {
                $last24Hours[$currentDateTime->copy()->subHours($i)->format('Y-m-d H')] = 0;
            }
            $response = $this->client->get(env('TELEGRAM_LINK') . 'getUpdates');
            $result = json_decode($response->getBody(), true);
            $data = $result['result'];

            $groupedData = collect($data)->groupBy(function ($item) {
                $arr = array_values($item);

                if (!array_key_exists('date', $arr[1])) {
                    return null;
                }
                return Carbon::createFromTimestamp($arr[1]['date'])->format('Y-m-d H');
            });
            $counts = collect($last24Hours)->mapWithKeys(function ($value, $hour) use ($groupedData) {
                return [$hour => $groupedData->has($hour) ? count($groupedData[$hour]) : 0];
            });
            return ['result' => $counts, 'code' => 200];
        }
        catch (\Exception $e)
        {
            return ['result' => $e->getMessage(), 'code' => $e->getCode()];
        }

    }
}
