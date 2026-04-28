<?php

namespace Module\Message\Core;

use App\Model\Attachment;
use Module\Message\Core\Model\AutomatedMessageSent;
final class MessageTemplate
{
    public function __construct(public bool $enabled, public AutomateScenarioEnum $scenario, public string $message, public array $attachments = [], public int $price = 0)
    {
    }
    public function buildHtmlTemplate()
    {
        return null;
    }
    public function shouldSendMessage($sender, $receiver): bool
    {
        return false;
    }
    public function emptyContent(): bool
    {
        return false;
    }
    public function getAttachments()
    {
        return null;
    }
}
