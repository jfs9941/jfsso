<?php

namespace Module\Profile\Model;

use App\Model\Post as BasePost;
use Illuminate\Database\Eloquent\Relations\HasMany;
class ProfilePost extends BasePost
{
    public function scopeForProfile($query)
    {
        return null;
    }
    public function scopeWithMedia($query)
    {
        return null;
    }
    public function scopeLatest($query)
    {
        return null;
    }
    public function toProfileArray(): array
    {
        return [];
    }
    protected function formatAttachment($attachment): array
    {
        return [];
    }
}
