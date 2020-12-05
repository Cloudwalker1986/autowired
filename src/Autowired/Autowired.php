<?php
declare(strict_types=1);

namespace Autowired;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class Autowired {

    public function __construct(
        private ?bool $cachingAllowed = true,
        private ?string $concreteClass = null,
        private ?string $staticFunction = null
    )  {}

    public function shouldCache(): bool {
        return $this->cachingAllowed;
    }

    public function getConcreteClass(): ?string
    {
        return $this->concreteClass;
    }

    public function hasStaticFunction(): bool
    {
        return $this->staticFunction !== null;
    }

    public function getStaticFunction(): ?string
    {
        return $this->staticFunction;
    }
}
