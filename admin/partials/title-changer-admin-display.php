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

    <!-- Form for first select page -->
    <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="select_page">
        <label for="selectpage">Select page you want to edit:</label>
        <?php
        wp_dropdown_pages(array(
            'name' => 'selectpage',
            'child_of'     => 0,
            'sort_order'   => 'ASC',
            'sort_column'  => 'post_title',
            'hierarchical' => 1,
            'post_type' => 'page',
            'post_status' => get_post_stati(),
        ));
        ?>
        <input type="submit" name="select_page" value="Get page data">
    </form>
    <?php if ($_SESSION['errMes'] != null) {
        echo "<div class='text-white bg-danger h-25 w-50 mb-5 p-3 text-center'>

        <h2 class='text-white'>" . $_SESSION['errMes'] . "</h2>

    </div>";
    }
    $_SESSION['errMes'] = null; ?>
    <?php if ($_SESSION['success'] != null) {
        echo "<div class='text-white bg-success h-25 w-50 mb-5 p-3 text-center'>

        <h2 class='text-white'>" . $_SESSION['success'] . "</h2>

    </div>";
    }
    $_SESSION['success'] = null; ?>
        <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="title_changer">
            <?php
            echo '<label for="name">Name: </label>';
            echo '<input type="text" name="name" value="'. $_SESSION['post_name'] .'" id="name">';

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
            <div style="d-flex flex-column">
                <label for="status">Status: </label>
                <?php
                $posts = get_posts(
                    array(
                        'numberposts' => -1,
                        'post_status' =>  get_post_stati(),
                        'post_type' => 'page',
                    )
                );;
                ?>
            </div>
            <select name="status">
                <?php
                $currentstatus = array();
                foreach ($posts as $post) {
                    if (!in_array($post->post_status, $currentstatus)) {
                        echo "<option>" . $post->post_status . "</option>";
                        array_push($currentstatus, $post->post_status);
                    }
                }
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
            <?php
            $date = date('Y-m-d\TH:i', strtotime($_SESSION['post_date']));
            echo '<input type="datetime-local" name="date" value="'.$date.'">';
          
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
            <?php
            echo '<label for="name">Password: </label> <input type="text" name="password"  value="'.$_SESSION['post_password'].'" id="name">';
            
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