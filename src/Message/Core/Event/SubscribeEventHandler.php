<?php

namespace Module\Message\Core\Event;

use App\Providers\MessengerProvider;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Module\Message\Core\AutomateScenarioEnum;
use Module\Message\Core\MessageAutomateSetting;
use Module\Message\Core\Model\AutomatedMessageSent;
use Ramsey\Uuid\Uuid;
use function Ramsey\Uuid\v4;
class SubscribeEventHandler implements ShouldQueue
{
    use InteractsWithQueue;
    public $delay = 5;
    public function handle(SubscribeEvent $event): void
    {
    }
}
