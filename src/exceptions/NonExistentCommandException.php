<?php

namespace vetrinus\memcached\exceptions;

use Psr\SimpleCache\CacheException;
use RuntimeException;

class NonExistentCommandException extends RuntimeException implements CacheException
{

}
