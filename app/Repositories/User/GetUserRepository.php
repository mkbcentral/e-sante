<?php

namespace App\Repositories\User;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Support\Collection;

class GetUserRepository
{
    private static string $query;
    public static function getListUsers(string $q, string $sortBy, bool $sortAsc):Collection
    {
        SELF::$query = $q;
        return User::when($q, function ($query) {
            return $query->where(function ($query) {
                return $query->where('name', 'like', '%' . SELF::$query . '%')
                    ->orWhere('email', 'like', '%' . SELF::$query . '%');
            });
        })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
        ->where('hospital_id',Hospital::DEFAULT_HOSPITAL())
        ->get();
    }
    public static function getIdUserDefault():int{
        return auth()->user()->id;
    }
}
