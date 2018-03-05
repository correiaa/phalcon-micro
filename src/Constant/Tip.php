<?php

namespace Nilnice\Phalcon\Constant;

class Tip
{
    // Successful operation.
    public const SUCCESS = 200000;

    // User not found.
    public const AUTH_USER_NOT_FOUND = 200101;

    // Token expired.
    public const AUTH_TOKEN_EXPIRED = 200102;

    // Token invalid.
    public const AUTH_TOKEN_INVALID = 200103;

    // Token failed.
    public const AUTH_TOKEN_FAILED = 200104;

    // JWT invalid.
    public const AUTH_JWT_INVALID = 200105;

    // Account type invalid.
    public const AUTH_ACCOUNT_TYPE_INVALID = 200106;

    // Login failed.
    public const AUTH_LOGIN_FAILED = 200107;

    // Unauthorized.
    public const AUTH_UNAUTHORIZED = 200205;

    // Failed operation.
    public const FAILED = 400000;
}
