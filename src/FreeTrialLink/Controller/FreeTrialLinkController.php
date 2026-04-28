<?php

namespace Module\FreeTrialLink\Controller;

use App\Http\Controllers\Controller;
use App\Model\FreeTrialLink;
use App\Model\Post;
use App\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Module\FreeTrialLink\Service\FreeTrialLinkService;
class FreeTrialLinkController extends Controller
{
    public function landing(Request $request, $token)
    {
        return null;
    }
    public function redeem(Request $request)
    {
        return null;
    }
}
