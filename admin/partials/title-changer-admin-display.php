<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://localhost/markethinqwp
 * @since      1.0.0
 *
 * @package    Title_Changer
 * @subpackage Title_Changer/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://localhost/markethinqwp
 * @since      1.0.0
 *
 * @package    Title_Changer
 * @subpackage Title_Changer/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="forms">
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="title_changer">
        <label for="name">Name: </label> <input type="text" name="name" id="name">
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

    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="page_status">
        <label for="status">Status: </label>
        <select name="status">
            <?php
            foreach (get_post_stati(array('show_in_admin_status_list' => true), 'objects') as $status) {
                echo "<option>" . $status->name . "</option>";
            }
            ?>
        </select>

        <?php
        wp_dropdown_pages(array(
            'child_of'     => 0,
            'sort_order'   => 'ASC',
            'sort_column'  => 'post_title',
            'hierarchical' => 1,
            'post_type' => 'page'
        ));
        ?>
        <input type="submit" name="page_status" value="Submit">
    </form>

    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="date_changer">
        <label for="date">Date: </label>
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

    
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="password_changer">
        <label for="name">Password: </label> <input type="text" name="password" id="name">
        <?php
        wp_dropdown_pages(array(
            'child_of'     => 0,
            'sort_order'   => 'ASC',
            'sort_column'  => 'post_title',
            'hierarchical' => 1,
            'post_type' => 'page'
        ));
        ?>
        <input type="submit" name="password_changer" value="Submit">
    </form>
</div>
