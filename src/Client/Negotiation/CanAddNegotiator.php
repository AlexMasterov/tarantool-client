<?php
declare(strict_types=1);

namespace Tarantool\Client\Negotiation;

use Tarantool\Client\Negotiation;

trait CanAddNegotiator
{
    /** @var array */
    private $negotiators = [];

    public function addNegotiator(Negotiation $negotiation): void
    {
        $this->negotiators[] = $negotiation;
    }
}
