<?php

namespace Module\Message\Http\Controller;

use App\Http\Controllers\Controller;
use App\Model\Attachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\Message\Core\AutomateScenarioEnum;
use Module\Message\Core\MessageAutomateSetting;
use Module\Message\Core\MessageTemplate;
use Module\Message\Http\Request\ToggleSetting;
class MessageAutomateController extends Controller
{
    public function storeSetting(Request $request): JsonResponse
    {
        throw new \RuntimeException();
    }
    public function toggleSetting(ToggleSetting $request): JsonResponse
    {
        throw new \RuntimeException();
    }
}
