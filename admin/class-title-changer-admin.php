<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://localhost/markethinqwp
 * @since      1.0.0
 *
 * @package    Title_Changer
 * @subpackage Title_Changer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Title_Changer
 * @subpackage Title_Changer/admin
 * @author     Damian <damian@markethinq.nl>
 */
class Title_Changer_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Title_Changer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Title_Changer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/title-changer-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Title_Changer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Title_Changer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/title-changer-admin.js', array('jquery'), time(), false);
	}


	function titleMenu()
	{
	}

	/* This function is just so he can put an id into a session so
*  The page knows what id he needs to load see  function */
	function select_page()
	{
		//Give sessions data with data from database from the page you want data from
		$post = get_post($_POST['selectpage']);
		$_SESSION['post_id'] = $post->ID;
		wp_safe_redirect(wp_get_referer());
	}

	/* This function will update a specific page. It will check if everything is filled in.
*  After that he will put it into the database. If not it will give an error.
*/
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
			} else {
				$_SESSION['errMes'] = "Name cannot be empty";
			}

			if (!empty($date)) {
				$time = date('Y-m-d H:i:s', strtotime($date));
				$timepost = wp_update_post(
					array(
						'ID'            => $page_id,
						'post_date'     => $time,
						'post_date_gmt' => get_gmt_from_date($time),
					)
				);

				// Update the post into the database
				wp_update_post($timepost);
			} else {
				$_SESSION['errMes'] = "Date cannot be empty";
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


		if (empty($page_id)) {
			$_SESSION['errMes'] = "No page selected";
		}

		wp_safe_redirect(wp_get_referer());
	}



	/* This function is just so he can put an id into a session so
*  The page knows what id he needs to load see Get_Product_Data function */
	function select_product()
	{
		$product = wc_get_product($_POST['product']);
		$_SESSION['product_id'] = $product->get_id();
		get_product_data($_POST['product']);
		wp_safe_redirect(wp_get_referer());
	}



	/* This function will update the product you have selected.
*  He will check if every field has been filled in and will store the new data */

	function update_product()
	{
		$product_id = $_POST['product'];
		if (isset($_POST['update_product'])) {
			$quantity = $_POST['quantity'];
			$title = $_POST['title'];
			$price = $_POST['price'];
			$image_url = $_FILES['image'];
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

			if ($image_url['error'] == 0) {
				move_uploaded_file($image_url['tmp_name'], __DIR__ . '/../../uploads/' . $_FILES["image"]['name']);
				Generate_Featured_Image(__DIR__ . '/../../uploads/' . $_FILES["image"]['name'], $product_id);
				unlink(__DIR__ . '/../../uploads/' . $_FILES["image"]['name']);
			}

			if (empty($_SESSION['errMes'])) {
				$_SESSION['success'] = "Product updated";
			}
		} else {
			wp_delete_post($product_id);
			session_destroy();
			$_SESSION['success'] = "Product has been deleted";
		}
		wp_safe_redirect(wp_get_referer());
	}

	/* This function will update the image from a specific product.  */
	function Generate_Featured_Image($image_url, $post_id)
	{
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image_url);
		$filename = basename($image_url);
		if (wp_mkdir_p($upload_dir['path']))
			$file = $upload_dir['path'] . '/' . $filename;
		else
			$file = $upload_dir['basedir'] . '/' . $filename;
		file_put_contents($file, $image_data);

		$wp_filetype = wp_check_filetype($filename, null);

		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name($filename),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment($attachment, $file, $post_id);
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
		$res1 = wp_update_attachment_metadata($attach_id, $attach_data);
		$res2 = set_post_thumbnail($post_id, $attach_id);
	}
}
