<?php

namespace Nilnice\Phalcon\Auth;

use Nilnice\Phalcon\Auth\Provider\JWTProvider;
use Firebase\JWT\JWT;
use Phalcon\Exception;

class JWTToken implements JWTTokenInterface
{
    public const ALGORITHM_HS256 = 'HS256';
    public const ALGORITHM_HS512 = 'HS512';
    public const ALGORITHM_HS384 = 'HS384';
    public const ALGORITHM_RS256 = 'RS256';

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $algorithm;

    /**
     * JWTToken constructor.
     *
     * @param string $secret
     * @param string $algorithm
     *
     * @throws \Phalcon\Exception
     */
    public function __construct($secret, $algorithm = self::ALGORITHM_HS256)
    {
        if (! class_exists(JWT::class)) {
            throw new Exception('You need to load the JWT class.');
        }
        $this->secret = $secret;
        $this->algorithm = $algorithm;
    }

    /**
     * @param $secret
     *
     * @return string
     */
    public function setSecret($secret) : string
    {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getSecret() : string
    {
        return $this->secret;
    }

    /**
     * @param $algorithm
     *
     * @return string
     */
    public function setAlgorithm($algorithm) : string
    {
        $this->algorithm = $algorithm;
    }

    /**
     * @return string
     */
    public function getAlgorithm() : string
    {
        return $this->algorithm;
    }

    /**
     * @param \Nilnice\Phalcon\Auth\Provider\JWTProvider $JWTProvider
     *
     * @return string
     */
    public function getToken(JWTProvider $JWTProvider) : string
    {
        $data = $this->payload(
            $JWTProvider->getAccountTypeName(),
            $JWTProvider->getIdentity(),
            $JWTProvider->getStartTime(),
            $JWTProvider->getExpirationTime()
        );

        return $this->encode($data);
    }

    /**
     * @param $token
     *
     * @return string
     */
    public function encode($token) : string
    {
        return JWT::encode($token, $this->secret, $this->algorithm);
    }

    /**
     * @param string $token
     *
     * @return object
     * @throws \Firebase\JWT\BeforeValidException
     * @throws \Firebase\JWT\ExpiredException
     * @throws \Firebase\JWT\SignatureInvalidException
     * @throws \UnexpectedValueException
     */
    public function decode(string $token)
    {
        return JWT::decode($token, $this->secret, [$this->algorithm]);
    }

    /**
     * @param string $token
     *
     * @return \Nilnice\Phalcon\Auth\Provider\JWTProvider
     * @throws \Firebase\JWT\BeforeValidException
     * @throws \Firebase\JWT\ExpiredException
     * @throws \Firebase\JWT\SignatureInvalidException
     * @throws \UnexpectedValueException
     */
    public function getProvider(string $token) : JWTProvider
    {
        $token = $this->decode($token);

        return new JWTProvider(
            $token->iss,
            $token->sub,
            $token->iat,
            $token->exp
        );
    }

    /**
     * @param string $iss
     * @param mixed  $user
     * @param int    $iat
     * @param int    $exp
     *
     * @return array
     */
    private function payload($iss, $user, $iat, $exp) : array
    {
        return [
            'iss' => $iss,
            'sub' => $user,
            'iat' => $iat,
            'exp' => $exp,
        ];
    }
}
