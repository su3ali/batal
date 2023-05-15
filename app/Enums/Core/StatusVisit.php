<?php

namespace App\Enums\Core;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self scheduled()
 * @method static self delayed()
 * @method static self under_procedure()
 * @method static self finished()
 * @method static self canceled()
 **/
class StatusVisit extends Enum
{
}
