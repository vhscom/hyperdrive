<?php
/**
 * Dependencies API: _WP_Dependency class
 *
 * @since 4.7.0
 *
 * @package WordPress
 * @subpackage Dependencies
 */

/**
 * Class _WP_Dependency
 *
 * Helper class to register a handle and associated data.
 *
 * @access private
 * @since 2.6.0
 */
class _WP_Dependency {
	/**
	 * The handle name.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var null
	 */
	public $handle;

	/**
	 * The handle source.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var null
	 */
	public $src;

	/**
	 * An array of handle dependencies.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var array
	 */
	public $deps = array();

	/**
	 * The handle version.
	 *
	 * Used for cache-busting.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var bool|string
	 */
	public $ver = false;
}
