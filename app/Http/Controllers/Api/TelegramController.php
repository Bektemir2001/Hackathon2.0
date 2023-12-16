<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Telegram\DistributionService;
use App\Services\Telegram\GetActivityService;

use App\Services\Telegram\PopularMessagesService;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    protected GetActivityService $activityService;
    protected DistributionService $distributionService;
    protected PopularMessagesService $popularMessagesService;
    public function __construct(GetActivityService $activityService, DistributionService $distributionService,
                                PopularMessagesService $popularMessagesService)
    {
        $this->activityService = $activityService;
        $this->distributionService = $distributionService;
        $this->popularMessagesService = $popularMessagesService;
    }

    public function getActivity()
    {
        $result = $this->activityService->get();
        return response($result);
    }

    public function distribution(Request $request)
    {
        $data = $request->validate(
            [
                'text' => 'required',
                'users' => 'required'
            ]
        );
        return response($this->distributionService->distribution($data));
    }

    public function getPopularMessages()
    {
        $result = $this->popularMessagesService->get();
        dd($result);
        return response($result);
    }
}
