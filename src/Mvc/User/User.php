<?php

namespace Nilnice\Phalcon\Mvc\User;

use Nilnice\Phalcon\Constant\Code;
use Nilnice\Phalcon\Exception\Exception;
use Phalcon\Mvc\Model;
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
    /**
     * @return \Phalcon\Mvc\Model|null
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function getUser() : ? Model
    {
        $user = null;

        if ($identity = $this->getIdentity()) {
            $user = $this->getUserByIdentity($identity);

            return $user;
        }

        return $user;
    }

    /**
     * @return null|string
     */
    public function getIdentity() : ? string
    {
        $jwtProvider = $this->authManager->getJWTProvider();

        if ($jwtProvider) {
            return $jwtProvider->getIdentity();
        }

        return null;
    }

    /**
     * Get user role.
     *
     * @return string
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function getRole() : string
    {
        throw new Exception(Code::METHOD_NOT_IMPLEMENTED);
    }

    /**
     * Get user by identity.
     *
     * @param string $identity
     *
     * @return \Phalcon\Mvc\Model
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function getUserByIdentity(string $identity) : Model
    {
        throw new Exception(Code::METHOD_NOT_IMPLEMENTED);
    }
}
