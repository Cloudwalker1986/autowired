<?php
declare(strict_types=1);

namespace Autowired\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class BeforeConstruct {}
