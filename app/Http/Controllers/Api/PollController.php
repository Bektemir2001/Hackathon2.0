<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Telegram\PollService;
use Illuminate\Http\Request;

class PollController extends Controller
{
    protected PollService $pollService;

    public function __construct(PollService $pollService)
    {
        $this->pollService = $pollService;
    }

    public function get()
    {
        $result = $this->pollService->get();
        return response($result);
    }
}
