<?php

namespace Module\Profile\Model;

use App\Model\User as BaseUser;
use App\Providers\PostsHelperServiceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;
class ProfileUser extends BaseUser
{
    protected $appends = ['stats', 'relationship'];
    public function getStatsAttribute(): array
    {
        return [];
    }
    public function getRelationshipAttribute(): ?array
    {
        return null;
    }
    public function toProfileArray(): array
    {
        return [];
    }
    public function profilePosts(): HasMany
    {
        throw new \RuntimeException();
    }
}
