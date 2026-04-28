<?php

namespace Module\FreeTrialLink\Service;

use App\Model\FreeTrialLink;
use App\Model\FreeTrialRegister;
use App\Model\Subscription;
use App\Model\Transaction;
use App\Providers\NotificationServiceProvider;
use App\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class FreeTrialLinkService
{
    public function validateToken(string $token): ?FreeTrialLink
    {
        return null;
    }
    public function isLinkActive(FreeTrialLink $link): bool
    {
        return false;
    }
    public function canRedeem(FreeTrialLink $link, int $userId): array
    {
        return [];
    }
    public function redeemAfterRegistration(string $token, int $userId): array
    {
        return [];
    }
    protected function createTransactionRecord(Subscription $subscription, FreeTrialLink $freeTrialLink): ?Transaction
    {
        return null;
    }
    public function getTokenFromSession($request): ?string
    {
        return null;
    }
    public function clearTokenFromSession($request): void
    {
    }
    public function storeTokenInSession($request, string $token): void
    {
    }
    public function findPendingRegistration(int $userId): ?FreeTrialRegister
    {
        return null;
    }
    public function findPendingRegistrationByEmail(string $email): ?FreeTrialRegister
    {
        return null;
    }
}
