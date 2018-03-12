<?php

namespace Nilnice\Phalcon\Middleware;

use Nilnice\Phalcon\App;
use Nilnice\Phalcon\Constant\Code;
use Nilnice\Phalcon\Exception\Exception;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Phalcon\Mvc\User\Plugin;

/**
 * @property \Phalcon\Acl\Adapter\Memory $acl
 */
class AuthorizationMiddleware extends Plugin implements MiddlewareInterface
{
    /**
     * Application authorization.
     *
     * @param \Phalcon\Events\Event $event
     * @param \Nilnice\Phalcon\App  $app
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function beforeExecuteRoute(Event $event, App $app)
    {
        /** @var \Nilnice\Phalcon\Collection $collection */
        $collection = $app->getMatchedCollection();

        /** @var \Nilnice\Phalcon\Endpoint $endpoint */
        $endpoint = $app->getMatchedEndpoint();

        if (! $collection || ! $endpoint) {
            return;
        }

        $roleName = 'User';
        $resourceName = $collection->getIdentifier();
        $access = $endpoint->getIdentifier();

        $isAllowed = $this->acl->isAllowed($roleName, $resourceName, $access);

        if (! $isAllowed) {
            throw new Exception(Code::ACCESS_DENIED);
        }
    }

    /**
     * @param \Phalcon\Mvc\Micro $app
     *
     * @return bool
     */
    public function call(Micro $app) : bool
    {
        return true;
    }
}
