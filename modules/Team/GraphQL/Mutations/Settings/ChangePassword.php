<?php

namespace Modules\Team\GraphQL\Mutations\Settings;

use GraphQL\Error\Error;
use Modules\Team\Services\UserService;

class ChangePassword
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
            $password = $args['password'];
            $password_confirmation = $args['password_confirmation'];
            $user = auth()->user();

            return $this->userService->changePassword($user, $password, $password_confirmation);
        } catch (Error $error) {
            throw new Error($error->getMessage());
        }
    }
}
