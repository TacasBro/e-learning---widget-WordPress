<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       kusy.urz.pl
 * @since      1.0.0
 *
 * @package    E_Learning
 * @subpackage E_Learning/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

   <?php
   include_once('materialy/add_ematerialy.php');
   ?>

</div></div>


