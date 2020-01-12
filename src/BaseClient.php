<?php

namespace vetrinus\memcached;

use Generator;
use Psr\Log\LoggerInterface;
use vetrinus\memcached\commands\BaseCommand;
use vetrinus\memcached\objects\Response;
use vetrinus\memcached\processors\ArgumentsProcessor;
use vetrinus\memcached\transport\Transport;

abstract class BaseClient
{
    /** @var Transport */
    protected $transport;

    /** @var LoggerInterface|null */
    protected $logger;

    /** @var ArgumentsProcessor */
    protected $sanitizer;

    /**
     * BaseClient constructor.
     * @param Transport          $transport
     * @param ArgumentsProcessor $sanitizer
     */
    public function __construct(Transport $transport, ArgumentsProcessor $sanitizer)
    {
        $this->transport = $transport;
        $this->sanitizer = $sanitizer;
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
