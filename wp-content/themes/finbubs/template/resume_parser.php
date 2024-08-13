<?php
/**
 * Template Name: Resume Parser
 */

get_header();


    global $wpdb;
    $table_name = $wpdb->prefix . 'resume_parser';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        login_id int NOT NULL,
        name tinytext NOT NULL,
        email text NOT NULL,
        jd text NOT NULL,
        status varchar(255) NOT NULL,
        url text NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    add_option( 'jal_db_version', '1.0' );
?>

<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <form name="frm" action="#" method="post">
            <input type="hidden" name="action" value="process_resume_form">
            <tr>
                <td>Name:</td>
                <td><input type="text" name="nm" required></td>
            </tr>
            <!-- <tr>
                <td>Email:</td>
                <td><input type="email" name="em" required></td>
            </tr> -->
            <tr>
                <td>Job Description:</td>
                <td><input type="text" name="jd" required></td>
            </tr>
            <!-- tr>
                <td>Status:</td>
                <td><input type="text" name="sts" required></td>
            </tr> -->
            <!-- <tr>
                <td>URL:</td>
                <td><input type="url" name="url" required></td>
            </tr> -->
            <tr>
                <td></td>
                <td><input type="submit" value="Insert" name="ins"></td>
            </tr>
        </form>
    </tbody>
</table>

<?php
// Handle form submission

    global $wpdb;

    $nm = sanitize_text_field( $_POST['nm'] );
    $em = sanitize_email( $_POST['em'] );
    $jd = sanitize_text_field( $_POST['jd'] );
    $sts = sanitize_text_field( $_POST['sts'] );
    $url = esc_url_raw( $_POST['url'] );

    $table_name = $wpdb->prefix . 'resume_parser';
    $wpdb->insert(
        $table_name,
        array(
            'name' => $nm,
            'email' => $em,
            'jd' => $jd,
            'status' => $sts,
            'url' => $url,
        )
    );

    // Optionally, redirect after form submission
    // wp_redirect( add_query_arg( 'resume_inserted', 'true', wp_get_referer() ) );
    // exit;


get_footer();
?>
