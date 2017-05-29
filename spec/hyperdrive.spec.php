<?php
/**
 * Unit tests.
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
 * <https://codeberg.org/vhs/hyperdrive/blob/master/COPYING>.
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

      it('has expected locator with a query', function () {
        $expected = [$this->dependencyWithQuery[0][1]];
        expect(
          generate_antimatter($this->dependencyWithQuery)
        )
          ->toBeA('array')
          ->toBe($expected);
      });

      it('has expected locator without a query', function () {
        $expected = [$this->dependencyWithoutQuery[0][1]];
        expect(
          generate_antimatter($this->dependencyWithoutQuery)
        )
          ->toBeA('array')
          ->toBe($expected);
      });

      it('does not allow empty locators', function () {
        // get rid of them as early as possible; easy
      });

      it('does not have unedessary depth', function () {
        // when removing faux deps, we have [[]]
      });
    });

    describe('handles two shallow dependencies', function () {
      given('dependencies', function () {
        return $this->fixtures->twoIndependent;
      });

      it('has expected locators', function () {
        $firstDependency = $this->dependencies[0][1];
        $secondDependency = $this->dependencies[1][1];

        expect(
          generate_antimatter($this->dependencies)
        )
          ->toContain($firstDependency)
          ->toContain($secondDependency)
          ->toHaveLength(2);
      });
    });

    describe('handles faux compound deep dependencies', function () {
      given('dependencyWithoutLocator', function () {
        return $this->fixtures->withoutLocator;
      });
      given('fauxCompoundDeep', function () {
        return $this->fixtures->fauxCompoundDeep;
      });

      describe('compound deep dependency', function () {
        it('has expected deep dependencies', function () {
          $deepDependencies = $this->fauxCompoundDeep[0][2];
          $numDeepDependencies = count($deepDependencies);
          $firstDeep = $deepDependencies[0][1];
          $secondDeep = $deepDependencies[1][1];

          expect(
            generate_antimatter($this->fauxCompoundDeep)
          )
            ->toContain($firstDeep)
            ->toContain($secondDeep)
            ->toHaveLength($numDeepDependencies);
        });
      });
    });

    describe('deduplicates deep dependencies', function () {
      describe('at same depth', function () {
        given('singleCommonDeep', function () {
          return $this->fixtures->singleCommonDeep;
        });
        given('multipleCommonDeep', function () {
          return $this->fixtures->multipleCommonDeep;
        });

        it('removes single common deep dependency', function () {
          $firstWithCommonDeep = $this->singleCommonDeep[0];
          $secondWithCommonDeep = $this->singleCommonDeep[1];
          $commonDeepDependencies = [
            $firstWithCommonDeep[2][0]
          ];

          expect($firstWithCommonDeep[2])->toBe($commonDeepDependencies);
          expect($secondWithCommonDeep[2])->toBe($commonDeepDependencies);
          expect(
            generate_antimatter($this->singleCommonDeep)
          )
            ->toContain($firstWithCommonDeep[1])
            ->toContain($secondWithCommonDeep[1])
            ->toContain([$commonDeepDependencies[0][1]])
            ->toHaveLength(3);
        });

        it('removes multiple common deep dependencies', function () {
          // $firstWithCommonDeep = $this->multipleCommonDeep[0];
          // $secondWithCommonDeep = $this->multipleCommonDeep[1];
          // $commonDeepDependencies = [
          //   $firstWithCommonDeep[2][0],
          //   $firstWithCommonDeep[2][1]
          // ];
          //
          // expect($firstWithCommonDeep[2])->toBe($commonDeepDependencies);
          // expect($secondWithCommonDeep[2])->toBe($commonDeepDependencies);
          // expect(
          //   generate_antimatter($this->multipleCommonDeep)
          // )
          //   ->toContain($firstWithCommonDeep[1])
          //   ->toContain($secondWithCommonDeep[1])
          //   ->toContain([
          //     $commonDeepDependencies[0][1],
          //     $commonDeepDependencies[1][1]
          //   ])->toHaveLength(3);
        });
      });

      describe('at different depths', function () {
        given('singleCommonDeepDifferentDepths', function () {
          return $this->fixtures->singleCommonDeepDifferentDepths;
        });
        given('multipleCommonDeepDifferentDepths', function () {
          return $this->fixtures->multipleCommonDeepDifferentDepths;
        });

        it('removes single common deep dependency', function () {
          $firstWithCommonDeep = $this->singleCommonDeepDifferentDepths[0];
          $secondWithCommonDeep = $this->singleCommonDeepDifferentDepths[1];
          $commonDeepDependencies = [
            $firstWithCommonDeep[2][0]
          ];

          $actual = generate_antimatter($this->singleCommonDeepDifferentDepths);
          print_r($actual);

          expect($firstWithCommonDeep[2])->toBe($commonDeepDependencies);
          expect($secondWithCommonDeep[2][0][2])->toBe($commonDeepDependencies);
          expect(
            generate_antimatter($this->singleCommonDeepDifferentDepths)
          )
            ->toContain($firstWithCommonDeep[1])
            ->toContain($secondWithCommonDeep[1])
            ->toContain([$commonDeepDependencies[0][1]])
            ->toHaveLength(4);
        });

        it('removes multiple common deep dependencies', function () {
          // $firstWithCommonDeep = $this->multipleCommonDeepDifferentDepths[0];
          // $secondWithCommonDeep = $this->multipleCommonDeepDifferentDepths[1];
          // $commonDeepDependencies = $firstWithCommonDeep[2];
          //
          // expect($firstWithCommonDeep[2])->toBe($commonDeepDependencies);
          // expect($secondWithCommonDeep[2][0][2])->toBe($commonDeepDependencies);
          //
          // expect(
          //   generate_antimatter($this->multipleCommonDeepDifferentDepths)
          // )
          //   // ->toContain($firstWithCommonDeep[1])
          //   // ->toContain($secondWithCommonDeep[1])
          //   // ->toContain([$commonDeepDependencies[0][1]])
          //   ->toHaveLength(3);
        });

        describe('with complex chains and faux dependencies', function () {
          given('complexCommonDeepWithFaux', function () {
            return $this->fixtures->complexCommonDeepWithFaux;
          });

          it('has expected antimatter particles', function () {
            $firstCommonDeep = $this->complexCommonDeepWithFaux[0][2][0][2][0];
            $secondCommonDeep = $this->complexCommonDeepWithFaux[0][2][0][2][1];
          });
        });
      });
    });
  });
});
