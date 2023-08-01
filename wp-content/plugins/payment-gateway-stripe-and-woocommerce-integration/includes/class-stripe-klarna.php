<?php

if (!defined('ABSPATH')) {
    exit;
}  

/**
 * EH_Klarna_Gateway class.
 *
 * @extends EH_Stripe_Payment
 */
class EH_Klarna_Gateway extends WC_Payment_Gateway {

    /**
     * Constructor
     */
    public function __construct() {
        
        $this->id                 = 'eh_klarna_stripe';
        $this->method_title       = __( 'Klarna', 'payment-gateway-stripe-and-woocommerce-integration' );

        $url = add_query_arg( 'wc-api', 'wt_stripe', trailingslashit( get_home_url() ) );
        $this->method_description =  __( 'Accepts payments via Klarna - Pay now, Pay later, Financing, or Installments based on location.' . '<a  class="thickbox" href="'.EH_STRIPE_MAIN_URL_PATH . 'assets/img/klarna-preview.png?TB_iframe=true&width=100&height=100">[Preview] </a>', 'payment-gateway-stripe-and-woocommerce-integration' );
        $this->supports = array(
            'products',
            'refunds',
        );

        // Load the form fields.
        $this->init_form_fields();

        // Load the settings.
        $this->init_settings();
        
        $stripe_settings               = get_option( 'woocommerce_eh_stripe_pay_settings' );
        $this->capture_now = ((isset($stripe_settings['eh_stripe_capture']) && !empty($stripe_settings['eh_stripe_capture'])) ? $stripe_settings['eh_stripe_capture'] : '');
        
        $this->title                   = __($this->get_option( 'eh_stripe_klarna_title' ), 'payment-gateway-stripe-and-woocommerce-integration' );
        $this->description             = __($this->get_option( 'eh_stripe_klarna_description' ), 'payment-gateway-stripe-and-woocommerce-integration' );
        $this->enabled                 = $this->get_option( 'enabled' );
        $this->eh_order_button         = $this->get_option( 'eh_stripe_klarna_order_button');
        $this->order_button_text       = __($this->eh_order_button, 'payment-gateway-stripe-and-woocommerce-integration');

        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

        // Set stripe API key.
       
        \Stripe\Stripe::setApiKey(EH_Stripe_Payment::get_stripe_api_key());
        \Stripe\Stripe::setAppInfo( 'WordPress payment-gateway-stripe-and-woocommerce-integration', EH_STRIPE_VERSION, 'https://wordpress.org/plugins/payment-gateway-stripe-and-woocommerce-integration/', 'pp_partner_KHip9dhhenLx0S' );


       add_action( 'woocommerce_api_eh_klarna_gateway', array( $this, 'eh_klarna_callback_handler' ) );
    }


    /**
     * Initialize form fields in klarna payment settings page.
     */
    public function init_form_fields() {

        $stripe_settings   = get_option( 'woocommerce_eh_stripe_pay_settings' );
        
        $this->form_fields = array(
             

            'eh_klarna_desc' => array(
                'type' => 'title',
                'description' => sprintf(__('%sSupported currencies: %sEUR, USD, GBP, DKK, SEK, NOK%s %sStripe accounts in the following countries can accept the payment: %sAustria, Belgium, Denmark, Estonia, Finland, France, Germany, Greece, Ireland, Italy, Latvia, Lithuania, Netherlands, Norway, Slovakia, Slovenia, Spain, Sweden, United Kingdom, United States %s %s Read documentation %s', 'payment-gateway-stripe-and-woocommerce-integration'), '<div class="wt_info_div"><ul><li>', '<b>','</b>', '</li><li>', '<b>', '</b></li></ul></div>', '<p><a target="_blank" href="https://www.webtoffee.com/woocommerce-stripe-payment-gateway-plugin-user-guide/#klarna">', '</a></p>'),
            ),
            'eh_stripe_klarna_form_title'   => array(
                'type'        => 'title',
                'class'       => 'eh-css-class',
            ),
            'enabled'                       => array(
                'title'       => __('Klarna','payment-gateway-stripe-and-woocommerce-integration'),
                'label'       => __('Enable','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'checkbox',
                'default'     => isset($stripe_settings['eh_stripe_klarna']) ? $stripe_settings['eh_stripe_klarna'] : 'no',
                'desc_tip'    => __('Enables to accept payments using Klarna.','payment-gateway-stripe-and-woocommerce-integration'),
            ),
            'eh_stripe_klarna_title'         => array(
                'title'       => __('Title','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'text',
                'description' =>  __('Input title for the payment gateway displayed at the checkout.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     =>isset($stripe_settings['eh_stripe_klarna_title']) ? $stripe_settings['eh_stripe_klarna_title'] : __('Klarna', 'payment-gateway-stripe-and-woocommerce-integration'),
                'desc_tip'    => true,
            ),
            'eh_stripe_klarna_description'     => array(
                'title'       => __('Description','payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'textarea',
                'css'         => 'width:25em',
                'description' => __('Input texts for the payment gateway displayed at the checkout.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     =>isset($stripe_settings['eh_stripe_klarna_description']) ? $stripe_settings['eh_stripe_klarna_description'] : __('Accept payments using Klarna.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'desc_tip'    => true
            ),

            'eh_stripe_klarna_order_button'    => array(
                'title'       => __('Order button text', 'payment-gateway-stripe-and-woocommerce-integration'),
                'type'        => 'text',
                'description' => __('Input a text that will appear on the order button to place order at the checkout.', 'payment-gateway-stripe-and-woocommerce-integration'),
                'default'     => isset($stripe_settings['eh_stripe_klarna_order_button']) ? $stripe_settings['eh_stripe_klarna_order_button'] :__('Pay via Klarna', 'payment-gateway-stripe-and-woocommerce-integration'),
                'desc_tip'    => true
            )
        );   
    }
 
     
    public function get_icon() {
        $style = version_compare(WC()->version, '2.6', '>=') ? 'style="margin-left: 0.3em"' : '';
        $icon = '';
        
        $icon .= '<img src="' . WC_HTTPS::force_https_url(EH_STRIPE_MAIN_URL_PATH . 'assets/img/klarna.png') . '" alt="Klarna" width="52" title="Klarna" ' . $style . ' />';
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
     * gets parameters for alipay source.
     *
     */
    public function eh_create_source( $order ) {
        $currency              =  $order->get_currency();
        $order_id              =  version_compare(WC_VERSION, '2.7.0', '<') ? $order->id : $order->get_id();
        $country = (WC()->version < '2.7.0') ? $order->billing_country    : $order->get_billing_country();
        $billing_first_name    =  (WC()->version < '2.7.0') ? $order->billing_first_name : $order->get_billing_first_name();
        $billing_last_name     =  (WC()->version < '2.7.0') ? $order->billing_last_name  : $order->get_billing_last_name();
        $email                 =  (WC()->version < '2.7.0') ? $order->billing_email      : $order->get_billing_email();
        $phone                 =  (WC()->version < '2.7.0') ? $order->billing_phone      : $order->get_billing_phone();
       
        $post_data             =  array();

        $post_data['amount']   = EH_Stripe_Payment::get_stripe_amount( $order->get_total(), $currency );
        $post_data['currency'] = strtolower( $currency );
        $post_data['type']     = 'klarna';
      
       foreach ($order->get_items() as $item) { 
            $product['items'][] = array(
                'type' => 'sku',
                'description' => $item['name'],
                'quantity' => $item['quantity'],
                'currency' => $currency,
                'amount' => EH_Stripe_Payment::get_stripe_amount(  $item['subtotal'], $currency ),
            ); 
        }
        if ( 0 < $order->get_shipping_total() ) {
            $product['items'][] = array(
                'type'        => 'shipping',
                'amount'      => EH_Stripe_Payment::get_stripe_amount( $order->get_shipping_total(), $currency ),
                'currency'    => $currency,
                'quantity'    => 1,
                'description' => __( 'Shipping', 'payment-gateway-stripe-and-woocommerce-integration' ),
            );
        }
        // discount
        if ( 0 < $order->get_discount_total() ) {
            $product['items'][] = array(
                'type'        => 'discount',
                'amount'      => - 1 * EH_Stripe_Payment::get_stripe_amount( $order->get_discount_total(), $currency ),
                'currency'    => $currency,
                'quantity'    => 1,
                'description' => __( 'Discount', 'payment-gateway-stripe-and-woocommerce-integration' ),
            );
        }
        // fees
        if ( $order->get_fees() ) {
            $fee_total = 0;
            foreach ( $order->get_fees() as $fee ) {
                $fee_total += EH_Stripe_Payment::get_stripe_amount( $fee->get_total(), $currency );
            }
            $product['items'][] = array(
                'type'        => 'sku',
                'amount'      => $fee_total,
                'currency'    => $currency,
                'quantity'    => 1,
                'description' => __( 'Fee', 'payment-gateway-stripe-and-woocommerce-integration' ),
            );
        }
        // tax
        if ( 0 < $order->get_total_tax() ) {
            $product['items'][] = array(
                'type'        => 'tax',
                'amount'      => EH_Stripe_Payment::get_stripe_amount( $order->get_total_tax() ),
                'description' => __( 'Tax', 'payment-gateway-stripe-and-woocommerce-integration' ),
                'quantity'    => 1,
                'currency'    => $currency,
            );
        }
        
        $post_data['source_order']     = $product;

        $post_data['owner']    =  array();
        if ( ! empty( $phone ) ) {
            $post_data['owner']['phone'] = $phone;
        }

        $post_data['owner']['address']['line1']       = (WC()->version < '2.7.0') ? $order->billing_address_1  : $order->get_billing_address_1();
        $post_data['owner']['address']['line2']       = (WC()->version < '2.7.0') ? $order->billing_address_2  : $order->get_billing_address_2();
        $post_data['owner']['address']['state']       = (WC()->version < '2.7.0') ? $order->billing_state      : $order->get_billing_state();
        $post_data['owner']['address']['city']        = (WC()->version < '2.7.0') ? $order->billing_city       : $order->get_billing_city();
        $post_data['owner']['address']['postal_code'] = (WC()->version < '2.7.0') ? $order->billing_postcode   : $order->get_billing_postcode();
        $post_data['owner']['address']['country']     = $country;

         if ( ! empty( $email ) ) {
            $post_data['owner']['email'] = $email;
        }

       if ( ! empty( $billing_first_name ) ) {
            $post_data['klarna']['first_name'] = $billing_first_name;
        }
        if ( ! empty( $billing_last_name ) ) {
            $post_data['klarna']['last_name'] = $billing_last_name;
        }
        $post_data['klarna']['product']     = 'payment';
        $post_data['klarna']['purchase_country']     = $country;        
        $post_data['klarna']['locale']     = $this->store_locale(get_locale());        

        $post_data['flow']    = 'redirect';
        $post_data['redirect']['return_url'] = add_query_arg('order_id', $order_id, WC()->api_request_url('EH_Klarna_Gateway')) ;//$this->get_return_url($order); 

        $post_data['metadata'] = array('order_id' => $order_id);

        return apply_filters( 'eh_stripe_klarna_source', $post_data, $order );
    }

    /**
     *Process stripe payment.
     */
    public function process_payment($order_id) { 
                
        try{
            $order = wc_get_order( $order_id );
            $response = \Stripe\Source::create($this->eh_create_source( $order ));
            if (isset($response->error) && ! empty( $response->error ) ) {
                throw new Exception($response->error->message);
            }

            $obj_stripe = new EH_Stripe_Payment();

            if (isset($response->id) && !empty($response->id)) {
                $source_id = sanitize_text_field($response->id);
                 $source_status = sanitize_text_field($response->status);


                if ( version_compare(WC_VERSION, '2.7.0', '<') ) {
                    update_post_meta( $order_id, '_eh_klarna_source_id', $source_id );
                } else {
                    $order->update_meta_data( '_eh_klarna_source_id', $source_id );
                }
                $order->save();

                //check the status of source
                if ($source_status == 'chargeable') {                 
                    
                    // create charge
                    $charge_response = \Stripe\Charge::create($this->eh_make_charge_params( $order, $source_id), array(
                                'idempotency_key' => $order->get_order_key()
                            ));

                   return $this->eh_process_payment_response($charge_response, $order);

                }
                elseif ($source_status == 'pending') {
                    //check Redirect url is present to authorize payments
                    if (isset($response->klarna->payment_intents_redirect_url) && !empty($response->klarna->payment_intents_redirect_url)) {
                       
                       //redirect to Klarna domain to authorize payments 
                        return array(
                           'result'        => 'success',
                            'redirect'      => esc_url_raw($response->klarna->payment_intents_redirect_url),

                        );
                    }
                    else{
                        throw new Exception( __( 'Klarna payment URL not found.', 'payment-gateway-stripe-and-woocommerce-integration' ));
                    }
                    
                } 
                else{
                    throw new Exception( __( 'Unable to process this payment, please try again.' , 'payment-gateway-stripe-and-woocommerce-integration' ));
                }
            }
            else{

                throw new Exception( __( 'Unable to process this payment, please try again.', 'payment-gateway-stripe-and-woocommerce-integration' ));
            }

        }
        catch(Exception $e){
            $order->update_status( 'failed', sprintf( __( 'Klarna payment failed: %s', 'payment-gateway-stripe-and-woocommerce-integration' ),$e->getMessage() ) );
            
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

        if (isset($this->capture_now) && $this->capture_now == 'no') {
            $post_data['capture'] = false;
        }
        return apply_filters( 'eh_klarna_generate_charge_request', $post_data, $order, $source_id );
    }

    /**
     * Store extra meta data for an order and adds order notes for orders.
     */
    public function eh_process_payment_response( $response, $order, $force_redirect = false ) {
        
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
            update_post_meta( $order_id, '_eh_klarna_charge_captured', $captured );
        } else {
            $order->update_meta_data( '_eh_klarna_charge_captured', $captured );
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

            $order->update_status( 'on-hold', sprintf( __( 'Stripe Klarna order meta (Charge ID: %s). Process order to take payment, or cancel to remove the pre-authorization.', 'payment-gateway-stripe-and-woocommerce-integration' ), $response->id) );
        }

        if ($force_redirect) {
            wp_safe_redirect( $this->get_return_url($order) );
        }
        else{
            return array(
                    'result' => 'success',
                    'redirect' => $this->get_return_url($order),
                );
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


    public function eh_klarna_callback_handler() {
        //print_r($_REQUEST);exit;
           $order_id = (isset($_REQUEST['order_id']) && !empty($_REQUEST['order_id'])) ? $_REQUEST['order_id'] : '';
            $order = new WC_Order($order_id);
        try{ 

            if (isset($_REQUEST['source']) && !empty($_REQUEST['source'])) {
                $source_id = sanitize_text_field($_REQUEST['source']);
                if(isset($_REQUEST['redirect_status']) && !empty($_REQUEST['redirect_status'])){
                    if (strtolower($_REQUEST['redirect_status']) == 'succeeded') { 
                        //Retrieve source
                        $source_response = \Stripe\Source::retrieve($source_id);
                        $this->process_source_response($source_response, $order_id);
                    }
                    else{
                        throw new Exception(__(sprintf('Redirect status is %s', $_REQUEST['redirect_status']), "payment-gateway-stripe-and-woocommerce-integration"));
                        
                    }

                }
                else{
                    throw new Exception(__("Unknown redirect status.", "payment-gateway-stripe-and-woocommerce-integration"));
                }                          
            }
            else{
                throw new Exception(__("Source not found.", "payment-gateway-stripe-and-woocommerce-integration"));
            }


        }
        catch(Exception $e){
            $order->update_status( 'failed', sprintf( __( 'Klarna payment failed: %s', 'payment-gateway-stripe-and-woocommerce-integration' ),$e->getMessage() ) );

            wc_add_notice( sprintf( __( ' %s ', 'payment-gateway-stripe-and-woocommerce-integration' ), $e->getMessage()), 'error' );
            wp_safe_redirect( wc_get_checkout_url() );
        }


    }

    public function process_source_response($source_response, $order_id = null){
        if (!empty($source_response)) { 
            if (isset($source_response->error)) {
                throw new Exception($source_response->error->message);
            }
            else{ 
                if (isset($source_response->status) && !empty($source_response->status)) {
                    if ($source_response->status == 'chargeable') { 
                        $order = new WC_Order($order_id);
                        $charge_response = \Stripe\Charge::create($this->eh_make_charge_params( $order, $source_response->id), array(
                                'idempotency_key' => $order->get_order_key()
                            ));
                        return $this->eh_process_payment_response($charge_response, $order, true);

                    }
                    // case when source is on pending status
                    elseif ($source_response->status == 'pending') {
                        // Update order status to on-hold
                         $order = new WC_Order($order_id);

                        $order_stock_reduced = $order->get_meta( '_order_stock_reduced', true );
                        if ( ! $order_stock_reduced ) {
                            wc_reduce_stock_levels( $order_id );
                        }
                        $order->update_status( 'on-hold');
                        
                        $order_time = date('Y-m-d H:i:s', time() + get_option('gmt_offset') * 3600); 
                        $order->add_order_note( __('Payment Status : Charge not initiated', 'payment-gateway-stripe-and-woocommerce-integration')  .' [ ' . $order_time . ' ] . '  );

                        wp_safe_redirect( $this->get_return_url($order) );


                    }
                    elseif ('consumed' == $source_response->status) {
                        wc_add_notice(__('Your payment is already processed!!', 'payment-gateway-stripe-and-woocommerce-integration'));
                        wp_safe_redirect( $this->get_return_url($order) );
                    }                    
                    else{ 
                        throw new Exception(__(sprintf('Source status is %s', $source_response->status), "payment-gateway-stripe-and-woocommerce-integration"));
                    }
                }
                else{
                     throw new Exception(__("Source status is Unknown.", "payment-gateway-stripe-and-woocommerce-integration"));
                }
            }
        }
    }

     public function store_locale($locale) { 
        if (strpos( $locale, '_') !== false) { 
           $arr_locale = explode('_', $locale);
           $locale = $arr_locale[0] . '-' . strtoupper($arr_locale[1]);
        }
        $safe_locales = array(
            
        'de-AT',
        'fr-FR',
        'en-FR',
        'sv-FI',
        'en-IE',
        'es-US',
        'en-US',
        'en-AT',
        'en-SE',
        'da-DK',
        'de-CH',
        'fr-CH',
        'it-CH', 
        'en-CH',
        'en-DK',
        'en-GB',
        'fi-FI',
        'en-AU',
        'en-FI',
        'de-DE',
        'en-DE',
        'nl-NL',
        'en-NL',
        'en-NO',
        'nb-NO',
        'sv-SE',
        'nl-BE',
        'en-BE',
        'es-ES',
        'en-ES',
        'it-IT',
        'en-IT',
        'fr-BE'
        
        );
        if (!in_array($locale, $safe_locales)) { 
            $locale = 'en-US';
        } 
        return $locale;
    }

}