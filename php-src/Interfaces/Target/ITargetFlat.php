<?php

namespace kalanis\kw_storage\Interfaces\Target;


/**
 * Interface ITargetFlat
 * @package kalanis\kw_storage\Interfaces
 * It's stored as flat key-value structure
 *
 * Return value of lookup also will contain all available sub values, not just these on asked level
 */
interface ITargetFlat extends ITarget
{
}
