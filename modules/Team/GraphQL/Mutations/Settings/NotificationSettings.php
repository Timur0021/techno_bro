<?php

namespace Modules\Team\GraphQL\Mutations\Settings;

use GraphQL\Error\Error;
use Modules\Team\Services\UserService;

class NotificationSettings
{
    /**
     *
     * @var UserService
     */
    protected UserService $userService;

    /**
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @throws Error
     */
    public function __invoke(null $_, array $args)
    {
        try {
            $receive_offers = $args['receive_offers'] ?? false;
            $user = auth()->user();

            return $this->userService->notificationSettings($user, $receive_offers);
        } catch (Error $error) {
            throw new Error($error->getMessage());
        }
    }
}
