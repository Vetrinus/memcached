<?php

namespace vetrinus\memcached\exceptions;

use InvalidArgumentException as BaseException;
use Psr\SimpleCache\InvalidArgumentException as PsrExceptionInterface;

class InvalidArgumentException extends BaseException implements PsrExceptionInterface
{

}
