<?php

namespace Modules\Blog\GraphQL\Queries;

use Error;
use Modules\Blog\Models\Blog as BlogModel;

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
            $blogs = BlogModel::query()
                 ->where('active', true)
                 ->latest('created_at')
                 ->get();

            return [
                'data' => $blogs,
            ];
        } catch (Error $error) {
            throw new Error($error->getMessage());
        }
    }
}
