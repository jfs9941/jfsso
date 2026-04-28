<?php

namespace Module\Post\Controller;

use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Reaction;
use App\Providers\NotificationServiceProvider;
use Illuminate\Support\Facades\Auth;
class ApiPostLikeController extends Controller
{
    public function like(string $postId)
    {
        return null;
    }
    public function unlike(string $postId)
    {
        return null;
    }
}
