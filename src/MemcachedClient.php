<?php

namespace vetrinus\memcached;

use Generator;
use Psr\SimpleCache\CacheInterface;
use vetrinus\memcached\commands\ClearCommand;
use vetrinus\memcached\commands\DeleteCommand;
use vetrinus\memcached\commands\GetCommand;
use vetrinus\memcached\commands\GetMultipleCommand;
use vetrinus\memcached\commands\SetCommand;
use vetrinus\memcached\exceptions\InvalidArgumentException;
use vetrinus\memcached\processors\DeleteProcessor;
use vetrinus\memcached\processors\GetMultipleProcessor;
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
        if (!is_iterable($keys)) {
            throw new InvalidArgumentException('keys to get must be iterable');
        }

        if ($keys instanceof Generator) {
            $keys = $this->ensureGenerator($keys);
        }

        $command = new GetMultipleCommand($keys);
        $processor = new GetMultipleProcessor();

        return $processor->process($this->execute($command), $keys, $default);
    }

    /**
     * @inheritDoc
     */
    public function setMultiple($values, $ttl = null)
    {
        if (!is_iterable($values)) {
            throw new InvalidArgumentException('values to set must be iterable');
        }

        foreach ($values as $key => $value) {
            if (is_integer($key)) {
                $key = (string)$key;
            }

            if (!$this->set($key, $value, $ttl)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple($keys)
    {
        if (!is_iterable($keys)) {
            throw new InvalidArgumentException('keys to delete must be iterable');
        }

        foreach ($keys as $key) {
            if (!$this->delete($key)) {
                return false;
            }
        }

        return true;
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
