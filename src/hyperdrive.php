<?php
/**
 * WordPress plugin.
 *
 * @package     Hyperdrive
 * @author      VHS
 * @since       1.0.0
 * @license     AGPL-3.0 or any later version
 *
 * Plugin Name:     Hyperdrive
 * Plugin URI:      https://codeberg.org/vhs/hyperdrive
 * Description:     The fastest way to load pages in WordPress.
 * Version:         1.0.0-beta.6
 * Author:          VHS
 * Author URI:      https://vhs.codeberg.page
 * Text Domain:     hyperdrive
 * License:         AGPL-3.0 or any later version
 * License URI:     https://codeberg.org/vhs/hyperdrive/blob/master/COPYING
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

namespace hyperdrive;

/**
 * Put WordPress into Hyperdrive.
 *
 * Hook action into where most themes and plugins load scripts.
 * Late in action lifecycle. Apply with unusually low priority.
 * Exit early if executed outside WordPress.
 *
 * @since 1.0.0
 */
defined( 'ABSPATH' )
	? \add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\engage', 1987 )
	: die( 'Now Princess Vespa, at last we are alone.' );

/**
 * Prevent WordPress from loading jQuery Migrate.
 *
 * @since 1.0.0
 * @link https://stackoverflow.com/a/25977181/712334
 * @param WP_Scripts $scripts Default WordPress scripts.
 */
defined( 'ABSPATH' ) && add_filter(
	'wp_default_scripts',
	function ( &$scripts ) {
		if ( is_admin() ) return;
		$scripts->remove( 'jquery' );
		$scripts->add( 'jquery', false, [ 'jquery-core' ] );
	}
);

/**
 * Calibrate thrusters.
 *
 * Creates an associative array containing structured data required
 * for Fetch Injection. Also dequeues enqueued scripts so WordPress
 * doesn't load them. Data structure is assumed by functions using
 * and used by this method.
 *
 * @since Hyperdrive 1.0.0
 * @return Multidimensional array of destination coordinates.
 */
function calibrate_thrusters() {
	$coordinates = [];
	$scripts = get_enqueued_scripts();
	foreach ( $scripts as $script ) {
		if ( empty( $script->extra['conditional'] ) ) {
			// It's a good thing you were wearing that helmet.
			$coordinates[] = [
				$script->handle,
				get_src_for_handle( $script->handle ),
				get_dependency_data( $script->deps ),
			];
			// Not in here, mister! This is a Mercedes!
			\wp_dequeue_script( $script->handle );
		}
	}
	return $coordinates;
}

/**
 * Generate antiparticles.
 *
 * Recursive function translates destination coordinates into
 * into antimatter particles recursively with some deduplication
 * and sorting. Throws away empty locators used by WordPress and
 * prevents nesting arrays with single array children.
 *
 * @since Hyperdrive 1.0.0
 * @param array $coordinates Destination coordinates.
 * @return Antiparticles for use in folding spacetime.
 */
function generate_antimatter( $coordinates ) {
	$antiparticles = [];
	foreach ( $coordinates as $coordinate ) {
		list( $handle, $locator, $dimensions ) = $coordinate;
		! empty( $locator ) && $antiparticles[] = "{$locator}";
		$dimensions && $antiparticles[] = generate_antimatter( $dimensions, true );
	}
	is_array( reset( $antiparticles ) ) && $antiparticles = reset( $antiparticles );
	array_multisort( $antiparticles );
	$antiparticles = array_map('unserialize', array_unique(
		array_map( 'serialize', $antiparticles )
	));
	return $antiparticles;
}

/**
 * Convert antiparticles.
 *
 * Performs a moonwalk to dedupe any remaining multidimensional
 * dopplegangers in alternate dimensions and constructs a script
 * to handle page resource Fetch Injection.
 *
 * @since Hyperdrive 1.0.0
 * @param array $antiparticles Antimatter particles.
 * @return A Fetch Inject script.
 */
function fold_spacetime( $antiparticles ) {
	$injection = '';
	$injectors = [];

	// Careful you idiot! I said across her nose, not up it!
	array_moonwalk( $antiparticles, $injectors );

	$depths = array_count_values( $injectors );
	$locators = array_keys( $injectors );

	$left = count( $depths );
	foreach ( $depths as $depth => $quantity ) {
		$left--;
		$injections = [];
		do {
			$injections[] = array_shift( $locators );
			$quantity--;
		} while ( $quantity > 0 );
		$encoded = json_encode( $injections, JSON_UNESCAPED_SLASHES );
		$injection .= "fetchInject($encoded";
		$injection .= $left
			? ', '
			: array_reduce( $depths, function ( $str ) { return $str . ')'; } );
	}

	return <<<EOD
/*! Hyperdrive v1.0.0-beta.6 | (c) 2017 VHS | @license AGPL-3.0 or any later version */
/*! Fetch Inject v1.7.0 | (c) 2017 VHS | @license ISC */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):e.fetchInject=t()}(this,function(){"use strict";const e=function(e,t,n,o,r,i,c){i=t.createElement(n),c=t.getElementsByTagName(n)[0],i.appendChild(t.createTextNode(o.text)),i.onload=r(o),c?c.parentNode.insertBefore(i,c):t.head.appendChild(i)};return function(t,n){if(!t||!Array.isArray(t))return Promise.reject(new Error("`inputs` must be an array"));if(n&&!(n instanceof Promise))return Promise.reject(new Error("`promise` must be a promise"));const o=[],r=n?[].concat(n):[],i=[];return t.forEach(e=>r.push(window.fetch(e).then(e=>[e.clone().text(),e.blob()]).then(e=>Promise.all(e).then(e=>{o.push({text:e[0],blob:e[1]})})))),Promise.all(r).then(()=>{o.forEach(t=>{i.push({then:n=>{t.blob.type.includes("text/css")?e(window,document,"style",t,n):e(window,document,"script",t,n)}})});return Promise.all(i)})}});
$injection;
EOD;
}

/**
 * Enter hyperspace.
 *
 * @since Hyperdrive 1.0.0
 * @param string $dark_matter A Fetch Inject script.
 */
function enter_hyperspace( $dark_matter ) {
	echo "<script>{$dark_matter}</script>";
}

/**
 * Engage the hyperdrive.
 *
 * @since Hyperdrive 1.0.0
 * @return A black hole.
 */
function engage() {
	enter_hyperspace( // Sir hadn't you better buckle up?
		fold_spacetime( generate_antimatter( calibrate_thrusters() ) )
	);
}

/**
 * Moonwalk an array.
 *
 * Deduplicates multidimensional array by flattening it while preserving
 * the deepest depth and flipping it inside out. Array values become the
 * keys and the new values contain the depths.
 *
 * @since Hyperdrive 1.0.0
 * @param array $array A multidimensional array of variable depth.
 * @param array $accumulator A reference identifier for a stored result.
 * @param integer [$depth = 1] Starting depth for array search.
 * @param boolean [$recursing = false] True while doing a moonwalk.
 * @return A flattened, deduplicated array with leaf node values as keys
 *     and deepest depth of any given leaf as the value.
 */
function array_moonwalk( $array, &$accumulator, &$depth = 1, $recursing = false ) {
	array_walk( $array, function ( $element ) use ( &$accumulator, &$depth, $recursing ) {
		is_array( $element )
			? ++$depth && array_moonwalk( $element, $accumulator, $depth, true )
			: $accumulator[ $element ] = $depth;
	});
	$recursing && --$depth;
}

/**
 * Get dependency data.
 *
 * Constructs a multidimensional array of dependency data
 * given an array of `$handles`.
 *
 * @since Hyperdrive 1.0.0
 * @param array<string> $handles An array of handles.
 * @return Dependency data matching expected structure.
 */
function get_dependency_data( $handles ) {
	$dependency_data = [];
	foreach ( $handles as $handle ) {
		$source_url = get_src_for_handle( $handle );
		if ( $source_url ) {
			$dependency_data[] = [ $handle, $source_url, [] ];
		}
		$deps = get_deps_for_handle( $handle );
		if ( count( $deps ) > 0 ) {
			$dependency_data[] = [
				$handle, '', get_dependency_data( $deps )
			];
		}
	}
	return $dependency_data;
}

/**
 * Get enqueued dependencies.
 *
 * @since Hyperdrive 1.0.0
 * @return An array of enqueued _WP_Dependency handle objects.
 */
function get_enqueued_scripts() {
	$wp_scripts = \wp_scripts();
	foreach ( $wp_scripts->queue as $handle ) {
		$enqueued_scripts[] = get_dep_for_handle( $handle );
	}
	return $enqueued_scripts;
}

/**
 * Get dependency.
 *
 * @since Hyperdrive 1.0.0
 * @param string $handle The handle.
 * @return A _WP_Dependency handle object.
 */
function get_dep_for_handle( $handle ) {
	$wp_scripts = \wp_scripts();
	return $wp_scripts->registered[ $handle ];
}

/**
 * Get dependency locator.
 *
 * @since Hyperdrive 1.0.0
 * @param string $handle The handle.
 * @return Locator associated with handle, or empty string.
 */
function get_src_for_handle( $handle ) {
	$dep = get_dep_for_handle( $handle );
	$suffix = ( $dep->src && $dep->ver )
		? "?ver={$dep->ver}"
		: '';
	return "{$dep->src}{$suffix}";
}

/**
 * Get dependency handles.
 *
 * @since Hyperdrive 1.0.0
 * @param string $handle The handle.
 * @return An array of dependency handles.
 */
function get_deps_for_handle( $handle ) {
	$dep = get_dep_for_handle( $handle );
	return $dep->deps;
}
