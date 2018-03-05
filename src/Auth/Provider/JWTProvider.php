<?php

namespace Nilnice\Phalcon\Auth\Provider;

class JWTProvider
{
    /** @var string Account type name. */
    private $accountTypeName;

    /** @var string Account type name of the session. */
    private $identity;

    /** @var int Start time. */
    private $startTime;

    /** @var int Expiration time. */
    private $expirationTime;

    /** @var string|null Token. */
    private $token;

    /**
     * SessionStorage constructor.
     *
     * @param string      $accountTypeName
     * @param string      $identity
     * @param int         $startTime
     * @param int         $expirationTime
     * @param null|string $token
     */
    public function __construct(
        $accountTypeName,
        $identity,
        $startTime,
        $expirationTime,
        $token = null
    ) {
        $this->accountTypeName = $accountTypeName;
        $this->identity = $identity;
        $this->startTime = $startTime;
        $this->expirationTime = $expirationTime;
        $this->token = $token;
    }

    /**
     * @param string $accountTypeName
     */
    public function setAccountTypeName($accountTypeName)
    {
        $this->accountTypeName = $accountTypeName;
    }

    /**
     * @return string
     */
    public function getAccountTypeName()
    {
        return $this->accountTypeName;
    }

    /**
     * @param string $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param int $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param int $expirationTime
     */
    public function setExpirationTime($expirationTime)
    {
        $this->expirationTime = $expirationTime;
    }

    /**
     * @return int
     */
    public function getExpirationTime()
    {
        return $this->expirationTime;
    }

    /**
     * @param null $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return null
     */
    public function getToken()
    {
        return $this->token;
    }
}
