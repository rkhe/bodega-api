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

abstract class AuthorizedPages extends Enum
{
  const USERS = 'users';
  const WAREHOUSES = 'warehouses';
  const CUSTOMERS = 'customers';

  // Materials and configurations (conversions, storage_types, etc)
  const MATERIALS = 'materials';

  // Inbound
  const RECEIVINGS = 'receivings';
  const PUT_AWAYS = 'put_aways';
  const FULL_BIN_TO_BIN = 'full_bin_to_bin';
  const PARTIAL_BIN_TO_BIN = 'partial_bin_to_bin';

  // Outbound
  const DISPATCHES = 'dispatches';
  const PICKLISTS = 'picklists';
  const PICKLIST_CONFIRMATIONS = 'picklist_confirmations';

  // Storages
  const STORAGES = 'storages';
}

abstract class UserRoles extends Enum
{
  const SUPER = 1;
  const ADMINISTRATOR = 2;
  const ANALYST = 3;
  const CONTROLLER = 4;
  const CHECKER = 5;
  const FORKLIFT = 6;
  const PICKER = 7;
}

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
