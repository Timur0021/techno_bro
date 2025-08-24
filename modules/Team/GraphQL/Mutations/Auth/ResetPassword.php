<?php declare(strict_types=1);

namespace Modules\Team\GraphQL\Mutations\Auth;

use GraphQL\Error\Error;
use Modules\Team\Services\AuthService;

class ResetPassword
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
            $email = $args['email'];
            $url = $args['url'];

            return $this->authService->resetPassword($email, $url);
        } catch (Error $error) {
            throw new Error($error->getMessage());
        }
    }
}
