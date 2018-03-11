<?php

namespace Nilnice\Phalcon\Acl;

use Phalcon\Acl;
use Phalcon\Acl\AdapterInterface;

trait AclMountTrait
{
    /**
     * Set single mount.
     *
     * @param \Nilnice\Phalcon\Acl\MountableInterface $mount
     *
     * @return $this
     */
    public function setMount(MountableInterface $mount) : self
    {
        if ($this instanceof AdapterInterface) {
            $resources = $mount->getAclResources();
            $roles = $mount->getAclRoles($this->getRoles());

            foreach ($resources as $resource) {
                $count = \count($resource);
                if ($count === 0) {
                    continue;
                }
                $access = $count > 1 ? $resource[1] : null;
                $this->addResource($resource[0], $access);
            }

            $allowedRoles = $roles[Acl::ALLOW] ?? [];
            $deniedRoles = $roles[Acl::DENY] ?? [];

            foreach ($allowedRoles as $allowedRole) {
                $count = \count($allowedRole);
                if ($count < 2) {
                    continue;
                }
                $access = $count > 2 ? $allowedRole[2] : null;
                $this->allow($allowedRole[0], $allowedRole[1], $access);
            }

            foreach ($deniedRoles as $deniedRole) {
                $count = \count($deniedRole);
                if ($count < 2) {
                    continue;
                }
                $access = $count > 2 ? $deniedRole[2] : null;
                $this->deny($deniedRole[0], $deniedRole[1], $access);
            }
        }

        return $this;
    }

    /**
     * Set multi mounts.
     *
     * @param array $mounts
     *
     * @return $this
     */
    public function setMounts(array $mounts) : self
    {
        foreach ($mounts as $mount) {
            $this->setMount($mount);
        }

        return $this;
    }
}
