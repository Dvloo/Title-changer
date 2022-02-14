
<?php
session_start();
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://localhost/markethinqwp
 * @since             1.0.0
 * @package           Title_Changer
 *
 * @wordpress-plugin
 * Plugin Name:       Title changer
 * Plugin URI:        http://localhost/markethinqwp
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Damian
 * Author URI:        http://localhost/markethinqwp
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       title-changer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('TITLE_CHANGER_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-title-changer-activator.php
 */
function activate_title_changer()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-title-changer-activator.php';
    Title_Changer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-title-changer-deactivator.php
 */
function deactivate_title_changer()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-title-changer-deactivator.php';
    Title_Changer_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_title_changer');
register_deactivation_hook(__FILE__, 'deactivate_title_changer');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-title-changer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_title_changer()
{

    $plugin = new Title_Changer();
    $plugin->run();
}
run_title_changer();


add_action("admin_menu", "addMenu");
function addMenu()
{
    add_menu_page("Title-Changer Options", "Title-Changer Options", "manage_options", "title-changer-options", "titleMenu");
    add_submenu_page("title-changer-options", "Post Changer", "Post Changer", "manage_options", "post_changer", "post_changer");
}

function post_changer()
{
    /* Kinda a weird way to make a session without it having data
    *  Otherwise errors might pop up saying there is no session
    */

    if (empty($_SESSION)) {
        //Reset id
        $_SESSION['post_id'] = null;
        $_SESSION['product_id'] = null;
    }
    if (empty($_SESSION['errMes'])) {
        $_SESSION['errMes'] = null;
    }
    if (empty($_SESSION['success'])) {
        $_SESSION['success'] = null;
    }

    require_once('admin/partials/title-changer-admin-display.php');
}

/* This will get the data from a specific page.
*  You need the select_page function because in this function $_POST will not work  */
function get_page_data($id)
{
    $post = get_post($id);
    return $post;
}

/* Gets the product data from woocommerce. 
*  This functions returns the product data that will be load into the page 
*  Because $_POST does not work in here you need the function select_product();
*/
function get_product_data($id)
{
    $products = wc_get_product($id);
    return $products;
}
?>