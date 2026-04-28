<?php

namespace Module\UserAction\Controller;

use App\Http\Controllers\Controller;
use App\Model\UserList;
use App\Model\UserListMember;
use App\Providers\ListsHelperServiceProvider;
use App\User;
use Illuminate\Support\Facades\Auth;
class ApiBlockUserController extends Controller
{
    public function toggle(string $userId)
    {
        return null;
    }
}
