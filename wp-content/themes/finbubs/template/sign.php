<?php
/**
 *  Template name: Sign


 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finbubs
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="userRegistration textCenter">
	<!--message wrapper-->
	<div id="message" class="alert-box"></div>

	<form method="post" id="rsUserRegistration" action="">
		<?php
			wp_nonce_field( 'rs_user_registration_action', 'rs_user_registration_nonce' );
		?>
		<div class="form-group">
      <label>UserName</label>
      <input type="text" name="vb_user" id="vb_username" value="" placeholder="Choose Username" class="form-control" />
      <span class="help-block">
    </div>
 
    <div class="form-group">
      <label>Choose Password</label>
      <input type="password" name="vb_pass" id="vb_pass" value="" placeholder="Choose Password" class="form-control" />
      
    </div>

    <input type="button" class="btn btn-primary" id="bt-new-user" value="Register" />
	</form>
</div>
<!-- <form method="post" action="">

	<label for="newPassword">New Password:</label>
	<input type="password" id="newPassword" name="newPassword" title="New password" />

	<label for="confirmPassword">Confirm Password:</label>
	<input type="password" id="confirmPassword" name="confirmPassword" title="Confirm new password" />

	<p class="form-actions">
	<input type="submit" value="Change Password" title="Change password" />
	</p>
</form> -->
	<?php
	// while ( have_posts() ) :
	// 	the_post();

	// 	get_template_part( 'template-parts/content', get_post_type() );
		
	// endwhile; // End of the loop.

	?>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
