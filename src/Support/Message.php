<?php

namespace Nilnice\Phalcon\Support;

use Nilnice\Phalcon\Constant\Code;

class Message
{
    /**
     * @var array
     */
    protected static $messages
        = [
            Code::AUTH_ACCOUNT_TYPE_INVALID => [
                'code'    => 401,
                'message' => 'Account type invalid',
            ],
            Code::AUTH_JWT_INVALID          => [
                'code'    => 401,
                'message' => 'JWT invalid',
            ],
            Code::AUTH_LOGIN_FAILED         => [
                'code'    => 401,
                'message' => 'Login failed',
            ],
            Code::AUTH_TOKEN_EXPIRED        => [
                'code'    => 401,
                'message' => 'Token expired',
            ],
            Code::AUTH_TOKEN_INVALID        => [
                'code'    => 401,
                'message' => 'Token invalid',
            ],
            Code::AUTH_TOKEN_FAILED         => [
                'code'    => 401,
                'message' => 'Login failed',
            ],
            Code::AUTH_UNAUTHORIZED         => [
                'code'    => 401,
                'message' => 'Unauthorized',
            ],
            Code::USER_NOT_EXIST            => [
                'code'    => 400,
                'message' => 'User does not exist',
            ],
            Code::USER_PASS_ERROR           => [
                'code'    => 400,
                'message' => 'User password error',
            ],
            Code::USER_LOCKED               => [
                'code'    => 400,
                'message' => 'User is locked',
            ],
            Code::ACCESS_DENIED             => [
                'code'    => 403,
                'message' => 'Forbidden',
            ],
            Code::INTERFACE_IMPLEMENT_ERROR => [
                'code'    => 400,
                'message' => 'Interface implementation error',
            ],
        ];

    /**
     * Get message by code.
     *
     * @param int $code
     *
     * @return array|null
     */
    public function get(int $code) : ?array
    {
        return $this->has($code) ? self::$messages[$code] : null;
    }

    /**
     * @param int $code
     *
     * @return bool
     */
    public function has(int $code) : bool
    {
        return array_key_exists($code, self::$messages);
    }

    /**
     * Get message by tip code.
     *
     * @param int    $tip
     * @param string $message
     * @param int    $code
     *
     * @return array
     */
    public function getMessage(int $tip, string $message, int $code) : array
    {
        return self::$messages[$tip] = [
            'code'    => $code,
            'message' => $message,
        ];
    }

    /**
     * Set messages.
     *
     * @param array $messages
     */
    public function setMessages(array $messages) : void
    {
        self::$messages = $messages;
    }

    /**
     * @return array
     */
    /**
     * Set messages.
     *
     * @return array
     */
    public function getMessages() : array
    {
        return self::$messages;
    }
}
