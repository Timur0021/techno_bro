<?php

namespace Modules\Team\GraphQL\Mutations\Auth;

use GraphQL\Error\Error;
use Modules\Team\Services\AuthService;
use Exception;

class Login
{
    /**
     *
     * @var AuthService
     */
    protected AuthService $authService;

    /**
     *
     * @return void
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     * @throws Error
     * @throws Exception
     */
    public function __invoke(null $_, array $args)
    {
        try {
            $email = $args['email'];
            $password = $args['password'];
            $remember_me = $args['remember_me'] ?? false;

            return $this->authService->login($email, $password, $remember_me);
        } catch (Exception $exception) {
            throw new Error($exception->getMessage());
        }
    }
}
