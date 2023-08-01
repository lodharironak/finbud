<?php  

/*

Template Name: CPT API

*/



get_header(); ?>
<?php
// Make the API request
$response = wp_remote_get('http://192.168.0.28/finbud/wp-json/wp/v2/service');
// $response = wp_remote_get('http://192.168.0.39/wordpress/wp-json/wp/v2/services');
if ($response !== false) {
    // Decode the JSON response
    $posts = json_decode(wp_remote_retrieve_body($response));
?>
<div class="services-section">
		<div class="container">
		    <div class="services-slider slider" data-sizes="50vw">
		    	<?php
				    // Use the retrieved data in your theme
				    foreach ($posts as $item) {
				    	$title = $item->title->rendered;
				    	$content = $item->excerpt->rendered;
		    	 ?>
		    	<div class="services-inner">
		            <div class="services-des">
		                <h5><?php echo $title; ?></h5>
		                <p><?php echo $content; ?></p>
		                <!-- <a href="<?php echo $servicepermalink; ?>" class="btn btn-transparent">Learn More <i class="fa fa-angle-double-right" aria-hidden="true"></i></a> -->
		            </div>
		        </div>
		        
		        <?php } ?>
		    </div>
		</div>
	</div>
	<?php
} else {
    // Handle error
    echo 'Failed to retrieve data from the API.';
}
?>
<?php get_footer(); ?>
