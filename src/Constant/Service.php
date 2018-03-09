<?php

namespace Nilnice\Phalcon\Constant;

class Service
{
    // Http request.
    public const REQUEST = 'request';

    // Http response.
    public const RESPONSE = 'response';

    // Exception message code.
    public const MESSAGE = 'message';

    // Configuration service.
    public const CONFIG = 'config';

    // configuration service file.
    public const CONFIG_FILE = 'config.ini';

    // Security service.
    public const SECURITY = 'security';

    // Acl service.
    public const ACL = 'acl';

    // URL service.
    public const URL = 'url';

    // Events manager service.
    public const EVENTS_MANAGER = 'eventsManager';

    // Auth manager service.
    public const AUTH_MANAGER = 'authManager';

    // JWT Token service.
    public const JWT_TOKEN = 'jwtToken';

    // Queue service.
    public const RABBITMQ = 'rabbitmq';

    // Database service.
    public const DB = 'db';

    // Model manager.
    public const MODELS_MANAGER = 'modelsManager';

    // Model Metadata.
    public const MODELS_METADATA = 'modelsMetadata';
}
