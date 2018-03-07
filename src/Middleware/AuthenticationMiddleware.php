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
     * Before anything happens.
     *
     * @param \Phalcon\Events\Event $event
     * @param \Nilnice\Phalcon\App  $app
     *
     * @return null|string
     * @throws \Firebase\JWT\BeforeValidException
     * @throws \Firebase\JWT\ExpiredException
     * @throws \Firebase\JWT\SignatureInvalidException
     * @throws \Phalcon\Exception
     * @throws \UnexpectedValueException
     */
    public function beforeExecuteRoute(Event $event, App $app) : ? string
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
