<?php

namespace Nilnice\Phalcon\Acl;

use Phalcon\Acl\AdapterInterface;

trait AclMountTrait
{
    public function setMount(array $mount)
    {
        if ($this instanceof AdapterInterface) {
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
