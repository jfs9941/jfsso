<?php

namespace Module\FreeTrialLink\Controller;

use App\Http\Controllers\Controller;
use App\Model\FreeTrialLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class FreeTrialLinkManagerController extends Controller
{
    public function index()
    {
        return null;
    }
    public function store(Request $request)
    {
        return null;
    }
    public function update(Request $request, $id)
    {
        return null;
    }
    public function destroy($id)
    {
        return null;
    }
    private function generateUniqueHash(): string
    {
        return '';
    }
    public function generateSignupLink(Request $request): JsonResponse
    {
        throw new \RuntimeException();
    }
}
