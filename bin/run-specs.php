#!/usr/bin/env php
<?php
/**
 * Unit testing bootstrap file
 *
 * @package     Hyperdrive
 * @author      VHS
 * @since       1.0.0
 * @license     AGPL-3.0 or any later version
 *
 * Hyperdrive - The fastest way to load pages in WordPress.
 * Copyright (C) 2017  VHS
 *
 * Hyperdrive is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Hyperdrive is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Hyperdrive.  If not, see
 * https://codeberg.org/vhs/hyperdrive/blob/master/COPYING.
 */

$vendorDir = realpath(__DIR__ . "/../vendor");

include_once $vendorDir . "/antecedent/patchwork/Patchwork.php";

use function Patchwork\redefine as redefine;
use function Patchwork\always as always;

redefine('die', always(null));
redefine('add_action', always(null));

include_once $vendorDir . "/bin/kahlan";
