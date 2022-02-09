<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
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
<div class="forms-title-changer">
    <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="title_changer">
        <label for="name">Name:</label> <input class="input-form" type="text" name="name" id="name">
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

    <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="page_status">
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

    <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="date_changer">
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

    
    <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="password_changer">
        <label for="name">password:</label> <input type="text" name="password" id="name">
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
