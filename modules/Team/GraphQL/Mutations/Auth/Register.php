<?php

namespace Modules\Team\GraphQL\Mutations\Auth;

use GraphQL\Error\Error;
use Modules\Team\Services\AuthService;
use Exception;

class Register
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
            $name = $args['name'] ?? null;
            $last_name = $args['last_name'] ?? null;
            $email = $args['email'] ?? null;
            $phone = $args['phone'] ?? null;
            $password = $args['password'] ?? null;
            $password_confirmation = $args['password_confirmation'] ?? null;
            $i_agree = $args['i_agree'] ?? false;

            return $this->authService->register($name, $last_name, $email, $phone, $password, $password_confirmation, $i_agree);
        } catch (Error $error) {
            throw new Error($error->getMessage());
        }
    }
}
