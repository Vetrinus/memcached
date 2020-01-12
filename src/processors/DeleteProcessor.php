<?php

namespace vetrinus\memcached\processors;

use vetrinus\memcached\objects\Response;

class DeleteProcessor
{
    protected const NOT_FOUND = 'NOT_FOUND';
    protected const DELETED = 'DELETED';


    public function process(Response $response): bool
    {
        $token = $response->getToken(0);

        return $token === self::NOT_FOUND || $token === self::DELETED;
    }
}
