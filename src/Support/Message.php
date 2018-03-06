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
                'code'    => 400,
                'message' => 'Authentication: Account Type Invalid.',
            ],
            Tip::AUTH_TOKEN_EXPIRED        => [
                'code'    => 500,
                'message' => 'Authentication: Token Expired.',
            ],
            Tip::AUTH_TOKEN_INVALID        => [
                'code'    => 500,
                'message' => 'Authentication: Token Invalid.',
            ],
            Tip::AUTH_TOKEN_FAILED         => [
                'code'    => 500,
                'message' => 'Authentication: Login Failed.',
            ],
            Tip::AUTH_JWT_INVALID          => [
                'code'    => 500,
                'message' => 'Authentication: Login Failed.',
            ],
            Tip::ACCESS_DENIED             => [
                'code'    => 403,
                'message' => 'Access: Denied.',
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
