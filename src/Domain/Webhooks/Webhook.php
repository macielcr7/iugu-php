<?php

declare(strict_types=1);

namespace Iugu\Domain\Webhooks;

class Webhook
{
    public function __construct(
        public readonly string $id,
        public readonly string $event,
        public readonly string $url,
        public readonly string $mode,
        public readonly ?string $authorization,
    ) {
    }
} 