<?php

namespace vetrinus\memcached\exceptions;

use Psr\SimpleCache\CacheException;
use RuntimeException;

class ServerException extends RuntimeException implements CacheException
{

}
