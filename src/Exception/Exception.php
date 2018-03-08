<?php

namespace Nilnice\Phalcon\Exception;

class Exception extends \Exception
{
    /**
     * @var array
     */
    protected $devInfo;

    /**
     * @var array
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
        array $devInfo = [],
        array $userInfo = []
    ) {
        parent::__construct($message, $code, $previous);

        $this->devInfo = $devInfo;
        $this->userInfo = $userInfo;
    }

    /**
     * @return array
     */
    public function getDevInfo() : array
    {
        return $this->devInfo;
    }

    /**
     * @return array
     */
    public function getUserInfo() : array
    {
        return $this->userInfo;
    }
}
