<?php

// closed
// open
// voided
// completed
// pending
// voided
// draft
// to_review
// enabled
// disabled

abstract class UserStatuses extends Enum
{
  const ACTIVE = 1;
  const INACTIVE = 2;
}



abstract class StandardPrecisions extends Enum
{
  const NET_WEIGHT = 3;
  const TOTAL_WEIGHT = 3;
  const NET_VOLUME = 3;
  const TOTAL_VOLUME = 6;
}


/**
 * Base class
 * DO NOT REMOVE
 */

abstract class Enum
{
  static function getKeys()
  {
    $class = new ReflectionClass(get_called_class());
    return array_keys($class->getConstants());
  }
}
