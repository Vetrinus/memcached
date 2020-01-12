<?php

namespace vetrinus\memcached\transport;

interface Transport
{
    public function transmit(string $resource);

    public function read(int $len);
}
