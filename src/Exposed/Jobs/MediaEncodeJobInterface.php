<?php

namespace Jfs\Exposed\Jobs;

interface MediaEncodeJobInterface
{
    public function encode(string $id, string $username, $forceCheckAccelerate);
}
