<?php

namespace Module\Message\Core;

use App\User;
class MessageAutomateSetting
{
    public function getAutomateTemplate(User $user, AutomateScenarioEnum $scenario): MessageTemplate
    {
        throw new \RuntimeException();
    }
    public function setAutomateTemplate(User $user, MessageTemplate $template): void
    {
    }
}
