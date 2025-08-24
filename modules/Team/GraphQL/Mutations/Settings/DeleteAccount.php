<?php

namespace Modules\Team\GraphQL\Mutations\Settings;

use Exception;
use GraphQL\Error\Error;
use Modules\Team\Services\UserService;

class DeleteAccount
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
     * @throws Exception
     */
    public function __invoke(null $_, array $args)
    {
        try {
            $user = auth()->user();

            return $this->userService->deleteAccount($user);
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}
