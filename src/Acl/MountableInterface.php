<?php

namespace Nilnice\Phalcon\Acl;

interface MountableInterface
{
    /**
     * Returns the Acl resources.
     *
     * @return array
     */
    public function getAclResources() : array;

    /**
     * Returns the Acl roles.
     *
     * @param array $roles
     *
     * @return array
     */
    public function getAclRoles(array $roles) : array;
}
