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
                'message' => 'The account type may not exist',
            ],
            Code::AUTH_JWT_INVALID          => [
                'code'    => 401,
                'message' => 'The JWT class may not be loaded correctly',
            ],
            Code::AUTH_LOGIN_FAILED         => [
                'code'    => 401,
                'message' => 'The user login failed',
            ],
            Code::AUTH_TOKEN_EXPIRED        => [
                'code'    => 401,
                'message' => 'The token may be expired',
            ],
            Code::AUTH_TOKEN_INVALID        => [
                'code'    => 401,
                'message' => 'The token may be invalid',
            ],
            Code::AUTH_TOKEN_FAILED         => [
                'code'    => 401,
                'message' => 'The user token invalid',
            ],
            Code::AUTH_UNAUTHORIZED         => [
                'code'    => 401,
                'message' => 'Unauthorized',
            ],
            Code::USER_NOT_EXIST            => [
                'code'    => 400,
                'message' => 'The user does not exist',
            ],
            Code::USER_PASS_ERROR           => [
                'code'    => 400,
                'message' => 'The user password error',
            ],
            Code::USER_LOCKED               => [
                'code'    => 400,
                'message' => 'The user is locked',
            ],
            Code::USER_AUTH_FAILED          => [
                'code'    => 400,
                'message' => 'The user authentication may failed',
            ],
            Code::ACCESS_DENIED             => [
                'code'    => 403,
                'message' => 'Forbidden',
            ],
            Code::INTERFACE_IMPLEMENT_ERROR => [
                'code'    => 400,
                'message' => 'The account type must be an instance of AccountTypeInterface',
            ],
            Code::METHOD_NOT_IMPLEMENTED    => [
                'code'    => 400,
                'message' => 'Make a subclass of \Nilnice\Phalcon\Mvc\User with an implementation for this method',
            ],
            Code::ROLE_NOT_EXIST            => [
                'code'    => 400,
                'message' => 'The user role does not exist',
            ],
        ];

    /**
     * Get message by code.
     *
     * @param string|int $code
     *
     * @return array|null
     */
    public function get($code) : ?array
    {
        return $this->has($code) ? self::$messages[$code] : null;
    }

    /**
     * @param string|int $code
     *
     * @return bool
     */
    public function has($code) : bool
    {
        return array_key_exists($code, self::$messages);
    }

    /**
     * Get message by tip code.
     *
     * @param string|int $tip
     * @param string     $message
     * @param int        $code
     *
     * @return array
     */
    public function getMessage($tip, string $message, int $code) : array
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
