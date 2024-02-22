<?php

namespace App\Repositories\User;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
class GetUserRepository
{
    private static string $query;
    public static function getListUsers(string $q, string $sortBy, bool $sortAsc,$per_page=10): LengthAwarePaginator
    {
        SELF::$query = $q;
        return User::when($q, function ($query) {
            return $query->where(function ($query) {
                return $query->where('name', 'like', '%' . SELF::$query . '%')
                    ->orWhere('email', 'like', '%' . SELF::$query . '%');
            });
        })->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
        ->where('hospital_id',Hospital::DEFAULT_HOSPITAL())
        ->with(['hospital', 'source', 'agentService'])
        ->paginate(10);
    }
    public static function getIdUserDefault():int{
        return auth()->user()->id;
    }
}
