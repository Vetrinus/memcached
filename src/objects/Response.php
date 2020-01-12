<?php

namespace vetrinus\memcached\objects;

use DomainException;
use RuntimeException;
use vetrinus\memcached\commands\BaseCommand;
use vetrinus\memcached\exceptions\ClientException;
use vetrinus\memcached\exceptions\NonExistentCommandException;
use vetrinus\memcached\exceptions\ServerException;

class Response
{
    private const ERROR = 'ERROR';
    private const CLIENT_ERROR = 'CLIENT_ERROR';
    private const SERVER_ERROR = 'SERVER_ERROR';


    /** @var string[] */
    private $tokens = [];

    /**
     * Response constructor.
     * @param string $response
     */
    public function __construct(string $response)
    {
        $ending = substr($response, -2);

        if (!$ending === BaseCommand::NLCR) {
            throw new RuntimeException('Response must be ended with \r\n');
        }

        $tokens = explode(BaseCommand::NLCR, substr($response, 0, strlen($response) - 2));

        foreach ($tokens as $string) {
            foreach (explode(' ', $string) as $lexeme) {
                array_push($this->tokens, $lexeme);
            }
        }

        $this->assertResponseIsNotDescribedError();
    }

    /**
     * @return string[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function getToken(int $number)
    {
        if (array_key_exists($number, $this->tokens)) {
            return $this->tokens[$number];
        }

        throw new DomainException('Getting token by unexpected number: ' . $number);
    }

    private function assertResponseIsNotDescribedError(): void
    {
        $token = $this->getToken(0);

        if ($token == self::ERROR) {
            throw new NonExistentCommandException();
        }

        if ($token == self::CLIENT_ERROR) {
            unset($this->tokens[0]);
            $message = implode($this->tokens, ' ');

            throw new ClientException($message);
        }

        if ($token == self::SERVER_ERROR) {
            unset($this->tokens[0]);
            $message = implode($this->tokens, ' ');

            throw new ServerException($message);
        }
    }
}
