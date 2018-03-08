<?php

namespace Nilnice\Phalcon\Auth;

use Nilnice\Phalcon\Auth\Provider\JWTProvider;
use Nilnice\Phalcon\Constant\Code;
use Nilnice\Phalcon\Exception\Exception;
use Phalcon\Mvc\User\Plugin;

/**
 * @property \Nilnice\Phalcon\Auth\JWTToken $jwtToken
 */
class Manager extends Plugin
{
    public const LOGIN_PHONE = 'phone';
    public const LOGIN_EMAIL = 'email';
    public const LOGIN_USERNAME = 'username';
    public const LOGIN_PASSWORD = 'password';

    /**
     * @var int Expiration time.
     */
    private $duration;

    /**
     * @var \Nilnice\Phalcon\Auth\Provider\JWTProvider
     */
    private $jwtProvider;

    /**
     * @var array Account types.
     */
    private $accountType;

    /**
     * Manager constructor.
     *
     * @param int $duration
     */
    public function __construct(int $duration = 86400)
    {
        $this->duration = $duration;
        $this->accountType = [];
    }

    /**
     * Register account type.
     *
     * @param string                                     $name
     * @param \Nilnice\Phalcon\Auth\AccountTypeInterface $accountType
     *
     * @return $this
     */
    public function registerAccountType(
        string $name,
        AccountTypeInterface $accountType
    ) : self {
        $this->accountType[$name] = $accountType;

        return $this;
    }

    /**
     * Login with user username and password.
     *
     * @param string $type
     * @param string $username
     * @param string $password
     *
     * @return \Nilnice\Phalcon\Auth\Provider\JWTProvider
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function loginWithUsernamePassword(
        string $type,
        string $username,
        string $password
    ) : JWTProvider {
        $array = [
            self::LOGIN_USERNAME => $username,
            self::LOGIN_PASSWORD => $password,
        ];

        return $this->login($type, $array);
    }

    /**
     * User login.
     *
     * @param string $type
     * @param array  $array
     *
     * @return \Nilnice\Phalcon\Auth\Provider\JWTProvider
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function login(string $type, array $array) : JWTProvider
    {
        $accountType = $this->getAccountType($type);

        if (! $accountType) {
            throw new Exception(
                'The account type may not exist',
                Code::AUTH_ACCOUNT_TYPE_INVALID
            );
        }

        if (! $accountType instanceof AccountTypeInterface) {
            throw new Exception(
                'The account type must be an instance of AccountTypeInterface',
                Code::INTERFACE_IMPLEMENT_ERROR
            );
        }

        $data = $this->getIdentity($accountType, $array);
        [
            'code'     => $code,
            'message'  => $message,
            'identity' => $identity,
        ]
            = $data;

        if ($code && $message) {
            throw new Exception($message, $code);
        }

        $startTime = time();
        $expirationTime = $this->duration + $startTime;
        $jwtProvider = new JWTProvider(
            $type,
            $identity,
            $startTime,
            $expirationTime
        );
        $token = $this->jwtToken->getToken($jwtProvider);
        $jwtProvider->setToken($token);
        $this->jwtProvider = $jwtProvider;

        return $this->jwtProvider;
    }

    /**
     * Authentication token.
     *
     * @param $token
     *
     * @return bool
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function authenticateToken($token) : bool
    {
        try {
            $jwtToken = $this->jwtToken->getProvider($token);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), Code::AUTH_TOKEN_INVALID);
        }

        if (! $jwtToken) {
            return false;
        }

        if ($jwtToken->getExpirationTime() < time()) {
            throw new Exception(
                'The token may be expired',
                Code::AUTH_TOKEN_EXPIRED
            );
        }
        $jwtToken->setToken($token);

        /** @var \Nilnice\Phalcon\Auth\AccountTypeInterface $account */
        $account = $this->getAccountType($jwtToken->getAccountTypeName());
        if (! $account) {
            throw new Exception(
                'The account type may not exist',
                Code::AUTH_ACCOUNT_TYPE_INVALID
            );
        }

        if (! $account->authenticate($jwtToken->getIdentity())) {
            throw new Exception(
                'The token authentication may failed',
                Code::AUTH_TOKEN_INVALID
            );
        }
        $this->jwtProvider = $jwtToken;

        return true;
    }

    /**
     * Get account type.
     *
     * @param string $type
     *
     * @return mixed|null
     */
    public function getAccountType(string $type)
    {
        if (array_key_exists($type, $this->accountType)) {
            return $this->accountType[$type];
        }

        return null;
    }

    /**
     * Get identify.
     *
     * @param \Nilnice\Phalcon\Auth\AccountTypeInterface $accountType
     * @param array                                      $array
     *
     * @return array
     */
    private function getIdentity(
        AccountTypeInterface $accountType,
        array $array
    ) : array {
        $identity = $accountType->login($array);

        switch ($identity) {
            case '-1':
                $code = Code::USER_NOT_EXIST;
                $message = 'The user may not exist';
                break;
            case '-2':
                $code = Code::USER_PASS_ERROR;
                $message = 'The user password may be wrong';
                break;
            case '-3':
                $code = Code::USER_LOCKED;
                $message = 'The user may be locked up';
                break;
            default:
                $code = 0;
                $message = '';
                break;
        }

        $data = [
            'code'     => $code,
            'message'  => $message,
            'identity' => $identity,
        ];

        return $data;
    }
}
