<?php
 
 // default codes for our plugins
if (!class_exists('Codeixer_Plugin_Core')) {
    class Codeixer_Plugin_Core
    {
        public function __construct()
        {
            add_action('admin_enqueue_scripts', array( $this, 'codeixer_admin_scripts' ));
            add_action('admin_menu', array( $this, 'codeixer_admin_menu' ));
            add_action('admin_menu', array( $this, 'later' ), 99);
        }

        public function codeixer_admin_scripts()
        {
            wp_enqueue_style('ci-admin', CIPG_ASSETS .'/css/ci-admin.css');
        }
        public function later()
        {
            /* === Remove Codeixer Sub-Links === */
            remove_submenu_page('codeixer', 'codeixer');
        }

        public function codeixer_admin_menu()
        {
            add_menu_page('Codeixer', 'Codeixer', 'manage_options', 'codeixer', null, 'dashicons-codeixer', 60);
            // * == License Activation Page ==
            if (apply_filters('has_codeixer_pro', false)) {
                add_submenu_page('codeixer', 'Dashboard', 'Dashboard', 'manage_options', 'codeixer-dashboard', array($this,'codeixer_license'));
            }
            do_action('codeixer_sub_menu');
        }

        public function codeixer_license() {?>
        <div class="wrap">

            <h2>Codeixer License Activation</h2>


        <!-- <p class="about-description">Enter your Purchase key here, to activate the product, and get full feature updates and premium support.</p> -->


        <?php
            do_action('codeixer_license_form');
            do_action('codeixer_license_data');

        }
    }
    new Codeixer_Plugin_Core();
}
