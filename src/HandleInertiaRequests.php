<?php

namespace Module;

use App\Providers\DashboardServiceProvider;
use Illuminate\Http\Request;
use Inertia\Middleware;
class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';
    public function version(Request $request): ?string
    {
        return null;
    }
    public function share(Request $request): array
    {
        return [];
    }
}
