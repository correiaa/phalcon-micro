<?php

namespace Nilnice\Phalcon\Auth;

use Nilnice\Phalcon\Auth\Provider\JWTProvider;

interface JWTTokenInterface
{
    /**
     * @param \Nilnice\Phalcon\Auth\Provider\JWTProvider $JWTProvider
     *
     * @return mixed
     */
    public function getToken(JWTProvider $JWTProvider);
}
