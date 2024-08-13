<script type="text/javascript">!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});</script>
<script type="text/javascript">
    window.Beacon('init', 'fec2334c-6f13-431a-a6d3-e92728122b1b');

<?php
$current_user = wp_get_current_user();
if ( $current_user->exists() ) :
?>
    window.Beacon("prefill", {
        name: "<?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname; ?>",
        email: "<?php echo $current_user->user_email; ?>"
    });
<?php endif; ?>
</script>