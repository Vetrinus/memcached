<?php

namespace vetrinus\memcached;

use Psr\SimpleCache\CacheInterface;
use vetrinus\memcached\commands\ClearCommand;
use vetrinus\memcached\commands\DeleteCommand;
use vetrinus\memcached\commands\GetCommand;
use vetrinus\memcached\commands\SetCommand;
use vetrinus\memcached\processors\DeleteProcessor;
use vetrinus\memcached\processors\GetProcessor;

class MemcachedClient extends BaseClient implements CacheInterface
{
    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        $command = new GetCommand($key);
        $processor = new GetProcessor();
        $response = $this->execute($command);

        return $processor->process($response, $default);
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value, $ttl = null)
    {
        $command = new SetCommand($key, $value, $ttl);
        $response = $this->execute($command);

        return $response->getToken(0) == $command->getSuccessResponseToken();
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        $command = new DeleteCommand($key);
        $processor = new DeleteProcessor();

        return $processor->process($this->execute($command));
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $command = new ClearCommand();
        $response = $this->execute($command);

        return $response->getToken(0) === $command->getSuccessResponseToken();
    }

    /**
     * @inheritDoc
     */
    public function getMultiple($keys, $default = null)
    {
        // TODO: Implement getMultiple() method.
    }

    /**
     * @inheritDoc
     */
    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    /**
     * @inheritDoc
     */
    public function has($key)
    {
        $command = new GetCommand($key);
        $processor = new GetProcessor();
        $response = $this->execute($command);

        $default = uniqid() . __CLASS__ . ':' . __METHOD__;
        $result = $processor->process($response, $default);

        return $result !== $default;
    }
}
