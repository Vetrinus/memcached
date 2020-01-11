<?php

namespace vetrinus\memcached\exceptions;

use Psr\SimpleCache\CacheException;
use RuntimeException;

class UnableToConnectException extends RuntimeException implements CacheException
{

}
