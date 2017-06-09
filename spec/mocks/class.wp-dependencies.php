<?php

/**
 * Core base class extended to register items.
 *
 * @package WordPress
 * @since 2.6.0
 * @uses _WP_Dependency
 */
class WP_Dependencies {
  /**
	 * An array of registered handle objects.
	 *
	 * @access public
	 * @since 2.6.8
	 * @var array
	 */
	public $registered = array();

  /**
	 * An array of queued _WP_Dependency handle objects.
	 *
	 * @access public
	 * @since 2.6.8
	 * @var array
	 */
	public $queue = array();
}
