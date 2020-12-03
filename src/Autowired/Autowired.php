<?php
declare(strict_types=1);

namespace Autowired;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class Autowired {

    public function __construct(private ?bool $cachingAllowed = true)  {}

    public function shouldCache(): bool {
        return $this->cachingAllowed;
    }
}
