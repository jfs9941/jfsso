<?php

namespace Module\Post\Model;

use App\Model\Post as BasePost;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Post extends BasePost
{
    public function activeComments(): HasMany
    {
        throw new \RuntimeException();
    }
}
