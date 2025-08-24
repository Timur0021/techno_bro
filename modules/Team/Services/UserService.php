<?php

namespace Modules\Team\Services;

use App\Models\TemporaryFile;
use Exception;
use Illuminate\Support\Facades\Hash;
use Modules\Team\Models\User;

class UserService
{
    /**
     *
     * @param User $user
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function updatePersonalData(User $user, array $data): User
    {
        if (!empty($data['password'])) {
            if (Hash::check($data['password'], $user->password)) {
                throw new Exception('Новий пароль не може бути таким самим, як поточний');
            }

            $data['password'] = Hash::make($data['password']);
        }

        if (array_key_exists('parents_data', $data) && is_array($data['parents_data'])) {
            $user->parents_data = $data['parents_data'];
        }

        $user->update($data);

        if (isset($data['tmp_image_id'])) {
            TemporaryFile::transferFilesTo($user, $data['tmp_image_id'], 'image');
        }

        return $user;
    }

    /**
     *
     * @param User $user
     * @return array
     * @throws Exception
     */
    public function deleteAccount(User $user): array
    {
        $user->tokens()->delete();
        $user->delete();

        return [
            'status' => true,
            'message' => 'Акаунт успішно видалено'
        ];
    }
}
