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
 * Version:         1.0.0-beta.4
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
 *
 * This file incorporates work covered by the following copyright and
 * permission notice:
 *
 *     Copyright (c) 2017, VHS <josh@vhs.codeberg.page>
 *
 *     Permission to use, copy, modify, and/or distribute this software for any
 *     purpose with or without fee is hereby granted, provided that the above
 *     copyright notice and this permission notice appear in all copies.
 *
 *     THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 *     WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 *     MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 *     ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 *     WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 *     ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 *     OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */

namespace hyperdrive;

/**
 * Engages Hyperdrive.
 *
 * Engages Hyperdrive while printing scripts or data
 * in the head tag on the front end of WordPress. Exits otherwise.
 *
 * @since 1.0.0
 */
defined( 'ABSPATH' )
	? add_action( 'wp_head', __NAMESPACE__ . '\engage' )
	: die( 'Now you are going to die! BAM!' );

/**
 * Calibrates Hyperdrive thrusters.
 *
 * Creates an associative array containing structured data required
 * for Fetch Injection. Also dequeues enqueued scripts so WordPress
 * doesn't load them. Data structure is assumed by functions using
 * and used by this method.
 *
 * @since Hyperdrive 1.0.0
 * @return Associative array with destination coordinates.
 */
function calibrate_thrusters() {
	$coordinates = [];
	$scripts = get_enqueued_scripts();
	foreach ( $scripts as $script ) {
		if ( empty( $script->extra['conditional'] ) ) {
			// It's a good thing you were wearing that helmet.
			$coordinates[] = array(
				$script->handle,
				get_src_for_handle( $script->handle ),
				get_dependency_data( $script->deps ),
			);
			// Not in here, mister! This is a Mercedes!
			wp_dequeue_script( $script->handle );
		}
	}
	return $coordinates;
}

/**
 * Generates antiparticles.
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
		!empty( $locator ) && $antiparticles[] = "{$locator}";
		$dimensions && $antiparticles[] = generate_antimatter( $dimensions, true );
	}
	is_array(reset($antiparticles)) && $antiparticles = reset($antiparticles);
	array_multisort( $antiparticles );
	$antiparticles = array_map('unserialize', array_unique(
		array_map( 'serialize', $antiparticles )
	));
	return $antiparticles;
}

/**
 * Converts antiparticles into dark matter.
 *
 * Performs a moonwalk to dedupe any remaining multidimensional
 * dopplegangers in alternate dimensions and constructs a script
 * to handle page resource Fetch Injection.
 *
 * @since Hyperdrive 1.0.0
 * @param array $antiparticles Partical array.
 * @return A string containing a fully-assembled inline script.
 */
function fold_spacetime( $antiparticles ) {
	$injection = '';
	$injectors = [];

	array_moonwalk( $antiparticles, $injectors );
	$depths = array_count_values( $injectors );
	$locators = array_keys( $injectors );

	foreach ($depths as $depth => $quantity) {
		$injections = [];
		$remaining = $quantity;
		do {
			$injections[] = array_shift($locators);
			$remaining--;
		} while ($remaining > 0);
		$encoded = json_encode($injections, JSON_UNESCAPED_SLASHES);
		$injection .= "fetchInject($encoded";
		count( $injections ) === count( $depths  )
			? $injection .= array_reduce(
				$depths, function ($s) {return $s . ")"; }
			) : $injection .= ", ";
	}

	return <<<EOD
/*! Hyperdrive v1.0.0-beta.4 | (c) 2017 VHS | @license AGPL-3.0 or any later version */
/*! Fetch Inject v1.7.0 | (c) 2017 VHS | @license ISC */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):e.fetchInject=t()}(this,function(){"use strict";const e=function(e,t,n,o,r,i,c){i=t.createElement(n),c=t.getElementsByTagName(n)[0],i.appendChild(t.createTextNode(o.text)),i.onload=r(o),c?c.parentNode.insertBefore(i,c):t.head.appendChild(i)};return function(t,n){if(!t||!Array.isArray(t))return Promise.reject(new Error("`inputs` must be an array"));if(n&&!(n instanceof Promise))return Promise.reject(new Error("`promise` must be a promise"));const o=[],r=n?[].concat(n):[],i=[];return t.forEach(e=>r.push(window.fetch(e).then(e=>[e.clone().text(),e.blob()]).then(e=>Promise.all(e).then(e=>{o.push({text:e[0],blob:e[1]})})))),Promise.all(r).then(()=>{o.forEach(t=>{i.push({then:n=>{t.blob.type.includes("text/css")?e(window,document,"style",t,n):e(window,document,"script",t,n)}})});return Promise.all(i)})}});
$injection;
EOD;
}

/**
 * Enters hyperspace.
 *
 * @since Hyperdrive 1.0.0
 * @param string $dark_energy An inline script to asynchronously
 *     fetch previously enqueued page resources.
 */
function enter_hyperspace( $dark_energy ) {
	echo "<script>{$dark_energy}</script>";
}

/**
 * Main function engages the hyperdrive.
 *
 * @since Hyperdrive 1.0.0
 * @todo return void (requires PHP 7.1).
 */
function engage() {
	enter_hyperspace( // May the schwartz be with you!
		fold_spacetime( generate_antimatter( calibrate_thrusters() ) )
	);
}

/**
 * Gets dependency data recursively.
 *
 * @since Hyperdrive 1.0.0
 * @param array(string) $handles An array of handles.
 * @return array(array) Dependency data matching expected structure.
 */
function get_dependency_data( $handles ) {
	$dependency_data = [];
	foreach ( $handles as $idx => $handle ) {
		$source_url = get_src_for_handle( $handle );
		if ( $source_url ) {
			$dependency_data[] = array(
				$handle,
				$source_url,
				array(), // Maintain thrust.
			);
		}
		$deps = get_deps_for_handle( $handle );
		if ( count( $deps ) > 0 ) {
			$dependency_data[] = array(
				$handle,
				'', // Maintain thrust.
				get_dependency_data( $deps ),
			);
		}
	}
	return $dependency_data;
}

/**
 * Moonwalks an array.
 *
 * Deduplicates multidimensional array by flattening it while preserving
 * the deepest depth and flipping it inside out. Array values become the
 * keys and the new values contain the depths.
 *
 * @since Hyperdrive 1.0.0
 * @link https://gist.github.com/vhs/2c805d3c9f9abe584ba22c5b5e35b9a3
 * @param array $array A multidimensional array of variable depth.
 * @param array $accumulator A reference identifier for a stored result.
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
 * Gets scripts registered and enqueued.
 *
 * @since Hyperdrive 1.0.0
 * @return array(_WP_Dependency) A list of enqueued dependencies.
 */
function get_enqueued_scripts() {
	$wp_scripts = wp_scripts();
	foreach ( $wp_scripts->queue as $handle ) {
		$enqueued_scripts[] = $wp_scripts->registered[ $handle ];
	}
	return $enqueued_scripts;
}

/**
 * Gets a script dependency for a handle.
 *
 * @since Hyperdrive 1.0.0
 * @param string $handle The handle.
 * @return _WP_Dependency associated with input handle.
 */
function get_dep_for_handle( $handle ) {
	$wp_scripts = wp_scripts();
	return $wp_scripts->registered[ $handle ];
}

/**
 * Gets the source URL given a script handle.
 *
 * @since Hyperdrive 1.0.0
 * @param string $handle The handle.
 * @return URL associated with handle, or empty string.
 */
function get_src_for_handle( $handle ) {
	$dep = get_dep_for_handle( $handle );
	$suffix = ( $dep->src && $dep->ver )
	? "?ver={$dep->ver}"
	: '';
	return "{$dep->src}{$suffix}";
}

/**
 * Gets all dependencies for a given handle.
 *
 * @since Hyperdrive 1.0.0
 * @param string $handle The handle.
 * @return array(string) List of handles for dependencies of `$handle`.
 */
function get_deps_for_handle( $handle ) {
	$dep = get_dep_for_handle( $handle );
	return $dep->deps;
}
