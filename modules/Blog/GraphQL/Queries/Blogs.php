<?php

namespace Modules\Blog\GraphQL\Queries;

use Error;

class Blogs
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     * @throws Error
     */
    public function __invoke(null $_, array $args)
    {
        try {
            dd('soon');
        } catch (Error $error) {
            throw new Error($error->getMessage());
        }
    }
}
