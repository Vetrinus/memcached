<?php

namespace vetrinus\memcached\exceptions;

use Psr\SimpleCache\CacheException;
use RuntimeException;

class ClientException extends RuntimeException implements CacheException
{
}
