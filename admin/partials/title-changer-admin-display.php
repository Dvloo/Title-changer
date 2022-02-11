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


<div class="body">
    <div class="forms-title-changer">
        <h1>Post changer</h1>
        <!-- Form for first select page -->
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
            <div class="grid firstgrid">
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
            </div>
        </form>

        <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <?php
            echo "<select style='display: none;' name='page_id'> <option selected>" . $_SESSION['post_id'] . "</optiom> </select>";
            ?>
            <div class="grid">
                <input type="hidden" name="action" value="form_send">
                <?php
                echo '<label for="name">Name: </label>';
                echo '<input type="text" name="name" value="' . $_SESSION['post_name'] . '" id="name">';
                ?>
            </div>
            <div class="grid">
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
                    foreach (get_post_statuses() as $post) {
                        if ($_SESSION['post_status'] == $post) {
                            echo "<option selected>" . $post . "</option>";
                        } else {
                            echo "<option>" . $post . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="grid">
                <label for="date">Date: </label>
                <?php
                $date = date('Y-m-d\TH:i', strtotime($_SESSION['post_date']));
                echo '<input type="datetime-local" name="date" value="' . $date . '">';


                ?>
            </div>
            <div class="grid">
                <?php
                echo '<label for="name">Password: </label> <input type="text" name="password"  value="' . $_SESSION['post_password'] . '" id="name">';

                ?>
                <input style="width: 50%;" type="submit" name="form_send" value="Submit">
            </div>
            <div></div>
            <div></div>


        </form>

        <h1>Product changer</h1>
        <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <div class="grid firstgrid">
                <input type="hidden" name="action" value="select_page">
                <label for="selectpage">Select page you want to edit:</label>

                <select name="product">
                    <?php
                    $args = array(
                        'post_type'      => 'product',
                    );

                    $loop = new WP_Query($args);

                    while ($loop->have_posts()) : $loop->the_post();
                        global $product;
                        echo '<option value="' . $product->get_id() . '">' . get_the_title() . '</option>';
                    endwhile;

                    wp_reset_query();
                    ?>
                </select>

                <input type="submit" name="select_page" value="Get page data">
            </div>
        </form>
        <form class="product_changer" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">

            <input type="hidden" name="action" value="change_quantity">
            <div class="grid firstgrid">
                <label for="product">Products: </label>
                <select name="product">
                    <?php
                    $args = array(
                        'post_type'      => 'product',
                    );

                    $loop = new WP_Query($args);

                    while ($loop->have_posts()) : $loop->the_post();
                        global $product;
                        echo '<option value="' . $product->get_id() . '">' . get_the_title() . '</option>';
                    endwhile;

                    wp_reset_query();
                    ?>
                </select>
                <input type="text" name="quantity" placeholder="quantity">
                <input style="width: 50%;" type="submit" name="change_quantity" value="Submit">
            </div>
            <div class="grid firstgrid">



            </div>
        </form>
    </div>
</div>