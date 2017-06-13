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
 * Copyright (C) 2017  VHS <josh@vhs.codeberg.page>
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

use function hyperdrive\generate_antimatter;
use function hyperdrive\enter_hyperspace;
use function hyperdrive\array_moonwalk;
use function hyperdrive\fold_spacetime;
use function hyperdrive\get_dependency_data;
use function hyperdrive\get_enqueued_deps;
use function hyperdrive\get_dep_for_handle;
use function hyperdrive\get_src_for_handle;
use function hyperdrive\get_deps_for_handle;

describe('hyperdrive', function () {
  given('fixtures', function () {
    $core = json_decode(file_get_contents(__DIR__ . '/fixtures/core.json'));
    $coords = json_decode(file_get_contents(__DIR__ . '/fixtures/coords.json'));
    return ['core' => $core, 'coords' => $coords];
  });

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
    describe('handles a single dependency', function () {
      given('dependencyWithQuery', function () {
        return $this->fixtures['core']->singleWithQuery;
      });
      given('dependencyWithoutQuery', function () {
        return $this->fixtures['core']->singleWithoutQuery;
      });

      it('has expected locator with a query', function () {
        $expected = [$this->dependencyWithQuery[0][1]];
        expect(
          generate_antimatter($this->dependencyWithQuery)
        )
          ->toBe($expected);
      });

      it('has expected locator without a query', function () {
        $expected = [$this->dependencyWithoutQuery[0][1]];
        expect(
          generate_antimatter($this->dependencyWithoutQuery)
        )
          ->toBe($expected);
      });
    });

    describe('handles two shallow dependencies', function () {
      given('dependencies', function () {
        return $this->fixtures['core']->twoIndependent;
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
        return $this->fixtures['core']->withoutLocator;
      });
      given('fauxCompoundDeep', function () {
        return $this->fixtures['core']->fauxCompoundDeep;
      });

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

      it('strips empty locators', function () {
        $fauxDependency = $this->fauxCompoundDeep[0];

        expect($fauxDependency)->toContain('');
        expect(
          generate_antimatter($this->fauxCompoundDeep)
        )
          ->not->toContain('');
      });

      it('does not have unnecessary depth', function () {
        $deepDependencies = $this->fauxCompoundDeep[0][2];

        expect($deepDependencies[0])->toBeAn('array');
        expect(
          generate_antimatter($this->fauxCompoundDeep)[0]
        )
          ->not->toBeAn('array');
      });

      it('sorts dependency locators', function () {
        $deepDependencies = $this->fauxCompoundDeep[0][2];
        $firstDeepLocator = $deepDependencies[0][1];
        $secondDeepLocator = $deepDependencies[1][1];
        $expected = [
          $secondDeepLocator,
          $firstDeepLocator
        ];

        expect(
          generate_antimatter($this->fauxCompoundDeep)
        )
          ->toBe($expected);
      });
    });

    describe('removes common deep dependencies at same depth', function () {
      given('singleCommonDeepSameDepth', function () {
        return $this->fixtures['core']->singleCommonDeepSameDepth;
      });
      given('multipleCommonDeepSameDepth', function () {
        return $this->fixtures['core']->multipleCommonDeepSameDepth;
      });

      it('removes single common deep dependency', function () {
        $firstWithCommonDeep = $this->singleCommonDeepSameDepth[0];
        $secondWithCommonDeep = $this->singleCommonDeepSameDepth[1];
        $expected = [
          '/js/global.js?ver=1.0',
          '/js/jquery.scrollTo.js?ver=2.1.2',
          [
            '/js/jquery/jquery.js?ver=1.12.4'
          ]
        ];

        expect($firstWithCommonDeep[2])->toBe($secondWithCommonDeep[2]);
        expect(
          generate_antimatter($this->singleCommonDeepSameDepth)
        )
          ->toBe($expected);
      });

      it('removes multiple common deep dependencies', function () {
        $firstWithCommonDeep = $this->multipleCommonDeepSameDepth[0];
        $secondWithCommonDeep = $this->multipleCommonDeepSameDepth[1];
        $expected = [
          '/js/global.js?ver=1.0',
          '/js/jquery.scrollTo.js?ver=2.1.2',
          [
            '/js/jquery/jquery-migrate.min.js?ver=1.4.1',
            '/js/jquery/jquery.js?ver=1.12.4'
          ]
        ];

        expect($firstWithCommonDeep[2])->toBe($secondWithCommonDeep[2]);
        expect(
          generate_antimatter($this->multipleCommonDeepSameDepth)
        )
          ->toBe($expected);
      });
    });

    describe('works in real world use cases', function () {
      given('poseidonTheme', function () {
        return $this->fixtures['coords']->themes->poseidon;
      });

      it('works with the poseidon theme', function () {
        $expected = [
          '/wp-content/themes/poseidon/js/navigation.js?ver=20170127',
          '/wp-content/themes/poseidon/js/sticky-header.js?ver=20170203',
          [
            '/wp-includes/js/jquery/jquery.js?ver=1.12.4'
          ]
        ];

        expect(
          generate_antimatter($this->poseidonTheme)
        )->toBe($expected);
      });
    });
  });

  describe('array_moonwalk()', function () {
    given('multipleCommonDeepDifferentDepths', function () {
      return $this->fixtures['core']->multipleCommonDeepDifferentDepths;
    });

    it('deduplicates an array at different depths', function () {
      $firstWithCommonDeep = $this->multipleCommonDeepDifferentDepths[0];
      $secondWithCommonDeep = $this->multipleCommonDeepDifferentDepths[1][2][2];
      $dependencies = $this->multipleCommonDeepDifferentDepths;
      $expected = [
        '/js/global.js?ver=1.0' => 1,
        '/js/superfish.min.js' => 1,
        '/js/jquery/jquery-migrate.min.js?ver=1.4.1' => 3,
        '/js/jquery/jquery.js?ver=1.12.4' => 3,
        '/js/jquery.hoverIntent.js' => 2
      ];

      expect($firstWithCommonDeep[2])->toBe($secondWithCommonDeep[2]);
      $antiparticles = generate_antimatter(
        $this->multipleCommonDeepDifferentDepths
      );
      expect($antiparticles)->not->toBe($expected);
      expect($antiparticles)->not->toBe($dependencies);

      $accumulator = [];
      array_moonwalk($antiparticles, $accumulator);

      expect($antiparticles)->not->toBe($expected);
      expect($accumulator)->toBeAn('array')->toBe($expected);
    });
  });

  describe('fold_spacetime()', function () {
    given('multipleCommonDeepDifferentDepths', function () {
      return $this->fixtures['core']->multipleCommonDeepDifferentDepths;
    });

    it('outputs string containing program names and versions', function () {
      $reSemVer = '\bv?(?:0|[1-9][0-9]*)\.(?:0|[1-9][0-9]*)\.(?:0|[1-9][0-9]*)(?:-[\da-z\-]+(?:\.[\da-z\-]+)*)?(?:\+[\da-z\-]+(?:\.[\da-z\-]+)*)?\b';
      $antiparticles = generate_antimatter(
        $this->multipleCommonDeepDifferentDepths
      );

      expect(
        fold_spacetime($antiparticles)
      )
        ->toBeA('string')
        ->toMatch("/Hyperdrive\s{$reSemVer}/")
        ->toMatch("/Fetch\sInject\s{$reSemVer}/");
    });

    describe('common syntax errors', function () {
      given('reSyntaxErrors', function () {
        return ',\s*?\]|,\s*?\)|\(\s*?,|\]\s*?\[|\)\s*?\(';
      });
      given('singleCommonDeepDifferentDepths', function () {
        return $this->fixtures['core']->singleCommonDeepDifferentDepths;
      });
      given('complexCommonDeepWithFaux', function () {
        return $this->fixtures['core']->complexCommonDeepWithFaux;
      });

      it('does not error for `singleCommonDeepDifferentDepths`', function () {
        $antiparticles = generate_antimatter(
          $this->singleCommonDeepDifferentDepths
        );

        expect(
          fold_spacetime($antiparticles)
        )
          ->toBeA('string')
          ->not->toMatch("/{$this->reSyntaxErrors}/");
      });

      it('does not error for `multipleCommonDeepDifferentDepths`', function () {
        $antiparticles = generate_antimatter(
          $this->multipleCommonDeepDifferentDepths
        );

        expect(
          fold_spacetime($antiparticles)
        )
          ->toBeA('string')
          ->not->toMatch("/{$this->reSyntaxErrors}/");
      });

      it('does not error for `complexCommonDeepWithFaux`', function () {
        $antiparticles = generate_antimatter(
          $this->complexCommonDeepWithFaux
        );

        expect(
          fold_spacetime($antiparticles)
        )
          ->toBeA('string')
          ->not->toMatch("/{$this->reSyntaxErrors}/");
      });
    });
  });

  describe('get_dependency_data()', function () {
    beforeAll(function () {
      include_once __DIR__ . "/mocks/class.wp-dependencies.php";
      include_once __DIR__ . "/mocks/class-wp-dependency.php";
    });
    given('dependency', function () {
      $dependency = new \_WP_Dependency();
      $dependency->handle = 'fetch-inject';
      $dependency->src = 'https://cdn.jsdelivr.net/npm/fetch-inject';
      $dependency->ver = '';
      return $dependency;
    });
    given('dependencies', function () {
      $dependencies = new \WP_Dependencies();
      $dependencies->registered = ['fetch-inject' => $this->dependency];
      $dependencies->queue = ['fetch-inject'];
      return $dependencies;
    });

    it('errors if not given an instance', function () {
      $closure = function () {
        get_dependency_data(null, ['baz']);
      };
      expect($closure)->toThrow();
    });

    it('errors if not given a handle', function () {
      $dependencies = $this->dependencies;
      $closure = function () use ($dependencies) {
        get_dependency_data($dependencies);
      };
      expect($closure)->toThrow();
    });

    it('errors if given an unregistered handle', function () {
      $dependencies = $this->dependencies;
      $closure = function () use ($dependencies) {
        get_dependency_data($dependencies, ['spaceballs']);
      };
      expect($closure)->toThrow();
    });

    it('does not error if given an empty array of handles', function () {
      $dependencies = $this->dependencies;
      $closure = function () use ($dependencies) {
        get_dependency_data($dependencies, []);
      };
      expect($closure)->not->toThrow();
    });

    it('skips dependencies with conditional comments', function () {
      expect('MSIE always sucked')->toBeTruthy();
    });
  });

  describe('get_enqueued_deps()', function () {
    beforeAll(function () {
      include_once __DIR__ . "/mocks/class.wp-dependencies.php";
    });
    given('dependencies', function () {
      return new \WP_Dependencies();
    });

    it('errors if not given an instance', function () {
      $closure = function () {
        get_dep_for_handle(null, 'baz');
      };
      expect($closure)->toThrow();
    });

    it('does not return registered items not in queue', function () {
      $dependencies = $this->dependencies;
      $dependencies->registered = ['foo'];
      expect($dependencies->registered)->not->toHaveLength(0);
      expect($dependencies->queue)->toHaveLength(0);
      expect(
        get_enqueued_deps($dependencies)
      )->toBeEmpty();
    });

    it('returns all expected items', function () {
      $dependencies = $this->dependencies;
      $dependencies->queue = ['foo', 'bat', 'rab'];
      $dependencies->registered = [
        'foo' => 'foo',
        'rab' => 'oof',
        'bat' => 'bat',
        'baz' => 'baz'
      ];
      expect(
        get_enqueued_deps($dependencies)
      )->toBe(['foo', 'bat', 'oof']);
    });

    it('does not return unexpected items', function () {
      $dependencies = $this->dependencies;
      $dependencies->queue = ['bar'];
      $dependencies->registered = ['bar' => 'baz', 'bat' => 'bat'];
      expect(
        get_enqueued_deps($dependencies)
      )
        ->toContain('baz')
        ->not->toContain('bat');
    });
  });

  describe('get_dep_for_handle()', function () {
    beforeAll(function () {
      include_once __DIR__ . "/mocks/class.wp-dependencies.php";
    });
    given('dependencies', function () {
      return new \WP_Dependencies();
    });

    it('errors if not given an instance', function () {
      $closure = function () {
        get_dep_for_handle(null, 'baz');
      };
      expect($closure)->toThrow();
    });

    it('errors if not given a handle', function () {
      $dependencies = $this->dependencies;
      $closure = function () use ($dependencies) {
        get_dep_for_handle($dependencies);
      };
      expect($closure)->toThrow();
    });

    it('errors if handle is not registered', function () {
      $dependencies = $this->dependencies;
      $dependencies->registered = ['foo' => 'bar'];
      $closure = function () use ($dependencies) {
        get_dep_for_handle($dependencies, 'baz');
      };
      expect($closure)->toThrow();
    });

    it('returns registered item given handle', function () {
      $dependencies = $this->dependencies;
      $dependencies->registered = ['foo' => 'bar'];
      expect(
        get_dep_for_handle($dependencies, 'foo')
      )->toBe('bar');
    });

    it('does not return unexpected registered items', function () {
      $dependencies = $this->dependencies;
      $dependencies->registered = ['foo' => 'bar', 'baz' => 'bat'];
      expect(get_dep_for_handle($dependencies, 'foo'))->toBe('bar');
      expect(get_dep_for_handle($dependencies, 'baz'))->toBe('bat');
    });
  });

  describe('get_src_for_handle()', function () {
    beforeAll(function () {
      include_once __DIR__ . "/mocks/class.wp-dependencies.php";
      include_once __DIR__ . "/mocks/class-wp-dependency.php";
    });
    given('dependency', function () {
      $dependency = new \_WP_Dependency();
      $dependency->handle = 'fetch-inject';
      $dependency->src = 'https://cdn.jsdelivr.net/npm/fetch-inject';
      $dependency->ver = '';
      return $dependency;
    });
    given('dependencies', function () {
      $dependencies = new \WP_Dependencies();
      $dependencies->registered = ['fetch-inject' => $this->dependency];
      $dependencies->queue = ['fetch-inject'];
      return $dependencies;
    });

    it('errors if not given an instance', function () {
      $closure = function () {
        get_src_for_handle(null, 'baz');
      };
      expect($closure)->toThrow();
    });

    it('errors if not given a handle', function () {
      $dependencies = $this->dependencies;
      $closure = function () use ($dependencies) {
        get_src_for_handle($dependencies);
      };
      expect($closure)->toThrow();
    });

    it('returns a string with version query', function () {
      $dependencies = $this->dependencies;
      $dependency = $this->dependency;
      $version = '1.8.1';
      $dependency->ver = $version;
      expect(
        get_src_for_handle($dependencies, 'fetch-inject')
      )->toContain("?ver=$version");
    });

    it('returns a string without version query', function () {
      $dependencies = $this->dependencies;
      $dependency = $this->dependency;
      expect(
        get_src_for_handle($dependencies, 'fetch-inject')
      )->not->toContain("?ver=");
    });
  });

  describe('get_deps_for_handle()', function () {
    beforeAll(function () {
      include_once __DIR__ . "/mocks/class.wp-dependencies.php";
      include_once __DIR__ . "/mocks/class-wp-dependency.php";
    });
    given('dependency', function () {
      $dependency = new \_WP_Dependency();
      $dependency->handle = 'fetch-inject';
      $dependency->src = 'https://cdn.jsdelivr.net/npm/hack';
      $dependency->ver = '';
      $dependency->deps = [];
      return $dependency;
    });
    given('dependencies', function () {
      $dependencies = new \WP_Dependencies();
      $dependencies->registered = ['fetch-inject' => $this->dependency];
      $dependencies->queue = ['fetch-inject'];
      return $dependencies;
    });

    it('errors if not given an instance', function () {
      $closure = function () {
        get_deps_for_handle(null, 'fetch-inject');
      };
      expect($closure)->toThrow();
    });

    it('errors if not given a handle', function () {
      $dependencies = $this->dependencies;
      $closure = function () use ($dependencies) {
        get_deps_for_handle($dependencies);
      };
      expect($closure)->toThrow();
    });

    it('returns empty if no dependencies of dependency', function () {
      $dependencies = $this->dependencies;
      $dependencyHandle = $this->dependency->handle;
      $dependentDependencies = $this->dependency->deps;
      expect($dependencies->queue)->toContain($dependencyHandle);
      expect($dependencies->registered[$dependencyHandle])->toBeTruthy();
      expect($dependentDependencies)->toHaveLength(0);
      expect(
        get_deps_for_handle($dependencies, $dependencyHandle)
      )->toBeEmpty();
    });

    it('returns handles if dependencies of dependency', function () {
      $dependencies = $this->dependencies;
      $dependencyHandle = $this->dependency->handle;
      $this->dependency->deps = ['foo', 'bar', 'baz', 'bat'];
      $dependentDependencies = $this->dependency->deps;
      expect($dependencies->queue)->toContain($dependencyHandle);
      expect($dependencies->registered[$dependencyHandle])->toBeTruthy();
      expect($dependentDependencies)->toHaveLength(4);
      expect(
        get_deps_for_handle($dependencies, $dependencyHandle)
      )->toBe($dependentDependencies);
    });
  });
});
