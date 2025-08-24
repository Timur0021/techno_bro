<?php

namespace Modules\Team\GraphQL\Mutations\Auth;

use GraphQL\Error\Error;
use Modules\Team\Services\AuthService;

class SetNewPassword
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
     * @param $_
     * @param array $args
     * @return array
     * @throws Error
     */
    public function __invoke(null $_, array $args)
    {
        try {
            $token = $args['token'];
            $password = $args['password'];
            $password_confirmation = $args['password_confirmation'];

            return $this->authService->setNewPassword($token, $password, $password_confirmation);
        } catch (Error $error) {
            throw new Error($error->getMessage());
        }
    }
}
