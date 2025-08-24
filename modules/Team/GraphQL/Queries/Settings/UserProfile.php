<?php

namespace Modules\Team\GraphQL\Queries\Settings;

use Illuminate\Contracts\Auth\Authenticatable;

class UserProfile
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     */
    public function __invoke(null $_, array $args): ?Authenticatable
    {
        return auth()->user();
    }
}
