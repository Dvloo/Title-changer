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

                <input type="submit" class="button button-primary" name="select_page" value="Get page data">
            </div>
        </form>
        <?php if(!empty($_SESSION['post_id'])) : ?>
        <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <?php
            echo "<select style='display: none;' name='page_id'> <option selected>" . $_SESSION['post_id'] . "</option> </select>";
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
                <input style="width: 50%;" class="button button-primary" type="submit" name="form_send" value="Submit">
            </div>
            <div></div>
            <div></div>


        </form>
        <?php endif; ?>

        <h1>Product changer</h1>
        <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <div class="grid firstgrid">
                <input type="hidden" name="action" value="select_product">
                <label for="selectpage">Select product you want to edit:</label>

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

                <input type="submit" class="button button-primary" name="select_product" value="Get product data">
            </div>
        </form>
<?php if(!empty($_SESSION['product_id'])) : ?>
        <!-- Main form for updating product -->
        <form class="formulier" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype='multipart/form-data'>
            <input type="hidden" name="action" value="update_product">
            <?php
            echo "<select style='display: none;' name='product'> <option selected>" . $_SESSION['product_id'] . "</option> </select>";
            ?>
            <div class="grid">
                <?php
                echo '<label for="title">Title: </label>';
                echo '<input type="text" name="title" value="' . $_SESSION['product_title'] . '" id="name">';
                ?>
            </div>
            <div class="grid">
                <?php
                echo '<label for="quantity">Quantity: </label>';
                echo '<input type="text" name="quantity" value="' . $_SESSION['product_quantity'] . '" id="name">';
                ?>
            </div>
            <div class="grid">
                <?php
                echo '<label for="price">Price: </label>';
                echo '<input type="text" name="price" value="' . $_SESSION['product_price'] . '" id="name">';
                ?>
            </div>
            <div class="grid">
                <label for="image">Image: </label>
                <input type="file" name="image" alt="image" width="48" height="48">

            </div>
            <div class="grid firstgrid">
                <input style="width: 50%;" class="button button-primary" type="submit" name="update_product" value="Submit">
                <span></span>
                <input style="width: 50%; float: right;" class="button button-primary bg-danger border-danger"  onclick="return confirm('Are you sure you want to delete this product?');" type="submit" name="delete_product" value="Delete">
            </div>
            <input type="hidden" name="action" value="update_product">
        </form>
        <?php endif;?>
    </div>
</div>