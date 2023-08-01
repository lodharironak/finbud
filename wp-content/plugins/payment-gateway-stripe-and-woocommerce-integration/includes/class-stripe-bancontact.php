<?php

if (!defined('ABSPATH')) {
    exit;
}  

/**
 * EH_Stripe_Bancontact_Pay class.
 *
 * @extends EH_Stripe_Payment
 */
class EH_Bancontact extends WC_Payment_Gateway {

    /**
     * Constructor
     */
    public function __construct() {
        
        $this->id                 = 'eh_bancontact_stripe';
        $this->method_title       = __( 'Bancontact', 'payment-gateway-stripe-and-woocommerce-integration' );

        $url = add_query_arg( 'wc-api', 'wt_stripe', trailingslashit( get_home_url() ) );
        $this->method_description = sprintf( __( 'Bancontact allow customer to use Bancontact card or mobile app linked to a Belgian bank account to make online payments. ' . '<a  class="thickbox" href="'.EH_STRIPE_MAIN_URL_PATH . 'assets/img/bancontact-preview.png?TB_iframe=true&width=100&height=100">[Preview] </a> ', 'payment-gateway-stripe-and-woocommerce-integration' ));
        $this->supports = array(
            'products',
            'refunds',
        );

        // Load the form fields.
        $this->init_form_fields();

        // Load the settings.
        $this->init_settings();
        
        $stripe_settings               = get_option( 'woocommerce_eh_stripe_pay_settings' );
        
        $this->title                   = __($this->get_option( 'eh_stripe_bancontact_title' ), 'payment-gateway-stripe-and-woocommerce-integration' );
        $this->description             = __($this->get_option( 'eh_stripe_bancontact_description' ), 'payment-gateway-stripe-and-woocommerce-integration' );
        $this->enabled                 = $this->get_option( 'enabled' );
        $this->eh_order_button         = $this->get_option( 'eh_stripe_bancontact_order_button');
        $this->order_button_text       = __($this->eh_order_button, 'payment-gateway-stripe-and-woocommerce-integration');

        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

        // Set stripe API key.
       
        \Stripe\Stripe::setApiKey(EH_Stripe_Payment::get_stripe_api_key());
        \Stripe\Stripe::setAppInfo( 'WordPress Stripe Payment Gateway for WooCommerce', EH_STRIPE_VERSION, 'https://www.webtoffee.com/product/woocommerce-stripe-payment-gateway/', 'pp_partner_KHip9dhhenLx0S' );

        // Hooks
        add_action('wp_enqueue_scripts', array($this, 'payment_scripts'));

        //add_filter( 'woocommerce_payment_successful_result', array( $this, 'modify_successful_payment_result' ), 99999, 2 );
       add_action( 'woocommerce_api_eh_bancontact', array( $this, 'eh_bancontact_callback_handler' ) );
    }



    /**
     * Initialize form fields in bancontact payment settings page.
     */
    public function init_form_fields() {

        $stripe_settings   = get_option( 'woocommerce_eh_stripe_pay_settings' );
        
        $this->form_fields = array(

            'eh_bancontact_desc' => array(
                'type' => 'title',
                'description' => sprintf(__('%sSupported currencies: %sEUR%sStripe accounts in the following countries can accept the payment: %sAustralia, Austria, Belgium, Bulgaria, Canada, Cyprus, Czech Republic, Denmark, Estonia, Finland, France, Germany, Greece, Hong Kong, Hungary, Ireland, Italy, Japan, Latvia, Lithuania, Luxembourg, Malta, Mexico, Netherlands, New Zealand, Norway, Poland, Portugal, Romania, Singapore, Slovakia, Slovenia, Spain, Sweden, Switzerland, United Kingdom, United States%s %sRead documentation%s', 'payment-gateway-stripe-and-woocommerce-integration'), '<div class="wt_info_div"><ul><li>', '<b>', '</b></li><li>', '<b>', '</b></li></ul></div>', '<p><a target="_blank" href="https://www.webtoffee.com/woocommerce-stripe-payment-gateway-plugin-user-guide/#bancontact">', '</a></p>'),
            ),
            'eh_stripe_bancontact_form_title'   => array(
                'type'        => 'title',
                'class'       => 'eh-css-class',
            ),
            'enabled'                       => array(
                'title'       => __('Bancontact Pay','payment-gateway-stripe-and-woocommerce-integration'),
                'label'       => __('Enable','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'checkbox',
                'default'     => isset($stripe_settings['eh_stripe_bancontact']) ? $stripe_settings['eh_stripe_bancontact'] : 'no',
                'desc_tip'    => __('Enables customers in the Single Euro Payments Area (Bancontact) to pay by providing their bank account details.','payment-gateway-stripe-and-woocommerce-integration'),
            ),
            'eh_stripe_bancontact_title'         => array(
                'title'       => __('Title','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'text',
                'description' =>  __('Input title for the payment gateway displayed at the checkout.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     =>isset($stripe_settings['eh_stripe_bancontact_title']) ? $stripe_settings['eh_stripe_bancontact_title'] : __('Bancontact Pay', 'payment-gateway-stripe-and-woocommerce-integration'),
                'desc_tip'    => true,
            ),
            'eh_stripe_bancontact_description'     => array(
                'title'       => __('Description','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'textarea',
                'css'         => 'width:25em',
                'description' => __('Input texts for the payment gateway displayed at the checkout.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     =>isset($stripe_settings['eh_stripe_bancontact_description']) ? $stripe_settings['eh_stripe_bancontact_description'] : __('Secure debit payment via Bancontact.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'desc_tip'    => true
            ),
            'eh_stripe_bancontact_change_lang'     => array(
                'title'       => __('Customize language','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'checkbox',
                'label' => __('Enable to view the bank site in the required language.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     =>isset($stripe_settings['eh_stripe_bancontact_change_lang']) ? $stripe_settings['eh_stripe_bancontact_change_lang'] : 'no',
                'desc_tip'    => false
            ),
            'eh_stripe_bancontact_language'     => array(
                'title'       => __('Preferred language','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'select',
                'description' => __('Select the required language for the bank site.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default' => 'en',
                'desc_tip' => true,
                'options' => array(
                    'en' => __('English', 'payment-gateway-stripe-and-woocommerce-integration'),
                    'de' => __('German', 'payment-gateway-stripe-and-woocommerce-integration'),
                    'fr' => __('French', 'payment-gateway-stripe-and-woocommerce-integration'),
                    'nl' => __('Dutch', 'payment-gateway-stripe-and-woocommerce-integration'),
                )                
            ),
            'eh_stripe_bancontact_order_button'    => array(
                'title'       => __('Order button text', 'payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'text',
                'description' => __('Input a text that will appear on the order button to place order at the checkout.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     => isset($stripe_settings['eh_stripe_bancontact_order_button']) ? $stripe_settings['eh_stripe_bancontact_order_button'] :__('Pay via Bancontact', 'payment-gateway-stripe-and-woocommerce-integration'),
                'desc_tip'    => true
            )
        );

        wc_enqueue_js("
           var eh_stripe_lang    = $( '#woocommerce_eh_bancontact_stripe_eh_stripe_bancontact_language').closest( 'tr' );

            $(eh_stripe_lang).hide();            
            if ( $( '#woocommerce_eh_bancontact_stripe_eh_stripe_bancontact_change_lang').is( ':checked' ) ) {
                $(eh_stripe_lang).show();   
            }
            else{
               $(eh_stripe_lang).hide();   
            }

            $( '#woocommerce_eh_bancontact_stripe_eh_stripe_bancontact_change_lang' ).change(function(){
                if ( $( this ).is( ':checked' ) ) {
                    $(eh_stripe_lang).show();  
                } else {
                    $(eh_stripe_lang).hide();  
                }
            }).change();
        "); 

    }
 
     
    public function get_icon() {
        $style = version_compare(WC()->version, '2.6', '>=') ? 'style="margin-left: 0.3em"' : '';
        $icon = '';
        
        $icon .= '<img src="' . WC_HTTPS::force_https_url(EH_STRIPE_MAIN_URL_PATH . 'assets/img/bancontact.svg') . '" alt="Bancontact" width="52" title="Bancontact" ' . $style . ' />';
        return apply_filters('woocommerce_gateway_icon', $icon, $this->id);
    }
   
    /**
     *Makes gateway available 
     */
    public function is_available() {

        $stripe_settings   = get_option( 'woocommerce_eh_stripe_pay_settings' );

        if (!empty($stripe_settings) && 'yes' === $this->enabled) {

            if (isset($stripe_settings['eh_stripe_mode']) && 'test' === $stripe_settings['eh_stripe_mode']) {
                if (!isset($stripe_settings['eh_stripe_test_publishable_key']) || !isset($stripe_settings['eh_stripe_test_secret_key']) || ! $stripe_settings['eh_stripe_test_publishable_key'] || ! $stripe_settings['eh_stripe_test_secret_key']) {
                    return false;
                }
            } else {
                if (!isset($stripe_settings['eh_stripe_live_secret_key']) || !isset($stripe_settings['eh_stripe_live_publishable_key']) || !$stripe_settings['eh_stripe_live_secret_key'] || !$stripe_settings['eh_stripe_live_publishable_key']) {
                    return false;
                }
            }

            return true;
        }
        return false; 
    }


    /**
     * Outputs scripts used for stripe payment.
     */
    public function payment_scripts() {

        if(!$this->is_available()){
            return false;
        }
                
        $stripe_settings   = get_option( 'woocommerce_eh_stripe_pay_settings' );
        if ( (is_checkout()  && !is_order_received_page())) {
            wp_register_script('stripe_v3_js', 'https://js.stripe.com/v3/');
        }
    }

    /**
     *override woocommerce payment form.
     */
    public function payment_fields() {
        $user = wp_get_current_user();
        if ($user->ID) {
            $user_email = get_user_meta($user->ID, 'billing_email', true);
            $user_email = $user_email ? $user_email : $user->user_email;
        } else {
            $user_email = '';
        }
        echo '<div class="status-box">';

        if ($this->description) {
            echo apply_filters('eh_bancontact_desc', wpautop(wp_kses_post("<span>" . $this->description . "</span>")));
        }
        echo "</div>";
        $pay_button_text = __('Pay', 'payment-gateway-stripe-and-woocommerce-integration');
        if (is_checkout_pay_page()) {
            $order_id = get_query_var('order-pay');
            $order = wc_get_order($order_id);
            $email = (WC()->version < '2.7.0') ? $order->billing_email : $order->get_billing_email();
            echo '<div
                id="eh-bancontact-pay-data"
                data-panel-label="' . esc_attr($pay_button_text) . '"
                data-email="' . esc_attr(($email !== '') ? $email : get_bloginfo('name', 'display')) . '"
                data-amount="' . esc_attr(EH_Stripe_Payment::get_stripe_amount(((WC()->version < '2.7.0') ? $order->order_total : $order->get_total()))) . '"
                data-name="' . esc_attr(sprintf(get_bloginfo('name', 'display'))) . '"
                data-currency="' . esc_attr(((WC()->version < '2.7.0') ? $order->order_currency : $order->get_currency())) . '">';

           echo $this->elements_form();
            echo '</div>';

        } else {
            echo '<div
                id="eh-bancontact-pay-data"
                data-panel-label="' . esc_attr($pay_button_text) . '"
                data-email="' . esc_attr($user_email) . '"
                data-amount="' . esc_attr(EH_Stripe_Payment::get_stripe_amount(WC()->cart->total)) . '"
                data-name="' . esc_attr(sprintf(get_bloginfo('name', 'display'))) . '"
                data-currency="' . esc_attr(strtolower(get_woocommerce_currency())) . '">';

           echo $this->elements_form();
           
           echo '</div>';
        }
    }


        /**
     *Renders stripe elements on payment form.
     */
    public function elements_form() {
        ?>
        <fieldset id="eh-<?php echo esc_attr( $this->id ); ?>-cc-form" class="eh-credit-card-form eh-payment-form" style="background:transparent;">

                <div class="clear"></div>

            <!-- Used to display form errors -->
            <div class="eh-bancontact-errors" role="alert" style="color:#ff0000"></div>
            <div class="clear"></div>
        </fieldset>
        <?php
    }

    public function create_source( $order ) {
        $currency              = $order->get_currency();
        $order_id = $order->get_id();
        $return_url            = add_query_arg('order_id', $order_id, WC()->api_request_url('EH_Bancontact'));
        $billing_first_name = $order->get_billing_first_name();
        $billing_last_name  = $order->get_billing_last_name();

        $details = [];

        $name  = $billing_first_name . ' ' . $billing_last_name;
        $email = $order->get_billing_email();
        $phone = $order->get_billing_phone();

        if ( ! empty( $phone ) ) {
            $details['phone'] = $phone;
        }

        if ( ! empty( $name ) ) {
            $details['name'] = $name;
        }

        if ( ! empty( $email ) ) {
            $details['email'] = $email;
        }

        $details['address']['line1']       = $order->get_billing_address_1();
        $details['address']['line2']       = $order->get_billing_address_2();
        $details['address']['state']       = $order->get_billing_state();
        $details['address']['city']        = $order->get_billing_city();
        $details['address']['postal_code'] = $order->get_billing_postcode();
        $details['address']['country']     = $order->get_billing_country();

        $post_data             = [];
        $post_data['amount']   = EH_Stripe_Payment::get_stripe_amount( $order->get_total(), $currency );
        $post_data['currency'] = strtolower( $currency );
        $post_data['type']     = 'bancontact';
        $post_data['owner']    = $details;
        $post_data['redirect'] = [ 'return_url' => $return_url ];
        $post_data['metadata'] = array('order_id' => $order_id);

        $eh_stripe = get_option("woocommerce_eh_bancontact_stripe_settings");

        if (isset($eh_stripe['eh_stripe_bancontact_change_lang']) && $eh_stripe['eh_stripe_bancontact_change_lang'] == 'yes') {
           $post_data['bancontact']['preferred_language'] = (isset($eh_stripe['eh_stripe_bancontact_language']) ? $eh_stripe['eh_stripe_bancontact_language'] : 'en' );
        }        

        /*if ( ! empty( $this->statement_descriptor ) ) {
            $post_data['statement_descriptor'] = WC_Stripe_Helper::clean_statement_descriptor( $this->statement_descriptor );
        }*/

        $response = \Stripe\Source::create($post_data);
        return $response;
    }


    /**
     *Process stripe payment.
     */
    public function process_payment($order_id) { 
        $order = wc_get_order( $order_id );//print_r($order);exit;
        $currency =  $order->get_currency();
        
        try{
            $obj_stripe = new EH_Stripe_Payment();

           $source_response =  $this->create_source($order);
            if ( ! empty( $response->error ) ) {
                throw new Exception( $response->error->message );
            }
            if (isset($source_response->id) && !empty($source_response->id)) {
                $source_id = sanitize_text_field($source_response->id);
                 $source_status = sanitize_text_field($source_response->status);


                if ( version_compare(WC_VERSION, '2.7.0', '<') ) {
                    update_post_meta( $order_id, '_eh_bancontact_source_id', $source_id );
                } else {
                    $order->update_meta_data( '_eh_bancontact_source_id', $source_id );
                }
                $order->save();

                //check the status of source
                if ($source_status == 'chargeable') {
                   $customer = $this->create_stripe_customer($source_id, $order_id, ((WC()->version < '2.7.0') ? $order->billing_email : $order->get_billing_email()));

                    if ($obj_stripe->is_subscription($order_id)) {
                        if (!$customer) {
                            throw new Exception(__("Could not process subscription order this time. Please try again.", 'payment-gateway-stripe-and-woocommerce-integration'));
                        }

                        //if is zero payment
                        if ( 0 >= $order->get_total() ) {
                            $user_id = $order->get_user_id();
                             update_post_meta($order_id, "_bancontact_customer_id", $customer->id);
                             return $obj_stripe->complete_free_order( $order,$setup_intent );
                        }

                    }
                 
                    
                    if (!empty($customer)) {
                        $user_id = $order->get_user_id();
                        update_user_meta($user_id, "_bancontact_customer_id", $customer->id);
                    }
                    

                    
                    // create charge
                    $charge_response = \Stripe\Charge::create($this->eh_make_charge_params( $order, $source_id,  $customer->id), array(
                                'idempotency_key' => $order->get_order_key()
                            ));

                   return $this->eh_process_payment_response($charge_response, $order, true);

                }
                elseif ($source_status == 'pending') { 
                    if (isset($source_response['redirect']['url']) && !empty($source_response['redirect']['url'])) { 
                        return array(
                            'result'        => 'success',
                            'redirect'      => $source_response['redirect']['url'],
                        );                     
                    }
                    else{
                        return array (
                            'result' => 'failure'
                        ); 
                    }
                }
                elseif ($source_status == 'failed') {
                    throw new Exception( __( 'Unable to process this payment.', 'payment-gateway-stripe-and-woocommerce-integration' ));
                    
                } 
            }
            else{

                throw new Exception( __( 'Unable to process this payment, please try again.', 'payment-gateway-stripe-and-woocommerce-integration' ));
            }

        }
        catch(Exception $e){
            $order->update_status( 'failed', sprintf( __( 'Bancontact payment failed: %s', 'payment-gateway-stripe-and-woocommerce-integration' ),$e->getMessage() ) );
            
           wc_add_notice( $e->getMessage(), 'error' );
            return array (
                'result' => 'failure'
            );
        }
        

    }


    /**    
     * gets required parameters for creating stripe charge.
     *
     */
    public function eh_make_charge_params( $order, $source_id,  $customer = null ) {
       
        $stripe_settings               = get_option( 'woocommerce_eh_stripe_pay_settings' );

        $post_data                       =  array();
        $currency                        =  $order->get_currency();
        $post_data['currency']           =  strtolower( $currency);
        $post_data['amount']             =  EH_Stripe_Payment::get_stripe_amount( $order->get_total(), $currency );
        $post_data['description']        =  sprintf( __( '%1$s - Order %2$s', 'payment-gateway-stripe-and-woocommerce-integration' ), wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $order->get_order_number() );
        $billing_email                   =  (WC()->version < '2.7.0') ? $order->billing_email      : $order->get_billing_email();
        $billing_first_name              =  (WC()->version < '2.7.0') ? $order->billing_first_name : $order->get_billing_first_name();
        $billing_last_name               =  (WC()->version < '2.7.0') ? $order->billing_last_name  : $order->get_billing_last_name();
        
        $post_data['shipping']['name']   =  $billing_first_name . ' ' . $billing_last_name;
        $post_data['shipping']['phone']  =  (WC()->version < '2.7.0') ? $order->billing_phone : $order->get_billing_phone();

        $post_data['shipping']['address']['line1']       = (WC()->version < '2.7.0') ? $order->shipping_address_1 : $order->get_shipping_address_1();
        $post_data['shipping']['address']['line2']       = (WC()->version < '2.7.0') ? $order->shipping_address_2 : $order->get_shipping_address_2();
        $post_data['shipping']['address']['state']       = (WC()->version < '2.7.0') ? $order->shipping_state     : $order->get_shipping_state();
        $post_data['shipping']['address']['city']        = (WC()->version < '2.7.0') ? $order->shipping_city      : $order->get_shipping_city();
        $post_data['shipping']['address']['postal_code'] = (WC()->version < '2.7.0') ? $order->shipping_postcode  : $order->get_shipping_postcode();
        $post_data['shipping']['address']['country']     = (WC()->version < '2.7.0') ? $order->shipping_country   : $order->get_shipping_country();
        
        $post_data['metadata']  = array(
            __( 'customer_name', 'payment-gateway-stripe-and-woocommerce-integration' ) => sanitize_text_field( $billing_first_name ) . ' ' . sanitize_text_field( $billing_last_name ),
            __( 'customer_email', 'payment-gateway-stripe-and-woocommerce-integration' ) => sanitize_email( $billing_email ),
            'order_id' => $order->get_order_number(),
        );
        
        if ( $source_id ) {
            $post_data['source'] = $source_id;
        }
       if ( $customer ) {
            $post_data['customer'] = $customer;
        } 
        return apply_filters( 'eh_bancontact_generate_charge_request', $post_data, $order, $source_id );
    }

    /**
     * Store extra meta data for an order and adds order notes for orders.
     */
    public function eh_process_payment_response( $response, $order, $auto_redirect = true ) {
        
        //$order_id = $order->get_order_number();
        $order_id = (WC()->version < '2.7.0') ? $order->id : $order->get_id();

        // Stores charge data.
        $obj1 = new EH_Stripe_Payment();
        $charge_param = $obj1->make_charge_params($response, $order_id);
        add_post_meta($order_id, '_eh_stripe_payment_charge', $charge_param);
        
        $order_id  = version_compare(WC_VERSION, '2.7.0', '<') ? $order->id : $order->get_id();
        $captured = ( isset( $response->captured ) && $response->captured == true) ? 'Captured' : 'Uncaptured';
        
        // Stores charge capture data.
        if ( version_compare(WC_VERSION, '2.7.0', '<') ) {
            update_post_meta( $order_id, '_eh_bancontact_charge_captured', $captured );
        } else {
            $order->update_meta_data( '_eh_bancontact_charge_captured', $captured );
        }
        
        $order_time = date('Y-m-d H:i:s', time() + get_option('gmt_offset') * 3600); 

        if ( 'Captured' === $captured ) {
            
            if ( 'pending' === $response->status ) {
                $order_stock_reduced = $order->get_meta( '_order_stock_reduced', true );

                if ( ! $order_stock_reduced ) {
                    wc_reduce_stock_levels( $order_id );
                }

                $order->set_transaction_id( $response->id );
                $order->update_status( 'on-hold');
                $order->add_order_note( __('Payment Status : ', 'payment-gateway-stripe-and-woocommerce-integration') . ucfirst($response->status) .' [ ' . $order_time . ' ] . ' . __('Source : ', 'payment-gateway-stripe-and-woocommerce-integration') . $response->source->type . '. ' . __('Charge Status :', 'payment-gateway-stripe-and-woocommerce-integration') . $captured . (is_null($response->balance_transaction) ? '' :'. Transaction ID : ' . $response->balance_transaction) );
            }
            
            if ( 'succeeded' === $response->status ) {
                $order->payment_complete( $response->id );

                $order->add_order_note( __('Payment Status : ', 'payment-gateway-stripe-and-woocommerce-integration') . ucfirst($response->status) .' [ ' . $order_time . ' ] . ' . __('Source : ', 'payment-gateway-stripe-and-woocommerce-integration') . $response->source->type . '. ' . __('Charge Status :', 'payment-gateway-stripe-and-woocommerce-integration') . $captured . (is_null($response->balance_transaction) ? '' :'. Transaction ID : ' . $response->balance_transaction) );
            }

        } else {
             $order->set_transaction_id( $response->id );

            if ( $order->has_status( array( 'pending', 'failed' ) ) ) {
                wc_reduce_stock_levels( $order_id );
            }

            $order->update_status( 'on-hold', sprintf( __( 'Stripe Bancontact order meta (Charge ID: %s). Process order to take payment, or cancel to remove the pre-authorization.', 'payment-gateway-stripe-and-woocommerce-integration' ), $response->id) );
        }

        if ($auto_redirect) {

            return array(
                    'result' => 'success',
                    'redirect' => $this->get_return_url($order),
                );
        }
        else{
            wp_safe_redirect($this->get_return_url($order));
        }
        //return $response;
    }

    /**
     *Gets client details.
     */
    public function get_clients_details() {
        return array(
            'IP' => $_SERVER['REMOTE_ADDR'],
            'Agent' => $_SERVER['HTTP_USER_AGENT'],
            'Referer' => $_SERVER['HTTP_REFERER']
        );
    }

    /**
     *Creates stripe customer
     */
    public function create_stripe_customer($source, $order_id, $user_email = false) {
        
        $response = \Stripe\Customer::create(array(
                    "description" => "Customer for Order #" . $order_id,
                    "email" => $user_email,
                    "source" => $source
        ));

        if (empty($response->id)) {
            return false;
        }

        return $response;
    }
    /**
     *Process alipay refund process.
     */
    public function process_refund($order_id, $amount = NULL, $reason = '') {
    
        $client = $this->get_clients_details();
        if ($amount > 0) {
            
            $data = get_post_meta($order_id, '_eh_stripe_payment_charge', true);
            $status = $data['captured'];

            if ('Captured' === $status) {
                $charge_id = $data['id'];
                $currency = $data['currency'];
                $total_amount = $data['amount'];
                        
                $order = new WC_Order($order_id);
                $div = $amount * ($total_amount / ((WC()->version < '2.7.0') ? $order->order_total : $order->get_total()));
                $refund_params = array(
                    'amount' => EH_Stripe_Payment::get_stripe_amount($div, $currency),
                    'reason' => 'requested_by_customer',
                    'charge' => $charge_id,
                    'metadata' => array(
                        'order_id' => $order->get_order_number(),
                        'Total Tax' => $order->get_total_tax(),
                        'Total Shipping' => (WC()->version < '2.7.0') ? $order->get_total_shipping() : $order->get_shipping_total(),
                        'Customer IP' => $client['IP'],
                        'Agent' => $client['Agent'],
                        'Referer' => $client['Referer'],
                        'Reason for Refund' => $reason
                    )
                );
                        
                try {
                    //$charge_response = \Stripe\Charge::retrieve($charge_id);
                    $refund_response = \Stripe\Refund::create($refund_params);
                    if ($refund_response) {
                                        
                        $refund_time = date('Y-m-d H:i:s', time() + get_option('gmt_offset') * 3600);
                        $obj = new EH_Stripe_Payment();
                        $data = $obj->make_refund_params($refund_response, $amount, ((WC()->version < '2.7.0') ? $order->order_currency : $order->get_currency()), $order_id);
                        add_post_meta($order_id, '_eh_stripe_payment_refund', $data);
                        $order->add_order_note(__('Reason : ', 'payment-gateway-stripe-and-woocommerce-integration') . $reason . '.<br>' . __('Amount : ', 'payment-gateway-stripe-and-woocommerce-integration') . get_woocommerce_currency_symbol() . $amount . '.<br>' . __('Status : refunded ', 'payment-gateway-stripe-and-woocommerce-integration') . ' [ ' . $refund_time . ' ] ' . (is_null($data['transaction_id']) ? '' : '<br>' . __('Transaction ID : ', 'payment-gateway-stripe-and-woocommerce-integration') . $data['transaction_id']));
                        EH_Stripe_Log::log_update('live', $data, get_bloginfo('blogname') . ' - Refund - Order #' . $order->get_order_number());
                        return true;
                    } else {
                        EH_Stripe_Log::log_update('dead', $data, get_bloginfo('blogname') . ' - Refund Error - Order #' . $order->get_order_number());
                        $order->add_order_note(__('Reason : ', 'payment-gateway-stripe-and-woocommerce-integration') . $reason . '.<br>' . __('Amount : ', 'payment-gateway-stripe-and-woocommerce-integration') . get_woocommerce_currency_symbol() . $amount . '.<br>' . __(' Status : Failed ', 'payment-gateway-stripe-and-woocommerce-integration'));
                        return new WP_Error('error', $data->message);
                    }
                } catch (Exception $error) {
                    $oops = $error->getJsonBody();
                    EH_Stripe_Log::log_update('dead', $oops['error'], get_bloginfo('blogname') . ' - Refund Error - Order #' . $order->get_order_number());
                    $order->add_order_note(__('Reason : ', 'payment-gateway-stripe-and-woocommerce-integration') . $reason . '.<br>' . __('Amount : ', 'payment-gateway-stripe-and-woocommerce-integration') . get_woocommerce_currency_symbol() . $amount . '.<br>' . __('Status : ', 'payment-gateway-stripe-and-woocommerce-integration') . $oops['error']['message']);
                    return new WP_Error('error', $oops['error']['message']);
                }
            } else {
                return new WP_Error('error', __('Uncaptured Amount cannot be refunded', 'payment-gateway-stripe-and-woocommerce-integration'));
            }
        } else {
            return false;
        }
    }

    //webhook callback
    public function eh_bancontact_callback_handler() { 
       $order_id = (isset($_REQUEST['order_id']) && !empty($_REQUEST['order_id'])) ? $_REQUEST['order_id'] : '';
        $order = wc_get_order($order_id);

        try{ 

            if (isset($_REQUEST['source']) && !empty($_REQUEST['source'])) {
                $source_id = sanitize_text_field($_REQUEST['source']);
                if(isset($_REQUEST['redirect_status']) && !empty($_REQUEST['redirect_status'])){
                    if (strtolower($_REQUEST['redirect_status']) == 'succeeded') { 
                        //Retrieve source
                        $source_response = \Stripe\Source::retrieve($source_id);
                        $this->process_source_response($source_response, $order);
                    }
                    else{
                        throw new Exception(__('Unable to process this payment, please try again.', 'payment-gateway-stripe-and-woocommerce-integration'));
                        
                    }

                }
                else{
                    throw new Exception(__('Unable to process this payment, please try again.', 'payment-gateway-stripe-and-woocommerce-integration'));
                }                          
            }
            else{
                throw new Exception(__('Unable to process this payment, please try again.', 'payment-gateway-stripe-and-woocommerce-integration'));
            }


        }
        catch(Exception $e){
            $order->update_status( 'failed', sprintf( __( 'Bancontact payment failed: %s', 'payment-gateway-stripe-and-woocommerce-integration' ),$e->getMessage() ) );

            wc_add_notice( sprintf( __( ' %s ', 'payment-gateway-stripe-and-woocommerce-integration' ), $e->getMessage()), 'error' );
            wp_safe_redirect( wc_get_checkout_url() );
        }

    }

    public function process_source_response($source_response, $order = null){
        if (!empty($source_response)) { 
            if (isset($source_response->error)) {
                throw new Exception($source_response->error->message);
            }
            else{ 
                if (isset($source_response->status) && !empty($source_response->status)) {
                    if ($source_response->status == 'chargeable') { 
                        
                        $charge_response = \Stripe\Charge::create($this->eh_make_charge_params( $order, $source_response->id), array(
                                'idempotency_key' => $order->get_order_key()
                            ));
                        return $this->eh_process_payment_response($charge_response, $order, false);

                    }
                    // case when source is on pending status
                    elseif ('pending' == $source_response->status) {
                        // Update order status to on-hold
                        $order_stock_reduced = $order->get_meta( '_order_stock_reduced', true );
                        if ( ! $order_stock_reduced ) {
                            wc_reduce_stock_levels( $order_id );
                        }
                        $order->update_status( 'on-hold');
                        
                        $order_time = date('Y-m-d H:i:s', time() + get_option('gmt_offset') * 3600); 
                        $order->add_order_note( __('Payment Status : Charge not initiated', 'payment-gateway-stripe-and-woocommerce-integration')  .' [ ' . $order_time . ' ] . '  );

                        wp_safe_redirect( $this->get_return_url($order) );
                        exit;


                    }
                    elseif ('consumed' == $source_response->status) {
                        wc_add_notice(__('Your payment is already processed!!', 'payment-gateway-stripe-and-woocommerce-integration'));
                        wp_safe_redirect( $this->get_return_url($order) );
                        exit;
                    }
                    else{ 
                        throw new Exception( sprintf(__('Source status is %s', 'payment-gateway-stripe-and-woocommerce-integration'), $source_response->status));
                    }
                }
                else{
                     throw new Exception( __('Unable to find the source status, please try again.', 'payment-gateway-stripe-and-woocommerce-integration'));
                }
            }
        }
    }
  
}