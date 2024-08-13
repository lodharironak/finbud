<?php
/**
 *  Template name: Personal Details


 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finbubs
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php 
    global $current_user;
    wp_get_current_user();
    if ($current_user->ID == 0) { 
        echo "<p>Please log in to view this content.</p>";
    } else {
        echo "<h2>Welcome, " . $current_user->user_login . "</h2>"; 
        echo "<h4>Email :" .$current_user->user_email. "</h4>";
    }
    ?>   
    <div class="wrap">
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Job Desc</th>
                <th>Status</th>
                <th>URL</th>
            </tr>
            </thead>
            <tbody>
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'resume_parser';
            $employees = $wpdb->get_results("SELECT name,jd,status,url from $table_name");
            foreach ($employees as $employee) {
                ?>
                <tr>
                    <td><?= $employee->name; ?></td>
                    <td><?= $employee->jd; ?></td>
                    <td><?= $employee->status; ?></td>
                    <td><?= $employee->url; ?></td>
                </tr>
            <?php } ?>
            </tbody>
         </table>
    </div>
</main><!-- #main -->

<?php get_footer(); ?>
