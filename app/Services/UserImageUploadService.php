<?php

namespace App\Services;

use App\Models\User;

/**
 * Save file to \storage\app\public\photos
 *
 * @author Volodymyr Zhonchuk
 */
final class UserImageUploadService extends ImageUploadService
{
    /*
     * Get user namespace
     *
     * @param  Illuminate\Http\Request $request
     * @return string
     */
    public function getModelClass()
    {
        return User::class;
    }
}
