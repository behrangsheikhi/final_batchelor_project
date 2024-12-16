<?php

namespace App\Repository;

class User
{
    // These functions are for cache the user table ( use this class in the controller if needed )
    const CACHE_KEY = 'USERS';
    public static function all($orderBy)
    {
        $key = "all.{$orderBy}";
        $cacheKey = static::getCacheKey($key);

        return cache()->remember($cacheKey,now()->addMinute('5'),function () use($orderBy){
            return \App\Models\User::orderBy($orderBy)->get();
        });
    }

    public static function getCacheKey($key): string
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . '.' . $key;
    }
}
