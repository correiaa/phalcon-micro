<?php

namespace Nilnice\Phalcon\Container;

use Nilnice\Phalcon\Acl\Adapter\Memory;
use Nilnice\Phalcon\Auth\Manager;
use Nilnice\Phalcon\Constant\Service;
use Nilnice\Phalcon\Http\Request;
use Nilnice\Phalcon\Http\Response;
use Nilnice\Phalcon\Mvc\User\User;
use Phalcon\Di\FactoryDefault;

class Container extends FactoryDefault
{
    /**
     * Container constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setShared(Service::REQUEST, new Request());
        $this->setShared(Service::RESPONSE, new Response());
        $this->setShared(Service::AUTH_MANAGER, new Manager());
        $this->setShared(Service::USER, new User());
        $this->setShared(Service::ACL, new Memory());
    }
}
