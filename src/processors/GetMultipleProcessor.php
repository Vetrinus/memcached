<?php

namespace vetrinus\memcached\processors;

use Generator;
use vetrinus\memcached\Response;

class GetMultipleProcessor
{
    protected const VALUE_TOKEN = 'VALUE';

    /**
     * @param Response $response
     * @param iterable $keys
     * @param mixed    $default
     * @return array
     */
    public function process(Response $response, $keys, $default)
    {
        if ($keys instanceof Generator) {
            $keys = $this->ensureGenerator($keys);
        }

        $variables = $this->ejectVariables($response);

        $missedKeys = array_diff($keys, array_keys($variables));

        foreach ($missedKeys as $missedKey) {
            $variables[$missedKey] = $default;
        }

        return $variables;
    }

    private function ejectVariable(Response $response, int $startIndex): array
    {
        return [
            'key'   => $response->getToken($startIndex + 1),
            'value' => unserialize($response->getToken($startIndex + 4)),
        ];
    }

    private function ejectVariables(Response $response): array
    {
        $result = [];

        foreach ($response->getTokens() as $index => $token) {
            if ($token == self::VALUE_TOKEN) {
                $tmp = $this->ejectVariable($response, $index);
                $result[$tmp['key']] = $tmp['value'];
            }
        }

        return $result;
    }

    private function ensureGenerator(Generator $generator): array
    {
        $result = [];

        foreach ($generator as $key => $value) {
            $result[$key] = $value;
        }

        return $result;
    }
}
