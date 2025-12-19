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
        return Utils::cache('user.' . $user->id . '.store', fn () => $user->type === UserType::ADMIN ?
            Store::all() :
            Store::where('user_id', $user->id)->get());
    }

    public static function getCurrentUserStore() : Collection {
        return self::getUserStores(auth()->user());
    }

    public static function getUserByType(UserType|array $type) {
        if (is_array($type)) {
            $type = array_map(function (UserType $t) {
                return $t->value;
            }, $type);
            $types = implode(',', $type);
        } else {
            $types = $type->value;
            $type = [$type->value];
        }
        return Utils::cache($types . '.users', fn () => User::whereIn('type', $type)->get());
    }

    public static function getUsers() {
        return Utils::cache('users', fn () => User::all());
    }

    public static function getUserName(array|Collection|Model $user) : string {
        if (!is_array($user)) {
            $user = $user->toArray();
        }
        return $user['first_name'] . ' ' . $user['last_name'];
    }
}
