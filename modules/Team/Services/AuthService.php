<?php

namespace Modules\Team\Services;

use Carbon\Carbon;
use Exception;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Modules\Team\Contracts\AuthInterface;
use Modules\Team\Models\User;

class AuthService implements AuthInterface
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
    public function register(string $name, string $last_name, string $email, string $phone, string $password): array
    {
        DB::beginTransaction();

        try {
            if (empty($email) || empty($password)) {
                throw new Error('Емейл або пароль не введений');
            }

            $userExists = User::query()->where('email', $email)->first();

            if ($userExists) {
                throw new Error('Користувач з таким емейлом вже існує');
            }

            $hashedPassword = Hash::make($password);

            $user = User::query()
                ->create([
                    'name' => $name ?? 'User_' . uniqid(),
                    'last_name' => $last_name ?? 'Last_Name_' . uniqid(),
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $hashedPassword,
                    'remember_me' => false,
                    'email_verified_at' => Carbon::now(),
                    'remember_token' => Str::random(10),
                ]);

            $user->assignRole('student');
            $token = $user->createToken('token')->plainTextToken;

            DB::commit();

            return [
                'users' => $user,
                'token' => $token,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Error($exception->getMessage());
        }
    }

    /**
     *
     * @param string $email
     * @param string $password
     * @param boolean $remember_me
     * @return array
     * @throws Exception
     */
    public function login(string $email, string $password, bool $remember_me): array
    {
        DB::beginTransaction();

        try {
            $user = User::query()->where('email', $email)->first();

            if (!$user) {
                throw new Error('Користувача з таким емейлом не знайдено');
            }

            if (!Hash::check($password, $user->password)) {
                throw new Error('Невірний пароль');
            }

            if ($remember_me) {
                $user->remember_me = true;
                $user->save();
            }

            $token = $user->createToken('token')->plainTextToken;

            DB::commit();

            return [
                'users' => $user,
                'token' => $token,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Error($exception->getMessage());
        }
    }

    /**
     *
     * @return array
     */
    public function logout(): array
    {
        $user = Auth::user();

        $user->tokens()->delete();

        return [
            'success' => true,
            'message' => 'Ви успішно вийшли з профіля!',
        ];
    }

    /**
     * @param string $token
     * @return array
     * @throws Exception
     */
    public function registerGoogle(string $token): array
    {
        DB::beginTransaction();

        try {
            $providerUser = Socialite::driver('google')->userFromToken($token);

            if (!$providerUser) {
                throw new Error('Недійсний токен.');
            }

            if (!$providerUser->getEmail()) {
                throw new Error('Не вдалося отримати email від Google. Авторизація неможлива.');
            }

            $user = User::query()->where('email', $providerUser->email)->first();

            if (!$user) {
                $user = User::query()->create([
                    'name' => $providerUser->name,
                    'email' => $providerUser->email,
                    'email_verified_at' => Carbon::now(),
                    'google_id' => $providerUser->id,
                    'password' => null,
                    'remember_token' => $attributes['remember_token'] ?? Str::random(10),
                ]);
            }

            $user->assignRole('student');
            $token = $user->createToken('token')->plainTextToken;

            DB::commit();

            return [
                'users' => $user,
                'token' => $token,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Error($exception->getMessage());
        }
    }

    /**
     *
     * @param string $token
     * @return array
     * @throws Error
     * @throws Exception
     */
    public function loginGoogle(string $token): array
    {
        DB::beginTransaction();

        try {
            $providerUser = Socialite::driver('google')->userFromToken($token);

            if (!$providerUser) {
                throw new Error('Недійсний токен.');
            }

            $user = User::query()->where('email', $providerUser->email)->first();

            if (!$user) {
                throw new Error('Такого користувача не існує.');
            }

            $token = $user->createToken('token')->plainTextToken;

            DB::commit();

            return [
                'users' => $user,
                'token' => $token,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Error($exception->getMessage());
        }
    }

    /**
     *
     * @param string $email
     * @return array
     * @throws Error
     */
    public function resetPassword(string $email, string $url): array
    {
        try {
            $user = User::query()->where('email', $email)->first();

            if (!$user) {
                throw new Error('Користувача з таким емейлом не знайдено.');
            }

            $token = Str::random(50);

            $user->token = $token;
            $user->save();

            $resetUrl = $url . '?token=' . $token;

            Mail::send('emails.reset-password', ['user' => $user, 'url' => $resetUrl], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Відновлення паролю');
            });

            return [
                'status' => 'success',
                'message' => 'Повідомлення на відновлення надіслано'
            ];
        } catch (Exception $exception) {
            throw new Error($exception->getMessage());
        }
    }

    /**
     * @throws Error
     */
    public function setNewPassword(string $token, string $password): array
    {
        try {
            $user = User::query()->where('token', $token)->first();

            if (!$user) {
                throw new Error('Користувача з таким токеном не знайдено.');
            }

            if (Hash::check($password, $user->password)) {
                throw new Error('Новий пароль не може бути таким самим, як поточний');
            }

            $user->password = Hash::make($password);
            $user->token = null;
            $user->save();

            return [
                'users' => $user,
                'token' => $user->createToken('token')->plainTextToken
            ];
        } catch (Exception $exception) {
            throw new Error($exception->getMessage());
        }
    }
}
