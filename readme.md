Build Status
------------
[![Build Status](https://travis-ci.com/Vetrinus/memcached.svg?branch=master)](https://travis-ci.com/Vetrinus/memcached)

## Usage

This library provide [Memcached](https://ru.wikipedia.org/wiki/Memcached) implementation of [PSR-16](https://www.php-fig.org/psr/psr-16/)

~~~php
use Psr\SimpleCache\CacheInterface;
use vetrinus\memcached\ClientFactory;

/** @var CacheInterface $cache */
$cache = (new ClientFactory())->createByDomainAndPort('localhost', 11211);

$cache->set('key', ['value' => 'someValue']);
$cache->get('key');
$cache->has('key');
~~~

### TODO:
1. Implement binary round-trip
2. Handle generators to be a valid keys to multiple commands
