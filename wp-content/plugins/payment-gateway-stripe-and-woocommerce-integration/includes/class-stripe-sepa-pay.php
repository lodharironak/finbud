<?php

if (!defined('ABSPATH')) {
    exit;
}  

/**
 * EH_Stripe_Sepa_Pay class.
 *
 * @extends EH_Stripe_Payment
 */
class EH_Sepa_Stripe_Gateway extends WC_Payment_Gateway {

    /**
     * Constructor
     */
    public function __construct() {
        
        $this->id                 = 'eh_sepa_stripe';
        $this->method_title       = __( 'SEPA', 'payment-gateway-stripe-and-woocommerce-integration' );

        $url = add_query_arg( 'wc-api', 'wt_stripe', trailingslashit( get_home_url() ) );
        $this->method_description = sprintf( __( 'SEPA (Single Euro Payments Area) Direct Debit payment authenticates customers using the IBAN number. ' . '<a  class="thickbox" href="'.EH_STRIPE_MAIN_URL_PATH . 'assets/img/sepa-preview.png?TB_iframe=true&width=100&height=100"> [Preview] </a>', 'payment-gateway-stripe-and-woocommerce-integration' ));
        $this->supports = array(
            'products',
            'refunds',

        );

        // Load the form fields.
        $this->init_form_fields();

        // Load the settings.
        $this->init_settings();
        
        $stripe_settings               = get_option( 'woocommerce_eh_stripe_pay_settings' );
        
        $this->title                   = __($this->get_option( 'eh_stripe_sepa_title' ), 'payment-gateway-stripe-and-woocommerce-integration' );
        $this->description             = __($this->get_option( 'eh_stripe_sepa_description' ), 'payment-gateway-stripe-and-woocommerce-integration' );
        $this->enabled                 = $this->get_option( 'enabled' );
        $this->eh_order_button         = $this->get_option( 'eh_stripe_sepa_order_button');
        $this->order_button_text       = __($this->eh_order_button, 'payment-gateway-stripe-and-woocommerce-integration');

        if (isset($stripe_settings['eh_stripe_mode']) && 'test' === $stripe_settings['eh_stripe_mode']) {
            $this->description = $this->description . ' ' . __( '<p><strong>TEST MODE ENABLED</strong>. In test mode, you can use IBAN number AT611904300234573201.</p>', 'payment-gateway-stripe-and-woocommerce-integration' );
        }

        $this->description .= __(apply_filters('wt_sepa_mandate', 'By providing your IBAN and confirming this payment, you authorise and Stripe, our payment service provider, to send instructions to your bank to debit your account and your bank to debit your account in accordance with those instructions. You are entitled to a refund from your bank under the terms and conditions of your agreement with your bank. A refund must be claimed within 8 weeks starting from the date on which your account was debited.'), 'payment-gateway-stripe-and-woocommerce-integration' );

        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

        // Set stripe API key.
       
        \Stripe\Stripe::setApiKey(EH_Stripe_Payment::get_stripe_api_key());
        \Stripe\Stripe::setAppInfo( 'WordPress payment-gateway-stripe-and-woocommerce-integration', EH_STRIPE_VERSION, 'https://wordpress.org/plugins/payment-gateway-stripe-and-woocommerce-integration/', 'pp_partner_KHip9dhhenLx0S' );

 

        // Hooks
        add_action('wp_enqueue_scripts', array($this, 'payment_scripts'));

        add_action( 'woocommerce_api_wt_stripe', array( $this, 'eh_callback_handler' ) );
    }


    /**
     * Initialize form fields in sepa payment settings page.
     */
    public function init_form_fields() {

        $stripe_settings   = get_option( 'woocommerce_eh_stripe_pay_settings' );
        
        $this->form_fields = array(

            'eh_sepa_desc' => array(
                'type' => 'title',
                'description' => sprintf(__('%sSupported currency: %s EUR %sStripe accounts in the following countries can accept the payment: %sAustralia, Austria, Belgium, Bulgaria, Canada, Cyprus, Czech Republic, Denmark, Estonia, Finland, France, Germany, Greece, Hong Kong, Hungary, Ireland, Italy, Japan, Latvia, Lithuania, Luxembourg, Malta, Mexico, Netherlands, New Zealand, Norway, Poland, Portugal, Romania, Singapore, Slovakia, Slovenia, Spain, Sweden, Switzerland, United Kingdom, United States%s %s Read documentation %s', 'payment-gateway-stripe-and-woocommerce-integration'), '<div class="wt_info_div"><ul><li>', '<b>','</b></li><li>', '<b>', '</b></li></ul></div>', '<p><a target="_blank" href="https://www.webtoffee.com/woocommerce-stripe-payment-gateway-plugin-user-guide/#sepa_pay">', '</a></p>'),
            ),
            'eh_stripe_sepa_form_title'   => array(
                'type'        => 'title',
                'class'       => 'eh-css-class',
            ),
            'enabled'                       => array(
                'title'       => __('SEPA Pay','payment-gateway-stripe-and-woocommerce-integration'),
                'label'       => __('Enable','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'checkbox',
                'default'     => isset($stripe_settings['eh_stripe_sepa']) ? $stripe_settings['eh_stripe_sepa'] : 'no',
                'desc_tip'    => __('Enables customers in the Single Euro Payments Area (SEPA) to pay by providing their bank account details.','payment-gateway-stripe-and-woocommerce-integration'),
            ),
            'eh_stripe_sepa_title'         => array(
                'title'       => __('Title','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'text',
                'description' =>  __('Input title for the payment gateway displayed at the checkout.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     =>isset($stripe_settings['eh_stripe_sepa_title']) ? $stripe_settings['eh_stripe_sepa_title'] : __('SEPA Pay', 'payment-gateway-stripe-and-woocommerce-integration'),
                'desc_tip'    => true,
            ),
            'eh_stripe_sepa_description'     => array(
                'title'       => __('Description','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'textarea',
                'css'         => 'width:25em',
                'description' => __('Input texts for the payment gateway displayed at the checkout.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     =>isset($stripe_settings['eh_stripe_sepa_description']) ? $stripe_settings['eh_stripe_sepa_description'] : __('Secure debit payment via SEPA.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'desc_tip'    => true
            ),

            'eh_stripe_sepa_order_button'    => array(
                'title'       => __('Order button text', 'payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'text',
                'description' => __('Input a text that will appear on the order button to place order at the checkout.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     => isset($stripe_settings['eh_stripe_sepa_order_button']) ? $stripe_settings['eh_stripe_sepa_order_button'] :__('Pay via SEPA', 'payment-gateway-stripe-and-woocommerce-integration'),
                'desc_tip'    => true
            )
        );   
    }
    
    public function get_icon() {
        $style = version_compare(WC()->version, '2.6', '>=') ? 'style="margin-left: 0.3em"' : '';
        $icon = '';
        
        $icon .= '<img src="' . WC_HTTPS::force_https_url(EH_STRIPE_MAIN_URL_PATH . 'assets/img/sepa.png') . '" alt="SEPA" width="52" title="SEPA" ' . $style . ' />';
        return apply_filters('woocommerce_gateway_icon', $icon, $this->id);
    }

    /**
     * Outputs scripts used for stripe payment.
     */
    public function payment_scripts() {

        if(!$this->is_available()){
            return false;
        }

        if ( (is_checkout()  && !is_order_received_page())) {
            $stripe_settings   = get_option( 'woocommerce_eh_stripe_pay_settings' );
            wp_register_script('stripe_v3_js', 'https://js.stripe.com/v3/');

           wp_enqueue_script('eh_sepa_pay', plugins_url('assets/js/eh-sepa.js', EH_STRIPE_MAIN_FILE), array('stripe_v3_js','jquery'),EH_STRIPE_VERSION, true);
            if (isset($stripe_settings['eh_stripe_mode']) && 'test' === $stripe_settings['eh_stripe_mode']) {
                if (!isset($stripe_settings['eh_stripe_test_publishable_key']) || !isset($stripe_settings['eh_stripe_test_secret_key']) || ! $stripe_settings['eh_stripe_test_publishable_key'] || ! $stripe_settings['eh_stripe_test_secret_key']) {
                    return false;
                }
                else{
                    $public_key = $stripe_settings['eh_stripe_test_publishable_key'];
                }
            } else {
                if (!isset($stripe_settings['eh_stripe_live_secret_key']) || !isset($stripe_settings['eh_stripe_live_publishable_key']) || !$stripe_settings['eh_stripe_live_secret_key'] || !$stripe_settings['eh_stripe_live_publishable_key']) {
                    return false;
                }
                else{
                    $public_key = $stripe_settings['eh_stripe_live_publishable_key'];
                }
            }

            $show_zip_code = apply_filters('eh_stripe_ccshow_zipcode',true);
            $stripe_params = array(
                'key' => $public_key,
                'show_zip_code' => $show_zip_code,
                'i18n_terms' => __('Please accept the terms and conditions first', 'payment-gateway-stripe-and-woocommerce-integration'),
                'i18n_required_fields' => __('Please fill in required checkout fields first', 'payment-gateway-stripe-and-woocommerce-integration'),
            );
            $stripe_params['sepa_elements_option']                   = apply_filters(
                'eh_stripe_sepa_elements_option',
                array(
                    'supportedCountries' => array( 'SEPA' ),
                    
                    'placeholderCountry' => 'DE',
                    'style'              => array( 'base' => array( 'fontSize' => '15px' ,
                                                                "iconColor" => "#666EE8",
                                                                "color" => "#31325F",
                                                                "fontSize" => "15px",
                                                                "::placeholder" => array(
                                                                                    "color" => "#CFD7E0",
                                                                                ),
                                                            )
                                             ),
                )
            );

            $stripe_params['is_checkout']                             = ( is_checkout() && empty( $_GET['pay_for_order'] ) ) ? 'yes' : 'no';
            $stripe_params['inline_postalcode']                       = apply_filters('hide_inline_postal_code', true);

            // If we're on the pay page we need to pass stripe.js the address of the order.
            if ( isset( $_GET['pay_for_order'] ) && 'true' === $_GET['pay_for_order'] ) {

                $order     = wc_get_order( absint( get_query_var( 'order-pay' ) ) );

                if ( is_a( $order, 'WC_Order' ) ) {
                    $stripe_params['billing_first_name'] = method_exists($order, 'get_billing_first_name') ? $order->get_billing_first_name() : $order->billing_first_name;
                    $stripe_params['billing_last_name']  = method_exists($order, 'get_billing_last_name')  ? $order->get_billing_last_name()  : $order->billing_last_name;
                    $stripe_params['billing_address_1']  = method_exists($order, 'get_billing_address_1')  ? $order->get_billing_address_1()  : $order->billing_address_1;
                    $stripe_params['billing_address_2']  = method_exists($order, 'get_billing_address_2')  ? $order->get_billing_address_2()  : $order->billing_address_2;
                    $stripe_params['billing_state']      = method_exists($order, 'get_billing_state')      ? $order->get_billing_state()      : $order->billing_state;
                    $stripe_params['billing_city']       = method_exists($order, 'get_billing_city')       ? $order->get_billing_city()       : $order->billing_city;
                    $stripe_params['billing_postcode']   = method_exists($order, 'get_billing_postcode')   ? $order->get_billing_postcode()   : $order->billing_postcode;
                    $stripe_params['billing_country']    = method_exists($order, 'get_billing_country')    ? $order->get_billing_country()    : $order->billing_country;
                }                       
            }
            $stripe_params['version'] = EH_Stripe_Payment::wt_get_api_version();
            wp_localize_script('eh_sepa_pay', 'eh_sepa_val', apply_filters('eh_sepa_val', $stripe_params));
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
            echo apply_filters('eh_sepa_desc', wpautop(wp_kses_post("<span>" . $this->description . "</span>")));
        }
        echo "</div>";
        $pay_button_text = __('Pay', 'payment-gateway-stripe-and-woocommerce-integration');
        if (is_checkout_pay_page()) {
            $order_id = get_query_var('order-pay');
            $order = wc_get_order($order_id);
            $email = (WC()->version < '2.7.0') ? $order->billing_email : $order->get_billing_email();
            echo '<div
                id="eh-sepa-pay-data"
                data-panel-label="' . esc_attr($pay_button_text) . '"
                data-email="' . esc_attr(($email !== '') ? $email : get_bloginfo('name', 'display')) . '"
                data-amount="' . esc_attr(EH_Stripe_Payment::get_stripe_amount(((WC()->version < '2.7.0') ? $order->order_total : $order->get_total()))) . '"
                data-name="' . esc_attr(sprintf(get_bloginfo('name', 'display'))) . '"
                data-currency="' . esc_attr(((WC()->version < '2.7.0') ? $order->order_currency : $order->get_currency())) . '">';

           echo $this->elements_form();
            echo '</div>';

        } else {
            echo '<div
                id="eh-sepa-pay-data"
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

                <div class="form-row  form-row-wide">
                    <input type="hidden" name="eh_sepa_source"  id="eh_sepa_source" value="test">
                    <input type="hidden" name="eh_sepa_source_status"  id="eh_sepa_source_status" value="test">
                    <!--
                    Using a label with a for attribute that matches the ID of the
                    Element container enables the Element to automatically gain focus
                    when the customer clicks on the label.
                    -->
                    <label for="eh-stripe-iban-element"><?php esc_html_e( 'IBAN', 'payment-gateway-stripe-and-woocommerce-integration' ); ?> <span class="required">*</span></label>
                    <div id="eh-stripe-iban-element"  class="eh-stripe-elements-field">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>
                </div> 
              
                <div class="clear"></div>

            <!-- Used to display form errors -->
            <div class="sepa-source-errors" role="alert" style="color:#ff0000"></div>
            <div class="clear"></div>
        </fieldset>
        <?php
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
     *Process stripe payment.
     */
    public function process_payment($order_id) { 
        $order = wc_get_order( $order_id );
        $currency =  $order->get_currency();
        
        try{
            $obj_stripe = new EH_Stripe_Payment();

            if (isset($_POST['eh_sepa_source']) && !empty($_POST['eh_sepa_source'])) {
                $source_id = sanitize_text_field($_POST['eh_sepa_source']);
                 $source_status = sanitize_text_field($_POST['eh_sepa_source_status']);


                if ( version_compare(WC_VERSION, '2.7.0', '<') ) {
                    update_post_meta( $order_id, '_eh_sepa_source_id', $source_id );
                } else {
                    $order->update_meta_data( '_eh_sepa_source_id', $source_id );
                }
                $order->save();

                //check the status of source
                if ($source_status == 'chargeable') {
                   $customer = $this->create_stripe_customer($source_id, $order, ((WC()->version < '2.7.0') ? $order->billing_email : $order->get_billing_email()));                 
                    
                    if (!empty($customer)) {
                        $user_id = $order->get_user_id();
                        update_user_meta($user_id, "_sepa_customer_id", $customer->id);
                    }
                    

                    
                    // create charge
                    $charge_response = \Stripe\Charge::create($this->eh_make_charge_params( $order, $source_id,  $customer->id), array(
                                'idempotency_key' => $order->get_order_key() . '-' . $customer->id
                            ));

                   return $this->eh_process_payment_response($charge_response, $order);

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
            $order->update_status( 'failed', sprintf( __( 'Sepa payment failed: %s', 'payment-gateway-stripe-and-woocommerce-integration' ),$e->getMessage() ) );
            
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

        return apply_filters( 'eh_sepa_generate_charge_request', $post_data, $order, $source_id );
    }

    /**
     * Store extra meta data for an order and adds order notes for orders.
     */
    public function eh_process_payment_response( $response, $order ) {
        
        $order_id = (WC()->version < '2.7.0') ? $order->id : $order->get_id();
        
        // Stores charge data.
        $obj1 = new EH_Stripe_Payment();
        $charge_param = $obj1->make_charge_params($response, $order_id);
        add_post_meta($order_id, '_eh_stripe_payment_charge', $charge_param);
        
        $order_id  = version_compare(WC_VERSION, '2.7.0', '<') ? $order->id : $order->get_id();
        $captured = ( isset( $response->captured ) && $response->captured == true) ? 'Captured' : 'Uncaptured';
        
        // Stores charge capture data.
        if ( version_compare(WC_VERSION, '2.7.0', '<') ) {
            update_post_meta( $order_id, '_eh_sepa_charge_captured', $captured );
        } else {
            $order->update_meta_data( '_eh_sepa_charge_captured', $captured );
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

            $order->update_status( 'on-hold', sprintf( __( 'Stripe SEPA order meta (Charge ID: %s). Process order to take payment, or cancel to remove the pre-authorization.', 'payment-gateway-stripe-and-woocommerce-integration' ), $response->id) );
        }

        return array(
                'result' => 'success',
                'redirect' => $this->get_return_url($order),
            );
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
     *Gets details for stripe charge creation.
     */
    public function get_charge_details( $order, $order_type, $client, $currency, $amount,$customer = '' ) {
        $product_name = array();
        foreach ($order->get_items() as $item) {
            array_push($product_name, $item['name']);
        }

        $charge = array(
           // 'payment_method' => $payment_method,
            'payment_method_types' => array('sepa_debit'),
            'amount' => $amount,
            'currency' => $currency,
            'setup_future_usage' => 'off_session',
            'metadata' => array(
                'integration_check' => 'sepa_debit_accept_a_payment',
                'order_id' => $order->get_order_number(),
                'Total Tax' => $order->get_total_tax(),
                'Total Shipping' => $order->get_total_shipping(),
                'Customer IP' => $client['IP'],
                'Agent' => $client['Agent'],
                'Referer' => $client['Referer'],
                'WP customer #' => (WC()->version < '2.7.0') ? $order->user_id : $order->get_user_id(),
                'Billing Email' => (WC()->version < '2.7.0') ? $order->billing_email : $order->get_billing_email()
            ),
            'description' => wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' Order #' . $order->get_order_number(),
        );
        

        $charge['customer'] = $customer;

        $product_list = implode(' | ', $product_name);

        $charge['metadata']['Products'] = substr($product_list, 0, 499);
        
                                    
            $charge['description']=$charge['metadata']['Products'] .' '.wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' Order #' . $order->get_order_number();

        //$charge['confirm'] =  true ;

        if ($this->eh_stripe_email_receipt) {
            $charge['receipt_email'] = (WC()->version < '2.7.0') ? $order->billing_email : $order->get_billing_email();
        }
        if (!is_checkout_pay_page()) {
            $charge['shipping'] = array(
                'address' => array(
                    'line1' => (WC()->version < '2.7.0') ? $order->shipping_address_1 : $order->get_shipping_address_1(),
                    'line2' => (WC()->version < '2.7.0') ? $order->shipping_address_2 : $order->get_shipping_address_2(),
                    'city' => (WC()->version < '2.7.0') ? $order->shipping_city : $order->get_shipping_city(),
                    'state' => (WC()->version < '2.7.0') ? $order->shipping_state : $order->get_shipping_state(),
                    'country' => (WC()->version < '2.7.0') ? $order->shipping_country : $order->get_shipping_country(),
                    'postal_code' => (WC()->version < '2.7.0') ? $order->shipping_postcode : $order->get_shipping_postcode()
                ),
                'name' => ((WC()->version < '2.7.0') ? $order->shipping_first_name : $order->get_shipping_first_name()) . ' ' . ((WC()->version < '2.7.0') ? $order->shipping_last_name : $order->get_shipping_last_name()),
                'phone' => (WC()->version < '2.7.0') ? $order->billing_phone : $order->get_billing_phone(),
            );
        }
        
       return apply_filters('eh_sepa_payment_intent_args', $charge);
    }

    /**
     *Creates stripe customer
     */
    public function create_stripe_customer($source, $order, $user_email = false) {

        $order_no = $order->get_order_number();
        $response = \Stripe\Customer::create(array(
                    "description" => "Customer for Order #" . $order_no,
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


   //update errors occuring during different processes
    private function process_error($order, $title, $message, $status = 'failed') {
        $order->add_order_note($message['message']);
        $order->update_status($status);

        $error_arr = array('message' => $message);
        EH_Stripe_Log::log_update('dead', $error_arr, get_bloginfo('blogname') . " - $title - Order #" . $order->get_order_number());
    }

    //webhook callback
    public function eh_callback_handler() {
        global $wpdb;
 
        $raw_post = file_get_contents( 'php://input' );
        if (!empty($raw_post)) {
            $decoded  = json_decode( $raw_post, true );

            if (!empty($decoded)) {

                EH_Stripe_Log::log_update('live', $decoded, get_bloginfo('blogname') . ' - WebHook event');
               switch (strtolower($decoded['type'])) {
                   case 'charge.succeeded':
                   case 'charge.failed':
                       if (isset($decoded['data']['object']['metadata']['order_id']) && !empty($decoded['data']['object']['metadata']['order_id'])) {
                            $order_id = $decoded['data']['object']['metadata']['order_id'];

                            $transaction_id = sanitize_text_field($decoded['data']['object']['id']);


                            if(!$order = wc_get_order( $order_id )){
                                $meta = $wpdb->get_results( "SELECT post_id FROM " . $wpdb->postmeta ." WHERE meta_key = '_transaction_id' AND meta_value= '" . $transaction_id  . "'" );

                                if (!empty($meta) && isset($meta[0]->post_id)) {
                                    $order_id = $meta[0]->post_id;
                                    $order = wc_get_order( $order_id );  
                               }
                               else if(isset($decoded['data']['object']['payment_intent'])){
                                    $payment_intent_id = sanitize_text_field($decoded['data']['object']['payment_intent']);
                                    $meta = $wpdb->get_results( "SELECT post_id FROM " . $wpdb->postmeta ." WHERE meta_key = '_eh_stripe_payment_intent' AND meta_value= '" . $payment_intent_id  . "'" );
                                    
                                    if (!empty($meta) && isset($meta[0]->post_id)) {
                                        $order_id = $meta[0]->post_id;
                                        $order = wc_get_order( $order_id );  
                                   }                               
                               }

                            }
                            
                            if (!$order) {
                                exit;
                            }

                            $obj1 = new EH_Stripe_Payment();
                            $charge_param = $obj1->make_charge_params($decoded['data']['object'], $order_id);
                            update_post_meta($order_id, '_eh_stripe_payment_charge', $charge_param);
                            
                            if ( 'on-hold' == $order->status || 'pending' == $order->status) {
                                if (isset($decoded['data']['object']['status']) && $decoded['data']['object']['status'] == 'succeeded') {
                                     $status = $decoded['data']['object']['status'];

                                        $order->set_transaction_id( sanitize_text_field($decoded['data']['object']['id'] ));

                                        
                                        $order_time = date('Y-m-d H:i:s', time() + get_option('gmt_offset') * 3600); 
                                        $source_type = $decoded['data']['object']['payment_method_details']['type'];
                                        $source_type = (isset($decoded['data']['object']['payment_method_details']['type']) ? $decoded['data']['object']['payment_method_details']['type'] : (isset($decoded['data']['object']['source']['type']) ? $decoded['data']['object']['source']['type'] : 'unknown') );
                                         $balance_transaction_id = ((is_array($decoded['data']['object']['balance_transaction']) && isset($decoded['data']['object']['balance_transaction']['id'])) ? $decoded['data']['object']['balance_transaction']['id'] : (isset($decoded['data']['object']['balance_transaction']) ? $decoded['data']['object']['balance_transaction'] : 'unknown'));



                                        if ($decoded['data']['object']['captured'] == true) {
                                            $captured = 'Captured';
                                            $order->payment_complete( $transaction_id );

                                        }
                                        else{
                                            $captured = 'Uncaptured';
                                             $order->update_status('on-hold');
                                        }
                                        $order->add_order_note( __('Payment Status : ', 'payment-gateway-stripe-and-woocommerce-integration') . ucfirst($status) .' [ ' . $order_time . ' ] . ' . __('Source : ', 'payment-gateway-stripe-and-woocommerce-integration') . $source_type . '. ' . __('Charge Status :', 'payment-gateway-stripe-and-woocommerce-integration') . $captured . __('. Transaction ID : ', 'payment-gateway-stripe-and-woocommerce-integration') . $balance_transaction_id . __('. via webhook', 'payment-gateway-stripe-and-woocommerce-integration') );
                                } 
                                else {
                                    // Set order status to payment failed
                                    $order->update_status( 'failed', sprintf( __( 'Payment failed.', 'payment-gateway-stripe-and-woocommerce-integration' ) ) );
                                }
                            }
                        }
                       break;
                   
                   case 'charge.dispute.created':
                        if (isset($decoded['data']['object']['charge'])) {
                           $charge_id = sanitize_text_field($decoded['data']['object']['charge']);
                            if (!empty($charge_id)) {
                                $meta = $wpdb->get_results( "SELECT post_id FROM " . $wpdb->postmeta ." WHERE meta_key = '_transaction_id' AND meta_value= '" . $charge_id  . "'" );
                                 if (!empty($meta)) { 
                                    $order_id = $meta[0]->post_id;
                                    $order = wc_get_order( $order_id );

                                    $order->add_order_note( __('A dispute was created for this order : ', 'payment-gateway-stripe-and-woocommerce-integration') . $decoded['data']['object']['charge']);

                                    // Set order status to payment failed
                                        $order->update_status( 'failed', sprintf( __( 'Payment failed.', 'payment-gateway-stripe-and-woocommerce-integration' ) ) );
                                }
                            }
                        }
                       break;
                   
                   case 'charge.refund.updated':
                       if (isset($decoded['data']['object']['charge'])) {
                           $charge_id = sanitize_text_field($decoded['data']['object']['charge']);
                            if (!empty($charge_id)) {
                                if (isset($decoded['data']['object']['object']) && $decoded['data']['object']['object'] == 'refund') {

                                     $meta = $wpdb->get_results( "SELECT post_id FROM " . $wpdb->postmeta ." WHERE meta_key = '_transaction_id' AND meta_value= '" . $charge_id  . "'" );
                                     if (!empty($meta)) { 
                                        $order_id = $meta[0]->post_id;
                                        $order = wc_get_order( $order_id );

                                    }

                                    $refund_params = get_post_meta($order_id, '_eh_stripe_payment_refund', true);
                                    if(isset($refund_params['transaction_id']) && !empty($refund_params['transaction_id']) && $refund_params['transaction_id'] != $decoded['data']['object']['balance_transaction']){


                                        $refund_amount = EH_Stripe_Payment::reset_stripe_amount($decoded['data']['object']['amount'], $order->get_currency());

                                        if ($decoded['data']['object']['status'] == 'failed') {
                                            $reason = ((isset($decoded['data']['object']['failure_reason']) && !empty($decoded['data']['object']['failure_reason'])) ? $decoded['data']['object']['failure_reason'] 
                                            : 'Refund failed - Unknown error occurred');
                                            $order->add_order_note( __('Refund of '  . get_woocommerce_currency_symbol() . $refund_amount . ' failed - ' . $reason, 'payment-gateway-stripe-and-woocommerce-integration'));

                                            // Set order status to payment failed
                                                $order->update_status( 'processing', sprintf( __( 'Refund Failed.', 'payment-gateway-stripe-and-woocommerce-integration' ) ) );
                                        }
                                        else{
                                            
                                            $order->add_order_note((__('Amount : ', 'payment-gateway-stripe-and-woocommerce-integration') .get_woocommerce_currency_symbol() . $refund_amount . '.<br>' . __('Status : ', 'payment-gateway-stripe-and-woocommerce-integration') . 'Success' . (is_null($decoded['data']['object']['balance_transaction']) ? '' : '<br>' . __('Transaction ID : ', 'payment-gateway-stripe-and-woocommerce-integration') . $decoded['data']['object']['balance_transaction'] )));

                                            // Set order status to payment failed
                                                $order->update_status( 'refunded', sprintf( __( 'Refunded.', 'payment-gateway-stripe-and-woocommerce-integration' ) ) );
                                        }
                                    }
                                }

                            }
                       }
                       break;
                   
                   case 'payment_intent.succeeded':
                   case 'payment_intent.payment_failed':
                        if (isset($decoded['data']['object']['id']) && !empty($decoded['data']['object']['id'])) {
                            $intent_id = sanitize_text_field($decoded['data']['object']['id']);
                            
                            if (isset($decoded['data']['object']['metadata']['order_id']) && !empty($decoded['data']['object']['metadata']['order_id'])) {
                                $order_id = $decoded['data']['object']['metadata']['order_id'];
                                if (!$order = wc_get_order( $order_id )) {
                                    //if sequential plugin is installed payapl response return order no instead of order id. Then get order id from order number
                                    if(class_exists('Wt_Advanced_Order_Number')){ 
                                        $args    = array(
                                                    'post_type'      => 'shop_order',
                                                    'post_status'    => 'any',
                                                    'meta_query'     => array(
                                                        array(
                                                            'key'        => '_order_number',
                                                            'value'      => $order_id,  //here you pass the Order Number
                                                            'compare'    => '=',
                                                        )
                                                    )
                                                );
                                        $query   = new WP_Query( $args );
                                        if ( !empty( $query->posts ) ) {
                                             $order_id = $query->posts[ 0 ]->ID;
                                        } 
                                    }                            
                                }
                            }
                            else{
                                $meta = $wpdb->get_results( "SELECT post_id FROM " . $wpdb->postmeta ." WHERE meta_key = '_eh_stripe_payment_intent' AND meta_value= '" . $intent_id  . "'" );

                                if (!empty($meta) && isset($meta[0]->post_id)) {
                                    $order_id = $meta[0]->post_id;
                                    
                               }
                            }

                            if (!empty($order_id)) {
                                if($order = wc_get_order( $order_id )){
                                    $request = array('id' => $intent_id);
                                    $reqst_json = json_encode($request );
                                    if ( 'on-hold' == $order->status || 'pending' == $order->status) {

                                        if (isset($decoded['data']['object']['status']) && $decoded['data']['object']['status'] == 'succeeded') {
                                            $obj1 = new EH_Stripe_Payment();
                                            $charge_param = $obj1->make_charge_params($decoded['data']['object']['charges']['data'][0], $order_id);
                                            update_post_meta($order_id, '_eh_stripe_payment_charge', $charge_param);
                                            
                                             $order_time = date('Y-m-d H:i:s', time() + get_option('gmt_offset') * 3600);
                                            if ($decoded['data']['object']['charges']['data'][0]['paid'] == true) {

                                                if($decoded['data']['object']['charges']['data'][0]['captured'] == true){
                                                    $order->payment_complete($charge_param['id']);
                                                }
                                                if (!$decoded['data']['object']['charges']['data'][0]['captured']) {
                                                    $order->update_status('on-hold');
                                                }
                                                $order->add_order_note(__('Payment Status : ', 'payment_gateway_stripe_and_woocommerce_integration') . ucfirst($charge_param['status']) . ' [ ' . $order_time . ' ] . ' . __('Source : ', 'payment_gateway_stripe_and_woocommerce_integration') . $charge_param['source_type'] . '. ' . __('Charge Status :', 'payment_gateway_stripe_and_woocommerce_integration') . $charge_param['captured'] . (is_null($charge_param['transaction_id']) ? '' : '. <br>'.__('Transaction ID : ','payment_gateway_stripe_and_woocommerce_integration') . $charge_param['transaction_id']));
                                                WC()->cart->empty_cart();
                                                EH_Stripe_Log::log_update('live', $charge_param, get_bloginfo('blogname') . ' - Charge - Order #' . $order->get_order_number());

                                            } else {
                                                EH_Stripe_Log::log_update('dead', $decoded['data']['object']['charges']['data'][0], get_bloginfo('blogname') . ' - Charge - Order #' . $order->get_order_number());
                                            }                                  


                                        } 
                                        else {
                                            // Set order status to payment failed
                                            $reason = 'Payment failed';
                                            if(isset($decoded['data']['object']['charges']['data'][0]['failure_message']) && !empty($decoded['data']['object']['charges']['data'][0]['failure_message'])){
                                                $reason .= ' - ' .$decoded['data']['object']['charges']['data'][0]['failure_message'];
                                            }

                                           $order->update_status( 'failed', sprintf( __( 'Payment failed.', 'payment_gateway_stripe_and_woocommerce_integration' ) ) );
                                        } 
                                    }                                 
                                }
                            }
                             
                        }
                        
                       break;


                    case 'source.chargeable': 

                            if (isset($decoded['data']['object']['metadata']['order_id']) && !empty($decoded['data']['object']['metadata']['order_id'])) {
                                $order_id = $decoded['data']['object']['metadata']['order_id'];
                            }
                            elseif(isset($decoded['data']['object']['redirect']['return_url']) && !empty($decoded['data']['object']['redirect']['return_url'])){ 
                                $return_url = $decoded['data']['object']['redirect']['return_url'];
                                $arr_parts = wp_parse_url($return_url);
                                if(isset($arr_parts) && !empty($arr_parts) && isset($arr_parts['query']) && !empty($arr_parts['query'])){ 
                                    wp_parse_str($arr_parts['query'], $arr_params);
                                    if(!empty($arr_params) && isset($arr_params['order_id']) && !empty($arr_params['order_id'])){
                                         $order_id = $arr_params['order_id'];
                                    }
                                }
                            }
                            if(isset($order_id) && !empty($order_id)){ 
                                $source_id = sanitize_text_field($decoded['data']['object']['id']);

                                $order = wc_get_order( $order_id );
                                if($order && $order->has_status('on-hold')){ 

                                    //check stripe vendor folder is exist
                                    if (!class_exists('Stripe\Stripe')) {
                                        include(EH_STRIPE_MAIN_PATH . "vendor/autoload.php");
                                    }
                                    $objKlarna = new EH_Klarna_Gateway();

                                    //check the source stats is chargeable
                                    $source_response = \Stripe\Source::retrieve($source_id);
                                    if (isset($source_response->status) && !empty($source_response->status) && 'chargeable' == $source_response->status) {
                                        
                                        $charge_response = \Stripe\Charge::create($objKlarna->eh_make_charge_params( $order, $source_response->id), array(
                                                'idempotency_key' => $order->get_order_key()
                                            )); 

                                        $objKlarna->eh_process_payment_response($charge_response, $order, true);
                                    }

                                }

                            }
                            

                        break; 

                        case 'checkout.session.expired':
                            if (isset($decoded['data']['object']['metadata']['order_id']) && !empty($decoded['data']['object']['metadata']['order_id'])) {
                                $order_id = $decoded['data']['object']['metadata']['order_id'];
                            }
                            elseif(isset($decoded['data']['object']['success_url']) && !empty($decoded['data']['object']['success_url'])){ 
                                $arr_parts = wp_parse_url($decoded['data']['object']['success_url']);
                                if(isset($arr_parts) && !empty($arr_parts) && isset($arr_parts['query']) && !empty($arr_parts['query'])){ 
                                    wp_parse_str($arr_parts['query'], $arr_params);
                                    if(!empty($arr_params) && isset($arr_params['order_id']) && !empty($arr_params['order_id'])){
                                         $order_id = $arr_params['order_id'];
                                    }
                                }
                            }
                            if(isset($order_id) && !empty($order_id)){ 
                                $order = wc_get_order( $order_id );
                                if($order){                                                               
                                    $order->update_status( 'cancelled', __( 'Stripe checkout abandoned.', 'payment_gateway_stripe_and_woocommerce_integration' ));
                                }
                            }

                        break;                
                   default:
                       // code...
                       break;
               }
            }

        }
        
        die;
    }
  
}