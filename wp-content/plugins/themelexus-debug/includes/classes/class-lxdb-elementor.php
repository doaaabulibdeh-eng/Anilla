<?php

// Exit if accessed directly.

if (! defined('ABSPATH')) exit;
if (!lxdb_is_elementor_activated()) return;

/**
 * Class LXDB_Elementor
 *
 * Thats where we bring the plugin to life
 *
 * @package		LXDB
 * @subpackage	Classes/LXDB_Elementor
 * @author		WPOPAL
 * @since		1.0.0
 */
class LXDB_Elementor
{

	/**
	 * Our LXDB_Elementor constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct()
	{
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks()
	{

		// Fix Elementor 3.26.0
		if (version_compare(ELEMENTOR_VERSION, '3.26.0', '>=')) {
			add_action('wp_enqueue_scripts', array($this, 'elementor_fix_swiper_loader'), -1);
		}

		// Fix Elementor 3.28.0
		if (version_compare(ELEMENTOR_VERSION, '3.28.0', '>=')) {
			add_action('elementor/experiments/default-features-registered', array($this, 'elementor_fix_features_update'));
		}

		if (!defined('ELEMENTOR_PRO_VERSION')) {
			add_filter('script_loader_src', [$this, 'fix_motion_fx'], 10, 2);
		}
	}

	/**
	 * Enqueue the frontend related scripts and styles for this plugin.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function elementor_fix_swiper_loader()
	{
		wp_enqueue_style('e-swiper');
	}

	/**
	 * Fix elementor features update
	 *
	 * @access	public
	 * @since	1.1.9
	 *
	 * @return	void
	 */
	public function elementor_fix_features_update($feature_manager)
	{
		$feature_manager->add_feature([
			'name' => 'e_swiper_latest',
			'title' => esc_html__('Upgrade Swiper Library', 'elementor'),
			'description' => esc_html__('Prepare your website for future improvements to carousel features by upgrading the Swiper library integrated into your site from v5.36 to v8.45. This experiment includes markup changes so it might require updating custom code and cause compatibility issues with third party plugins.', 'elementor'),
			'release_status' => $feature_manager::RELEASE_STATUS_STABLE,
			'default' => $feature_manager::STATE_ACTIVE,
		]);
	}

	/**
	 * Fix JS Motion FX
	 *
	 * @access	public
	 * @since	1.2.7
	 *
	 * @return	void
	 */
	public function fix_motion_fx($src, $handle)
	{
		if (defined('LXDB_FIXED_OPTIMIZED_MARKUP') && LXDB_FIXED_OPTIMIZED_MARKUP) {
			return $src;
		}

		if (strpos($src, 'inc/elementor/motion-fx/assets/main.js') !== false) {
			if (\Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup')) {
				$src = LXDB_PLUGIN_URL . 'assets/js/motion-fx.js';
			}
		}
		return $src;
	}
}

new LXDB_Elementor();
