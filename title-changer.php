<?php

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
    add_menu_page("Title-Changer Options", "Title-Changer Options", 4, "title-changer-options", "titleMenu");
}

function titleMenu()
{
    echo "Hello World!";
}
?>

<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <input type="hidden" name="action" value="title_changer">
    <label for="name">Name:</label> <input type="text" name="name" id="name">
    <?php
    wp_dropdown_pages(array(
        'child_of'     => 0,
        'sort_order'   => 'ASC',
        'sort_column'  => 'post_title',
        'hierarchical' => 1,
        'post_type' => 'page'
    ));
    ?>
    <input type="submit" name="title_changer" value="Submit">
</form>

<?php

add_action('admin_post_title_changer', 'title_changer');
function title_changer()
{
    print_r($_POST);

    $my_post = array(
        'ID'           => $_POST['page_id'],
        'post_title'   => $_POST['name'],
        'post_content' => $_POST['title_changer'],

    );

    // Update the post into the database
    wp_update_post($my_post);
}

?>

<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <input type="hidden" name="action" value="page_status">
    <select name="status">
        <?php

        
foreach (get_post_stati(array('show_in_admin_status_list' => true), 'objects') as $status) {
            echo "<option>" . $status->name . "</option>";
    <input type="datetime-local" name="date">
    <?php
    wp_dropdown_pages(array(
        'child_of'     => 0,
        'sort_order'   => 'ASC',
        'sort_column'  => 'post_title',
        'hierarchical' => 1,
        'post_type' => 'page'
    ));
    ?>
    <input type="submit" name="date_changer" value="Submit">
</form>

<?php

add_action('admin_post_date_changer', 'date_changer');
function date_changer()
{
    print_r($_POST);

    $time = date('Y-m-d H:i:s', strtotime($_POST['date']));
  
    $timepost = wp_update_post(
        array(
            'ID'            => $_POST['page_id'],
            'post_date'     => $time,
            'post_date_gmt' => get_gmt_from_date($time)
        )
    );

    // Update the post into the database
    wp_update_post($timepost);
}

?>