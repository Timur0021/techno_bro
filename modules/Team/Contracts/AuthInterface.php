<?php

namespace Modules\Team\Contracts;

use Exception;
use GraphQL\Error\Error;

interface AuthInterface
{
    /**
     *
     * @param string $name
     * @param string $last_name
     * @param string $email
     * @param string $password
     * @return array
     * @throws Exception
     */
    public function register(string $name, string $last_name, string $email, string $phone, string $password): array;

    /**
     *
     * @param string $email
     * @param string $password
     * @param boolean $remember_me
     * @return array
     * @throws Exception
     */
    public function login(string $email, string $password, bool $remember_me): array;

    /**
     *
     * @return array
     */
    public function logout(): array;

    /**
     * @param string $token
     * @return array
     * @throws Exception
     */
    public function registerGoogle(string $token): array;

    /**
     *
     * @param string $token
     * @return array
     * @throws Exception
     */
    public function loginGoogle(string $token): array;

    /**
     *
     * @param string $email
     * @param string $url
     * @return array
     * @throws \Error
     */
    public function resetPassword(string $email, string $url): array;

    /**
     * @throws Error
     */
    public function setNewPassword(string $token, string $password): array;
}
