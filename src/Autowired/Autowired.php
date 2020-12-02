<?php
declare(strict_types=1);

namespace Autowired;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
interface Autowired {}
