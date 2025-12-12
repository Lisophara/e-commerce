<?php

namespace App\Services;

use App\Enum\UserType;
use App\Models\Store;
use App\Models\User;
use App\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class UserServices
{
    private function __construct(){ /** no object */ }

    public static function getUserStores(User|int $user) : Collection {
        if (is_int($user)) {
            $user = User::find($user);
        }
        $cacheKey = 'user.' . $user->id . '.store';

        if (Utils::hasCache($cacheKey)) {
            return Utils::getCache($cacheKey);
        }

        if ($user->type === UserType::ADMIN) {
            $stores = Store::all();
        } else {
            $stores = Store::where('user_id', $user->id)->get();
        }
        Utils::putCache($cacheKey, $stores);
        return $stores;
    }

    public static function getCurrentUserStore() : Collection {
        return self::getUserStores(auth()->user());
    }

    public static function getUsers() {
        $cacheKey = 'users';
        if (Utils::hasCache($cacheKey)) {
            return Utils::getCache($cacheKey);
        }
        $users = User::all();
        Utils::putCache($cacheKey, $users);
        return $users;
    }

    public static function getUserName(array|Collection|Model $user) : string {
        if (!is_array($user)) {
            $user = $user->toArray();
        }
        return $user['first_name'] . ' ' . $user['last_name'];
    }
}
