<?php

namespace Nilnice\Phalcon\Support;

use Nilnice\Phalcon\Constant\Tip;

class Message
{
    /**
     * @var array
     */
    protected static $messages
        = [
            Tip::AUTH_ACCOUNT_TYPE_INVALID => [
                'code'    => 401,
                'message' => 'Account type invalid',
            ],
            Tip::AUTH_JWT_INVALID          => [
                'code'    => 401,
                'message' => 'JWT invalid',
            ],
            Tip::AUTH_LOGIN_FAILED         => [
                'code'    => 401,
                'message' => 'Login failed',
            ],
            Tip::AUTH_TOKEN_EXPIRED        => [
                'code'    => 401,
                'message' => 'Token expired',
            ],
            Tip::AUTH_TOKEN_INVALID        => [
                'code'    => 401,
                'message' => 'Token invalid',
            ],
            Tip::AUTH_TOKEN_FAILED         => [
                'code'    => 401,
                'message' => 'Login failed',
            ],
            Tip::AUTH_UNAUTHORIZED         => [
                'code'    => 401,
                'message' => 'Unauthorized',
            ],
            Tip::AUTH_USER_NOT_FOUND       => [
                'code'    => 404,
                'message' => 'Not found',
            ],
            Tip::ACCESS_DENIED             => [
                'code'    => 403,
                'message' => 'Forbidden',
            ],
            Tip::CLASS_IMPLEMENT_ERROR     => [
                'code'    => 400,
                'message' => 'Class implementation error',
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
