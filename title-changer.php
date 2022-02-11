
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
        $_SESSION['post_name'] = null;
        $_SESSION['post_status'] = null;
        $_SESSION['post_password'] = null;
        $_SESSION['post_date'] = null;
        $_SESSION['post_id'] = null;
        $_SESSION['post_selected'] = null;
        //Reset for products sessions   
        $_SESSION['product_id'] = null;
        $_SESSION['product_title'] = null;
        $_SESSION['product_quantity'] = null;
        $_SESSION['product_price'] =  null;
    }
    if (empty($_SESSION['errMes'])) {
        $_SESSION['errMes'] = null;
    }
    if (empty($_SESSION['success'])) {
        $_SESSION['success'] = null;
    }

    require_once('admin/partials/title-changer-admin-display.php');
}
function titleMenu()
{
    echo "<DIV><h2>Very good very nice</h2><br><h1>HEYA SEXY BANANA</h1></DIV>";
}

add_action('admin_post_select_page', 'select_page');
function select_page()
{
    //Give sessions data with data from database from the page you want data from
    $post = get_post($_POST['selectpage']);
    $_SESSION['post_selected'] = $_POST['selectpage'];
    $_SESSION['post_name'] = $post->post_title;
    $_SESSION['post_status'] = $post->post_status;
    $_SESSION['post_id'] = $post->ID;
    $_SESSION['post_password'] = $post->post_password;
    $_SESSION['post_date'] = $post->post_date;
    $_SESSION['selected'] = true;
    wp_safe_redirect(wp_get_referer());
}

add_action('admin_post_form_send', 'form_send');
function form_send()
{
    $name = $_POST['name'];
    $date = $_POST['date'];
    $page_id = $_POST['page_id'];
    $post_content = $_POST['title_changer'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    //Destroys session after variables have data
    session_destroy();

    //Check if post is not empty
    if (!empty($name) && (!empty($date))) {
        if (!empty($name)) {
            $my_post = array(
                'ID'           => $page_id,
                'post_title'   => $name,
                'post_content' => $post_content,
            );
            // Update the post into the database
            wp_update_post($my_post);
        }

        if (!empty($date)) {
            $time = date('Y-m-d H:i:s', strtotime($date));

            $timepost = wp_update_post(
                array(
                    'ID'            => $page_id,
                    'post_date'     => $time,
                    'post_date_gmt' => get_gmt_from_date($time)
                )
            );

            // Update the post into the database
            wp_update_post($timepost);
        }


        //Update for password
        $my_post = array(
            'ID'           => $page_id,
            'post_password' => $password,
        );
        // Update the post into the database
        wp_update_post($my_post);

        //Update for status
        $my_post = array(
            'ID'           => $page_id,
            'post_status'   => $status,
        );

        // Update the post into the database
        wp_update_post($my_post);
        $_SESSION['success'] = "Post updated";
    }



    if (empty($date)) {
        $_SESSION['errMes'] = "Date cannot be empty";
    }
    if (empty($page_id)) {
        $_SESSION['errMes'] = "No page selected";
    }
    if (empty($name)) {
        $_SESSION['errMes'] = "Name cannot be empty";
    }
    wp_safe_redirect(wp_get_referer());
}




add_action('admin_post_select_product', 'select_product');
function select_product()
{
    $product = wc_get_product($_POST['product']);

    $_SESSION['product_id'] = $product->get_id();
    $_SESSION['product_title'] = $product->get_name();
    $_SESSION['product_quantity'] = $product->get_stock_quantity();
    $_SESSION['product_price'] = $product->get_price();
    wp_safe_redirect(wp_get_referer());
}


add_action('admin_post_update_product', 'update_product');
function update_product()
{
    $product_id = $_POST['product'];
    if (isset($_POST['update_product'])) {
        $quantity = $_POST['quantity'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $image_url = $_POST['image'];

        //Destroys session when variables have data
        session_destroy();

        if (!empty($quantity)) {
            // Update the post into the database
            update_post_meta($product_id, '_stock', $quantity);

            if ($quantity == 0) {
                update_post_meta($product_id, '_stock_status', wc_clean('outofstock'));
            } else {
                update_post_meta($product_id, '_stock_status', wc_clean('instock'));
            }
        } else {
            $_SESSION['errMes'] = "Quantity cannot be empty";
        }
        if (!empty($title)) {
            wp_update_post(array('ID' => $product_id, 'post_title' => $title));
        } else {
            $_SESSION['errMes'] = "Title cannot be empty";
        }
        if (!empty($price)) {
            // Update the post into the database
            update_post_meta($product_id, '_regular_price', $price);
            update_post_meta($product_id, '_price', $price);
        } else {
            $_SESSION['errMes'] = "Price cannot be empty";
        }
        if (!empty($image_url)) {
            update_post_meta($product_id, '_product_image_gallery', implode(',', $image_url));
            if (empty($_SESSION['errMes'])) {
                $_SESSION['success'] = "Product updated";
            }
        }
        wp_safe_redirect(wp_get_referer());
    }
    else {
        wp_delete_post($product_id);
        session_destroy();
        $_SESSION['success'] = "Product has been deleted";
    }
}
?>