<?php

namespace Nilnice\Phalcon\Mvc\User;

use Nilnice\Phalcon\Constant\Code;
use Nilnice\Phalcon\Exception\Exception;
use Phalcon\Mvc\User\Plugin;

/**
 * @property \Nilnice\Phalcon\Auth\Manager $authManager
 */
class User extends Plugin
{
    /**
     * Get user.
     *
     * @return array
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function getUser() : array
    {
        $user = [];

        if ($identity = $this->getIdentity()) {
            $user = $this->getUserByIdentity($identity);
        }

        return $user;
    }

    /**
     * @return null|string
     */
    public
    function getIdentity() : ? string
    {
        $jwtProvider = $this->authManager->getJWTProvider();

        if ($jwtProvider) {
            return $jwtProvider->getIdentity();
        }

        return null;
    }

    /**
     * @return string
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public
    function getRole() : string
    {
        throw new Exception(
            'Please implement getRole() method',
            Code::METHOD_NOT_IMPLEMENTED
        );
    }

    /**
     * @param string $identity
     *
     * @return array
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public
    function getUserByIdentity(
        string $identity
    ) : array {
        throw new Exception(
            'Please implement getUserByIdentity() method',
            Code::METHOD_NOT_IMPLEMENTED
        );
    }
}
