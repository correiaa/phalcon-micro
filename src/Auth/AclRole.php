<?php

namespace Nilnice\Phalcon\Auth;

class AclRole
{
    public const UNAUTHORIZED = 'Unauthorized';
    public const AUTHORIZED = 'Authorized';
    public const USER = 'User';
    public const MANAGER = 'Manager';
    public const ADMINISTRATOR = 'Administrator';
    public const All
        = [
            self::UNAUTHORIZED,
            self::AUTHORIZED,
            self::USER,
            self::MANAGER,
            self::ADMINISTRATOR,
        ];
}
