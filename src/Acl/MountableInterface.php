<?php

namespace Nilnice\Phalcon\Acl;

interface MountableInterface
{
    /**
     * Returns the ACL resources.
     *
     * @return array
     */
    public function getAclResources() : array;

    /**
     * Returns the ACL roles.
     *
     * @return array
     */
    public function getAclRoles() : array;
}
