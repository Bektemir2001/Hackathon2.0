<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Telegram\DistributionService;
use App\Services\Telegram\GetActivityService;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    protected GetActivityService $activityService;
    protected DistributionService $distributionService;
    public function __construct(GetActivityService $activityService, DistributionService $distributionService)
    {
        $this->activityService = $activityService;
        $this->distributionService = $distributionService;
    }

    public function getActivity()
    {
        $result = $this->activityService->get();
        return response($result);
    }

    public function distribution()
    {
        dd($this->distributionService->distribution());
    }
}
