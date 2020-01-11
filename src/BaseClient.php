<?php

namespace vetrinus\memcached;

use Generator;
use Psr\Log\LoggerInterface;
use RuntimeException;
use vetrinus\memcached\transport\Transport;

abstract class BaseClient
{
    /** @var Transport */
    protected $transport;

    /** @var LoggerInterface|null */
    protected $logger;

    /**
     * MemcachedClient constructor.
     * @param Transport $transport
     */
    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    protected function execute(BaseCommand $command): Response
    {
        if ($this->logger) {
            $this->logger->info('executing command ' . get_class($command), [
                'request' => $command->represent(),
            ]);
        }

        $this->transport->transmit($command->represent());
        $response = $this->transport->read(2048);

        if ($this->logger) {
            $this->logger->info('response command ' . get_class($command), [
                'response' => $response,
            ]);
        }

        return new Response($response);
    }

    protected function ensureGenerator(Generator $generator): array
    {
        $result = [];

        foreach ($generator as $key => $value) {
            $result[$key] = $value;
        }

        return $result;
    }
}
