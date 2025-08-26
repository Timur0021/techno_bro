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
            $page = $args['page'] ?? 1;
            $limit = $args['limit'] ?? 10;

            $blogs = BlogModel::query()
                ->where('active', true)
                ->latest('created_at')
                ->paginate($limit, ['*'], 'page', $page);

            return [
                'data' => $blogs->items(),
                'paginatorInfo' => [
                    'currentPage' => $blogs->currentPage(),
                    'lastPage' => $blogs->lastPage(),
                    'total' => $blogs->total(),
                    'firstItem' => $blogs->firstItem(),
                    'lastItem' => $blogs->lastItem(),
                ],

            ];
        } catch (Error $error) {
            throw new Error($error->getMessage());
        }
    }
}
