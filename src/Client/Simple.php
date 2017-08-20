<?php
declare(strict_types=1);

namespace Tarantool\Client;

use Tarantool\Client\{
    Command,
    Negotiation\CanAddNegotiator,
    Negotiation\ReceiveGreeting,
    Response,
    Response\RawData,
    Session\CanSession
};
use Tarantool\{
    Client,
    Connector
};

final class Simple implements Client
{
    use CanAddNegotiator;
    use CanSession;

    /** @var Connector */
    private $connector;

    public function __construct(
        Connector $connector,
        iterable $negotiators = []
    ) {
        $this->connector = $connector;

        foreach ($negotiators as $negotiator) {
            $this->addNegotiator($negotiator);
        }

        $this->connector->on('greeting', function ($greeting) {
            (new ReceiveGreeting($greeting))->negotiate($this);

            foreach ($this->negotiators as $negotiator) {
                $negotiator->negotiate($this);
            }
        });
    }

    public function request(Command $command): Response
    {
        $data = $this->connector->sendRequest($command);

        return new RawData($data);
    }
}
