<?php

namespace Nilnice\Phalcon\Acl\Adapter;

use Nilnice\Phalcon\Acl\AclMountTrait;

class Memory extends \Phalcon\Acl\Adapter\Memory
{
    use AclMountTrait;

    // Unauthorized.
    public const UNAUTHORIZED = 'Unauthorized';

    // Authorized.
    public const AUTHORIZED = 'Authorized';

    // User.
    public const USER = 'User';

    // Manager.
    public const MANAGER = 'Manager';

    // Administrator.
    public const ADMINISTRATOR = 'Administrator';

    // All roles.
    public const All_ROLES
        = [
            self::UNAUTHORIZED,
            self::AUTHORIZED,
            self::USER,
            self::MANAGER,
            self::ADMINISTRATOR,
        ];
}
