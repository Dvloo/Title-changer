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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="forms-title-changer">
    <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="title_changer">
        <label for="name">Name:</label> <input type="text" name="name" id="name">
        <?php
        wp_dropdown_pages(array(
            'child_of'     => 0,
            'sort_order'   => 'ASC',
            'sort_column'  => 'post_title',
            'hierarchical' => 1,
            'post_type' => 'page',
            'post_status' => get_post_stati(),
        ));
        ?>
        <input type="submit" name="title_changer" value="Submit">
    </form>

    <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="page_status">
        <label for="status">Status: </label>
        <?php
        $posts = get_posts(
            array(
             'numberposts' => -1,
             'post_status' =>  get_post_stati(),
             'post_type' => 'page',
            )
        );;
        foreach($posts as $status){
            echo "<label id='statuslabel $status->ID' for='status'>". $status->post_status ."</label>";
        }
        ?>
        <select name="status">
            <?php
            $currentstatus = array();
            foreach($posts as $post) {
                if(!in_array($post->post_status, $currentstatus)){
                    echo "<option>".$post->post_status."</option>";
                    array_push($currentstatus, $post->post_status);
                }

            }
            /*foreach (get_post_stati(array('show_status_list' => true), 'objects') as $status) {
                echo "<option>" . $status->name . "</option>";
            }*/
            ?>
        </select>

        <?php
        wp_dropdown_pages(array(
            'class' => 'status_dropdown',
            'id' => 'status_dropdown',
            'child_of'     => 0,
            'sort_order'   => 'ASC',
            'sort_column'  => 'post_title',
            'hierarchical' => 1,
            'post_type' => 'page',
            'post_status' =>  get_post_stati(),

        ));
        ?>
        <input type="submit" name="page_status" value="Submit">
    </form>

    <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="date_changer">
        <label for="date">Date: </label>
        <input type="datetime-local" name="date">
        <?php
        wp_dropdown_pages(array(
            'child_of'     => 0,
            'sort_order'   => 'ASC',
            'sort_column'  => 'post_title',
            'hierarchical' => 1,
            'post_type' => 'page',
            'post_status' =>  get_post_stati(),
        ));
        ?>
        <input type="submit" name="date_changer" value="Submit">
    </form>


    <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="password_changer">
        <label for="name">Password: </label> <input type="text" name="password" id="name">
        <?php
        wp_dropdown_pages(array(
            'child_of'     => 0,
            'sort_order'   => 'ASC',
            'sort_column'  => 'post_title',
            'hierarchical' => 1,
            'post_type' => 'page',
            'post_status' =>  get_post_stati(),

        ));
        ?>
        <input type="submit" name="password_changer" value="Submit">
    </form>