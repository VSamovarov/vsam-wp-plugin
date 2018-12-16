<?php
namespace VSamPlugin;
use VSamPlugin\Setup;
use VSamPlugin\Core\Core;
/**
 *
 * @link              victor@victor.com
 * @since             1.0.0
 * @package           Vsam_Currencies
 *
 * @wordpress-plugin
 * Plugin Name:       Название плагина
 * Description:       Описание плагина
 * Version:           1.0.0
 * Author:            Виктор
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vsam_plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define(__NAMESPACE__ . '\VERSION_MODULE','2.0.0');
define(__NAMESPACE__ . '\NAME_MODULE','vsam_plugin');

/**
 * The code that runs during plugin activation.
 */
function activate_module() {
	require_once plugin_dir_path( __FILE__ ) . 'setup/activator.php';
	Setup\ActivatorModule::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_module() {
	require_once plugin_dir_path( __FILE__ ) . 'setup/deactivator.php';
	Setup\DeactivatorModule::deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\activate' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'core/core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 */
function run_module() {
	$plugin = new Core();
	$plugin->run();
}
run_module();
