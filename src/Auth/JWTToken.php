<?php

namespace Nilnice\Phalcon\Auth;

use Nilnice\Phalcon\Auth\Provider\JWTProvider;
use Nilnice\Phalcon\Constant\Code;
use Nilnice\Phalcon\Exception\Exception;
use Firebase\JWT\JWT;

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
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function __construct(
        string $secret,
        string $algorithm = self::ALGORITHM_HS256
    ) {
        if (! class_exists(JWT::class)) {
            throw new Exception(Code::AUTH_JWT_INVALID);
        }
        $this->secret = $secret;
        $this->algorithm = $algorithm;
    }

    /**
     * Set secret.
     *
     * @param string $secret
     *
     * @return string
     */
    public function setSecret(string $secret) : string
    {
        $this->secret = $secret;
    }

    /**
     * Get secret.
     *
     * @return string
     */
    public function getSecret() : string
    {
        return $this->secret;
    }

    /**
     * Set algorithm.
     *
     * @param string $algorithm
     *
     * @return string
     */
    public function setAlgorithm($algorithm) : string
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Get algorithm.
     *
     * @return string
     */
    public function getAlgorithm() : string
    {
        return $this->algorithm;
    }

    /**
     * Get token.
     *
     * @param \Nilnice\Phalcon\Auth\Provider\JWTProvider $jwtProvider
     *
     * @return string
     */
    public function getToken(JWTProvider $jwtProvider) : string
    {
        $data = [
            'iss' => $jwtProvider->getAccountTypeName(),
            'sub' => $jwtProvider->getIdentity(),
            'iat' => $jwtProvider->getStartTime(),
            'exp' => $jwtProvider->getExpirationTime(),
        ];

        return $this->encode($data);
    }

    /**
     * Converts and signs a PHP object or array into a JWT string.
     *
     * @param \stdClass|array $token
     *
     * @return string
     */
    public function encode($token) : string
    {
        return JWT::encode($token, $this->secret, $this->algorithm);
    }

    /**
     * Decodes a JWT string into a PHP object.
     *
     * @param string $token
     *
     * @return \stdClass
     *
     * @throws \Firebase\JWT\BeforeValidException
     * @throws \Firebase\JWT\ExpiredException
     * @throws \Firebase\JWT\SignatureInvalidException
     * @throws \UnexpectedValueException
     */
    public function decode(string $token) : \stdClass
    {
        return JWT::decode($token, $this->secret, [$this->algorithm]);
    }

    /**
     * Get JWTProvider.
     *
     * @param string $token
     *
     * @return \Nilnice\Phalcon\Auth\Provider\JWTProvider
     *
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
}
