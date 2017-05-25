<?php
/**
 * Hyperdrive unit tests
 *
 * @package Hyperdrive
 *
 * Hyperdrive - The fastest way to load pages in WordPress.
 * Copyright (C) 2017  VHS
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see
 * <https://choosealicense.com/licenses/agpl-3.0/>.
 */

namespace hyperdrive\spec;

use function hyperdrive\enter_hyperspace;
use function hyperdrive\generate_antimatter;

describe('hyperdrive', function () {
  describe('enter_hyperspace()', function () {
    it('echos empty script given empty string', function () {
      $closure = function () { enter_hyperspace(''); };
      expect($closure)->toEcho('<script></script>');
    });

    it('echos string in script given string', function () {
      $closure = function () { enter_hyperspace('Danger, Will Robinson!'); };
      expect($closure)->toEcho('<script>Danger, Will Robinson!</script>');
    });

    it('does not echo unexpected string', function () {
      $closure = function () { enter_hyperspace('Danger, Will Robinson!'); };
      expect($closure)->not->toEcho('<script>Warning! Warning!</script>');
    });
  });

  describe('generate_antimatter()', function () {
    given('fixtures', function () {
      return json_decode(
        file_get_contents(__DIR__ . "/fixtures/dependencies.json")
      );
    });

    describe('handles a single dependency', function () {
      given('dependencyWithQuery', function () {
        return $this->fixtures->singleWithQuery;
      });
      given('dependencyWithoutQuery', function () {
        return $this->fixtures->singleWithoutQuery;
      });

      describe('has expected locator', function () {
        it('with a query', function () {
          $expected = [$this->dependencyWithQuery[0][1]];
          expect(
            generate_antimatter($this->dependencyWithQuery)
          )
            ->toBeA('array')
            ->toBe($expected);
        });

        it('without a query', function () {
          $expected = [$this->dependencyWithoutQuery[0][1]];
          expect(
            generate_antimatter($this->dependencyWithoutQuery)
          )
            ->toBeA('array')
            ->toBe($expected);
        });
      });
    });

    describe('handles two shallow dependencies', function () {
      given('dependencies', function () {
        return $this->fixtures->twoIndependent;
      });

      it('has expected locators', function () {
        $expected = [
          $this->dependencies[0][1],
          $this->dependencies[1][1]
        ];
        expect(
          generate_antimatter($this->dependencies)
        )
          ->toBeA('array')
          ->toBe($expected);
      });
    });

    describe('handles faux compound deep dependencies', function () {
      given('dependencyWithoutLocator', function () {
        return $this->fixtures->withoutLocator;
      });
      given('fauxCompoundDeepDependency', function () {
        return $this->fixtures->fauxCompoundDeepDependency;
      });

      // Not a realistic isolated scenario.
      describe('single dependency', function () {
        it('has expected locator', function () {
          $expected = [''];
          expect(
            generate_antimatter($this->dependencyWithoutLocator)
          )
            ->toBeA('array')
            ->toBe($expected);
        });
      });

      describe('compound deep dependency', function () {
        it('has expected shallow locator', function () {
          $expected = [''];
          expect(
            generate_antimatter($this->dependencyWithoutLocator)
          )
            ->toBeA('array')
            ->toBe($expected);
        });

        it('has expected deep dependencies', function () {
          $deepDependencies = $this->fauxCompoundDeepDependency[0][2];
          $numDeepDependencies = count($deepDependencies);
          $expected = [
            $deepDependencies[0][1],
            $deepDependencies[1][1]
          ];
          expect(
            generate_antimatter($this->fauxCompoundDeepDependency)
          )
            ->toHaveLength($numDeepDependencies)
            ->toContain($expected);
        });
      });
    });
  });
});
