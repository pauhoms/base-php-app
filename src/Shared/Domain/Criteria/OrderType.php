<?php
declare(strict_types=1);

namespace Shared\Domain\Criteria;

use InvalidArgumentException;
use Shared\Domain\ValueObjects\Enum;

enum OrderType: string
{
    case ASC  = 'asc';
    case DESC = 'desc';
    case NONE = 'none';
}
