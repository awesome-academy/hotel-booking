<?php

namespace App\Services;

use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Models\SocialAccount;
use App\Models\User;

class SocialAccountService
{
    public static function createOrGetUser(ProviderUser $providerUser, $social)
    {
        $account = SocialAccount::whereProvider($social)->whereProviderUserId($providerUser->getId())->first();

        if ($account) {
            return $account->user;
        } else {
            $email = $providerUser->getEmail() ?? $providerUser->getNickname();
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $social
            ]);
            $user = User::whereEmail($email)->first();
            if (!$user) {
                $user = User::create([
                    'email' => $email,
                    'full_name' => $providerUser->getName(),
                    'password' => bcrypt(Str::random(8)),
                    'role_id' => User::getRoleId('member'),
                    'remember_token' => md5(uniqid()),
                ]);
            }
            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
