<?php

namespace Modules\Blog\GraphQL\Queries;

use GraphQL\Error\Error;
use Modules\Blog\Models\Blog as BlogModel;

class Blog
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     * @throws Error
     */
    public function __invoke(null $_, array $args)
    {
        try {
            return BlogModel::query()
                ->where('slug', $args['slug'])
                ->first();
        } catch (Error $error) {
            throw new Error($error->getMessage());
        }
    }
}
