<?php

namespace vetrinus\memcached\transport;

use DomainException;
use RuntimeException;

class TcpTransport implements Transport
{
    /** @var resource */
    private $socket;

    /**
     * TcpTransport constructor.
     * @param string $domain
     * @param int    $port
     */
    public function __construct(string $domain, int $port)
    {
        $this->socket = fsockopen($domain, $port);

        if ($this->socket === false) {
            throw new RuntimeException('Unable to open socket: ' . $domain . ':' . $port);
        }

        stream_set_timeout($this->socket, 0, 5000);
    }

    public function transmit(string $content): int
    {
        $sent = fwrite($this->socket, $content);

        if ($sent === false) {
            throw new RuntimeException('Unable to write to a socket');
        }

        return $sent;
    }

    public function read(int $bytes): string
    {
        $value = stream_get_contents($this->socket, -1);

        if ($value === false) {
            throw new RuntimeException('Unable to read socket');
        }

        return $value;
    }

    public function __destruct()
    {
        fclose($this->socket);
    }
}
