<?php

namespace Nilnice\Phalcon\Middleware;

use Nilnice\Phalcon\App;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Phalcon\Mvc\User\Plugin;

/**
 * @property \Nilnice\Phalcon\Auth\Manager  $authManager
 * @property \Nilnice\Phalcon\Http\Request  $request
 * @property \Nilnice\Phalcon\Http\Response $response
 */
class AuthenticationMiddleware extends Plugin implements MiddlewareInterface
{
    /**
     * Application authentication.
     *
     * @param \Phalcon\Events\Event $event
     * @param \Nilnice\Phalcon\App  $app
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function beforeExecuteRoute(Event $event, App $app)
    {
        $token = $app->request->getToken();

        if ($token) {
            $this->authManager->authenticateToken($token);
        }
    }

    /**
     * Calls the middleware.
     *
     * @param \Phalcon\Mvc\Micro $micro
     *
     * @return bool
     */
    public function call(Micro $micro)
    {
        return true;
    }
}
