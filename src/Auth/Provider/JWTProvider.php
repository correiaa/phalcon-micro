<?php

namespace Nilnice\Phalcon\Auth\Provider;

class JWTProvider
{
    /**
     * @var string Account type name.
     */
    private $accountTypeName;

    /**
     * @var string Account type name of the session.
     */
    private $identity;

    /**
     * @var int Start time.
     */
    private $startTime;

    /**
     * @var int Expiration time.
     */
    private $expirationTime;

    /**
     * @var null|string Access token.
     */
    private $token;

    /**
     * JWTProvider constructor.
     *
     * @param string      $accountTypeName
     * @param string      $identity
     * @param int         $startTime
     * @param int         $expirationTime
     * @param null|string $token
     */
    public function __construct(
        string $accountTypeName,
        string $identity,
        int $startTime,
        int $expirationTime,
        ? string $token = null
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
    public function setAccountTypeName(string $accountTypeName) : void
    {
        $this->accountTypeName = $accountTypeName;
    }

    /**
     * @return string
     */
    public function getAccountTypeName() : string
    {
        return $this->accountTypeName;
    }

    /**
     * @param string $identity
     */
    public function setIdentity(string $identity) : void
    {
        $this->identity = $identity;
    }

    /**
     * @return null|string
     */
    public function getIdentity() : ? string
    {
        return $this->identity;
    }

    /**
     * @param int $startTime
     */
    public function setStartTime(int $startTime) : void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return int
     */
    public function getStartTime() : int
    {
        return $this->startTime;
    }

    /**
     * @param int $expirationTime
     */
    public function setExpirationTime($expirationTime) : void
    {
        $this->expirationTime = $expirationTime;
    }

    /**
     * @return int
     */
    public function getExpirationTime() : int
    {
        return $this->expirationTime;
    }

    /**
     * @param null|string $token
     */
    public function setToken(? string $token) : void
    {
        $this->token = $token;
    }

    /**
     * @return null|string
     */
    public function getToken() : ? string
    {
        return $this->token;
    }
}
