<?php

namespace Nilnice\Phalcon;

class Exception extends \Exception
{
    /**
     * @var array|null
     */
    protected $devInfo;

    /**
     * @var array|null
     */
    protected $userInfo;

    /**
     * Exception constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     * @param array|null      $devInfo
     * @param array|null      $userInfo
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        \Throwable $previous = null,
        array $devInfo = null,
        array $userInfo = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->devInfo = $devInfo;
        $this->userInfo = $userInfo;
    }

    /**
     * @return array|null
     */
    public function getDevInfo() : ? array
    {
        return $this->devInfo;
    }

    /**
     * @return array|null
     */
    public function getUserInfo() : ? array
    {
        return $this->userInfo;
    }
}
