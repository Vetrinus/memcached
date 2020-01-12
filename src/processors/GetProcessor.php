<?php

namespace vetrinus\memcached\processors;

use vetrinus\memcached\objects\Response;

class GetProcessor
{

    protected const KEY_POSITION = 1;
    protected const RESPONSE_STATUS_POSITION = 0;
    protected const SERIALIZED_VALUE_POSITION = 4;


    public function process(Response $response, $ifEmpty)
    {
        if (array_key_exists(self::SERIALIZED_VALUE_POSITION, $response->getTokens())) {
            return unserialize($response->getToken(self::SERIALIZED_VALUE_POSITION));
        }

        return $ifEmpty;
    }
}
