<?php
/*
Plugin Name: Custom Payment Gateway
Description: Custom Payment Gateway(COD)
* Version: 0.1
Author: Mahesh Barot
Author URI: https://acquaintsoft.com/
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* Below Hook Registers our PHP class as a WooCommerce payment gateway ***********************************************/
add_filter( 'woocommerce_payment_gateways', 'add_custom_gateway_php_class' );
function add_custom_gateway_php_class( $methods ) {
    $methods[] = 'WC_Gateway_PHP_Custom_class'; /*PHP Class For WC Gateway which is use Below*/
    return $methods;
}

/* Below Hook Plugin Loaded and WC extend Payment Gatway Class *******************************************************/
add_action('plugins_loaded', 'init_custom_gateway_class');
function init_custom_gateway_class(){

    class WC_Gateway_PHP_Custom_class extends WC_Payment_Gateway {  /* "WC_Gateway_PHP_Custom_class" is Above PHP Class Which is extend WC Payment class */

        public $woocommerce;

/* Constructor for the gateway. **************************************************************************************/
        public function __construct() {

            $this->woocommerce = 'custom_payment';

            $this->id                 = 'custom'; /*payment gateway plugin ID*/
            $this->icon               = '';
            $this->has_fields         = false;  /*In case we Need a Custom Credit Card Form*/
            $this->method_title       = __( 'Custom Payment Gatway(COD)', $this->woocommerce );
            $this->method_description = __( 'Allows payments with custom gateway(COD).', $this->woocommerce ); /* It will be Displayed on the options page*/

            /*Method with all the options fields.in Adimin */
            $this->init_form_fields();

            /*Load the settings.*/
            $this->init_settings();            
            $this->title        = $this->get_option( 'title' );
            $this->description  = $this->get_option( 'description' );
            $this->instructions = $this->get_option( 'instructions', $this->description );
            $this->order_status = $this->get_option( 'order_status', 'completed' );
            $this->custom_field_test = $this->get_option( 'custom_field_test', 'completed' );


            /* This action hook saves the settings */
            add_action('woocommerce_update_options_payment_gateways_' . $this->id,array($this,'process_admin_options'));/*process_admin_options is used For Saves Optios*/
            add_action('woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );

            // Customer Emails
            add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
           
        }
/* Initialise Gateway Settings Form Fields. **************************************************************************/        
        public function init_form_fields() {

            $this->form_fields = array(
                'enabled' => array(
                    'title'   => __( 'Enable/Disable', $this->woocommerce ),
                    'type'    => 'checkbox',
                    'label'   => __( 'Enable Custom Payment', $this->woocommerce ),
                    'default' => 'yes'
                ),
                'title' => array(
                    'title'       => __( 'Title', $this->woocommerce ),
                    'type'        => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', $this->woocommerce ),
                    'default'     => __( 'Custom Payment', $this->woocommerce ),
                    'desc_tip'    => true,
                ),
                'order_status' => array(
                    'title'       => __( 'Order Status', $this->woocommerce ),
                    'type'        => 'select',
                    'class'       => 'wc-enhanced-select',
                    'description' => __( 'Choose whether status you wish after checkout.', $this->woocommerce ),
                    'default'     => 'wc-completed',
                    'desc_tip'    => true,
                    'options'     => wc_get_order_statuses()
                ),
                'description' => array(
                    'title'       => __( 'Description', $this->woocommerce ),
                    'type'        => 'textarea',
                    'description' => __( 'Payment method description that the customer will see on your checkout.', $this->woocommerce ),
                    'default'     => __('Payment Information', $this->woocommerce),
                    'desc_tip'    => true,
                ),
                'instructions' => array(
                    'title'       => __( 'Instructions', $this->woocommerce ),
                    'type'        => 'textarea',
                    'description' => __( 'Instructions that will be added to the thank you page and emails.', $this->woocommerce ),
                    'default'     => '',
                    'desc_tip'    => true,
                ),
                'enable_for_virtual' => array(
                    'title'   => __( 'Accept for virtual orders', 'woocommerce' ),
                    'label'   => __( 'Accept COD if the order is virtual', 'woocommerce' ),
                    'type'    => 'checkbox',
                    'default' => 'yes',
                  ),
                 'custom_field_test' => array(
                    'title'   => __( 'Testing Field', 'woocommerce' ),
                    'label'   => __( 'Accept COD if the order is virtual', 'woocommerce' ),
                    'type'    => 'text',
                    'default' => 'yes',
                  ),
            );
        }
/* Here We can Add Payment Scripts payment_scripts() . ***************************************************************/     
        public function payment_scripts() {
        }
/* Here We can Add Credit or Debit Card Payment Fields or Custom Fields like Number,name etc *************************/       
        public function payment_fields() {
            if ( $description = $this->get_description() ) {
                echo wpautop( wptexturize( $description ) );
            }
            ?>
            <div id="custom_input">
                <p class="form-row form-row-wide">
                    <label for="mobile" class=""><?php _e('Mobile Number', $this->domain); ?></label>
                    <input type="text" class="" name="mobile" id="mobile" placeholder="" value="">
                </p>
                <p class="form-row form-row-wide">
                    <label for="transaction" class=""><?php _e('Transaction ID', $this->domain); ?></label>
                    <input type="text" class="" name="transaction" id="transaction" placeholder="Transaction" value="">
                </p>
            </div>
            <?php
        }
/* Here Validate Fields. ************************************************************************************/   
        public function validate_fields(){
            if( empty( $_POST[ 'mobile' ])){
                wc_add_notice('Please Enter Your Number!', 'error' );
                return false;
            }
            if( empty( $_POST[ 'transaction' ])){
                wc_add_notice('Please Enter Your Number!', 'error' );
                return false;
            }
            return true;    
        }

/* Here Output for the order received page. **************************************************************************/        
        public function thankyou_page() {
            if ( $this->instructions ){
                echo wpautop( wptexturize( $this->instructions ) );
                echo "<b>Thank You For Buy this Product</b>";
            }
        }

        public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
            if ( $this->instructions && ! $sent_to_admin && 'custom' === $order->payment_method && $order->has_status( 'on-hold' ) ) {
                echo wpautop( wptexturize( $this->instructions ) ) . PHP_EOL;
            }
        }

/* Here The Payment Process Will happen.Process the payment and return the result ***********************************/          
        public function process_payment( $order_id ) {

            $order = wc_get_order( $order_id );

            $order_note  = 'This will add as a Customer note.';
            $order_note1 = 'This will add as a private note.';
            $order->add_order_note( $order_note ); // This will add as a private note.
            $order->add_order_note( $order_note1, 1 );
               

            $status = 'wc-' === substr( $this->order_status, 0, 3 ) ? substr( $this->order_status, 3 ) : $this->order_status;

            // Set order status
            $order->update_status( $status, __( 'Checkout with custom payment. ', $this->woocommerce ) );

          //  $order->payment_complete();
          

            // Reduce stock levels
            $order->reduce_order_stock();

            // Remove cart
            WC()->cart->empty_cart();

            // Return thankyou redirect
            return array(
                'result'    => 'success',
                'redirect'  => $this->get_return_url( $order )
            );
        }
        
    }
}

/* Here Update the order meta with field value************************* ***********************************/
add_action( 'woocommerce_checkout_update_order_meta', 'custom_payment_update_order_meta' );
function custom_payment_update_order_meta( $order_id ) {

    update_post_meta( $order_id, 'mobile', $_POST['mobile'] );
    update_post_meta( $order_id, 'transaction', $_POST['transaction'] );
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'custom_checkout_field_display_admin_order_meta', 10, 1 );
function custom_checkout_field_display_admin_order_meta($order){
    $method = get_post_meta( $order->id, '_payment_method', true );
    if($method != 'custom')
        return;

    $mobile = get_post_meta( $order->id, 'mobile', true );
    $transaction = get_post_meta( $order->id, 'transaction', true );

    echo '<p><strong>'.__( 'Mobile Number' ).':</strong> ' . $mobile . '</p>';
    echo '<p><strong>'.__( 'Transaction ID').':</strong> ' . $transaction . '</p>';
}

