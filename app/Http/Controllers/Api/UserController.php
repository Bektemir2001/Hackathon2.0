<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Telegram\ActiveUsersService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected ActiveUsersService $activeUsersService;
    public function __construct(ActiveUsersService $activeUsersService)
    {
        $this->activeUsersService = $activeUsersService;
    }

    public function getActiveUsers()
    {
        return response($this->activeUsersService->get());
    }
}
