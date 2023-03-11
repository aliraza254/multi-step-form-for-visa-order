<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://webtechsofts.com/
 * @since      1.0.0
 *
 * @package    Visa_Order
 * @subpackage Visa_Order/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Visa_Order
 * @subpackage Visa_Order/admin
 * @author     Web Tech Softs <info@webtechsofts.com>
 */
class Visa_Order_ShortCode {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Visa_Order_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Visa_Order_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/visa-order-public.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Visa_Order_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Visa_Order_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/visa-order-public.js', array( 'jquery' ), $this->version, false );

    }

    public function all_products_list_function( ) {

        $args = array(
            'status'            => array( 'draft', 'pending', 'private', 'publish' ),
            'type'              => array_merge( array_keys( wc_get_product_types() ) ),
            'parent'            => null,
            'sku'               => '',
            'category'          => array(),
            'tag'               => array(),
            'limit'             => get_option( 'posts_per_page' ),  // -1 for unlimited
            'offset'            => null,
            'page'              => 1,
            'include'           => array(),
            'exclude'           => array(),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'return'            => 'objects',
            'paginate'          => false,
            'shipping_class'    => array(),
        );
        $products = wc_get_products( $args );
        ?>
            <div class="sb_product_list_main">
                <div style="width: 100%">
                    <select class="sb_product_list_option">
                        <option>Select Products</option>
                        <?php
                        foreach( $products as $product ) {
                            $product_id = $product->get_id();
                            $product_name = $product->get_name();
                            ?>
                            <option value="<?php echo $product_id;?>" name="product_id" <?php if ($product_name == $product_id) echo "selected"; ?>><?php echo $product_name;?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="sb_product_list_btn">
                    <a href="<?php echo get_permalink(get_option( 'visa_order_options' )[0])?>">APPLY NOW</a>
                </div>
            </div>
        <?php
    }

    public function multi_step_form_function(){
        ?>
        <form class="wts_regForm cart" id="regForm" method="post" action="<?php echo get_home_url()?>?page_id=649" enctype="multipart/form-data">
            <input type="hidden" name="action" value="sb_add_product_in_cart">
            <input type="hidden" class="qty sb_qty" name="quantity" value="1" >
            <input type="hidden" name="pro_id" value="<?php echo (isset($_GET['pro_id'])) ? $_GET['pro_id'] : ''; ?>">
            <div class="tab_parent" id="tab_parent_1">
                <div class="d-flex-content">
                    <p class="width-mar"><input placeholder="First name" name="fname" class="sb_required"></p>
                    <p class="width-mar"><input placeholder="Last name" name="lname" class="sb_required"></p>
                </div>
                <div class="d-flex-content">
                    <p class="width-mar"><input placeholder="Nationality" name="nationality" class="sb_required"></p>
                    <p class="width-mar"><input placeholder="Contact Number" name="contact_number" class="sb_required"></p>
                </div>
                <div class="d-flex-content">
                    <p class="width-mar"><input placeholder="E-mail " name="email" class="sb_required"></p>
                </div>
                <div style="overflow:auto;">
                    <div style="display: flex; justify-content: center">
                        <button type="button" id="nextBtn" class="next_step" data-next="tab_parent_2">Next ></button>
                    </div>
                </div>
            </div>
            <div class="tab_parent" id="tab_parent_2" style="display:none;">
                <div id="wts_passenger_added">
                    <div class="wts_passenger">
                        <label>Passenger 1:</label>
                        <div class="d-flex-content">
                            <p class="width-mar"><input type="text" placeholder="First Name" name="first_name_p1" class="sb_required"></p>
                            <p class="width-mar"><input type="text" placeholder="Last Name" name="last_name_p1" class="sb_required"></p>
                        </div>
                        <div class="d-flex-content">
                            <p class="width-mar"><input type="date" name="dob_p1" class="sb_required"></p>
                            <p class="width-mar"><input type="text" placeholder="Passport Number" name="pass_num_p1" class="sb_required"></p>
                        </div>
                        <div class="d-flex-content">
                            <p class="width-mar"><input type="date" name="pass_issue_p1" class="sb_required"></p>
                            <p class="width-mar"><input type="date" name="pass_ex_p1" class="sb_required"></p>
                        </div>
                        <div class="d-flex-content">
                            <p  class="width-mar"><input type="file" name="passport_p1" class="sb_required"></p>
                            <p class="width-mar"><input type="file" name="profile_p1" class="sb_required"></p>
                        </div>
                        <input type="hidden" name="passenger_count[]" />
                    </div>
                </div>
                <div>
                    <a id="add_passenger" class="add_passenger_btn" >Add Passenger</a>
                    <button type="button" id="prevBtn" class="prev_step" data-prev="tab_parent_1">Previous</button>
                    <button type="submit" name="add-to-cart" data-next="submit" value="<?php echo (isset($_GET['pro_id'])) ? $_GET['pro_id'] : '651'; ?>" class=" next_step button alt">Submit</button>
                </div>
            </div>
        </form>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" "></script>
        <script>
            $(document).find(".next_step").click(function(e){
                e.stopPropagation();
                $('.sb_required').css('border', '1px solid #30c7b5');
                var valid = 1;
                $(this).closest('.tab_parent').find('.sb_required').each(function (){
                    if($(this).val() == ''){
                        $(this).css('border', '1px solid red');
                        valid = 0;
                    }
                });
                var id = $(this).attr('data-next');
                if(valid == 1){
                    if(id == 'submit'){
                        // $(this).closest('form').submit();
                        $(this).removeClass('next_step');
                        $(this).addClass('single_add_to_cart_button');
                        $(document).find('.single_add_to_cart_button').trigger('click');
                    }
                    else{
                        $('.tab_parent').hide();
                        $('#'+id).show();
                    }
                }
                else{
                    return false;
                }
            });
            $(document).find(".prev_step").click(function(e){
                var id = $(this).attr('data-prev');
                $('.tab_parent').hide();
                $('#'+id).show();
            });
            $("#add_passenger").click(function(e){
                e.preventDefault();
                var count = $('.wts_passenger').length;
                $(document).find('.sb_qty').val(count);
                count = parseInt(count) + parseInt(1);
                $("#wts_passenger_added").append('<div class="wts_passenger"><label>Passenger '+ count +`:</label>
		<div class="d-flex-content">
			<p class="width-mar"><input type="text" placeholder="First name" name="first_name_p`+ count +`" required></p>
			<p class="width-mar"><input type="text" placeholder="Last name" name="last_name_p`+ count +`" required></p>
		</div>
		<div class="d-flex-content">
			<p class="width-mar"><input type="date"  name="dob_p`+ count +`" required></p>
			<p class="width-mar"><input type="text" placeholder="Passport Number" name="pass_num_p`+ count +`" required></p>
		</div>
		<div class="d-flex-content">
			<p class="width-mar"><input type="date" name="pass_issue_p`+ count +`" required></p>
			<p class="width-mar"><input type="date" name="pass_ex_p`+ count +`" required></p>
		</div>
		<div class="d-flex-content">
			<p class="width-mar"><input type="file" name="passport_p`+ count +`" required></p>
			<p class="width-mar"><input type="file" name="profile_p`+ count +`" required></p>
		</div>
		<input type="hidden" name="passenger_count[]" /> </div>`);
            });
        </script>
        <?php
    }

    public function sb_add_product_in_cart(){
        $pro_id = (isset($_POST['pro_id'])) ? $_POST['pro_id'] : 651;
        echo $pro_id;
        die();
        $customer_details['fname'] = $_POST['fname'];
        $customer_details['lname'] = $_POST['lname'];
        $customer_details['nationality'] = $_POST['nationality'];
        $customer_details['contact_number'] = $_POST['contact_number'];
        $customer_details['email'] = $_POST['email'];
        $p_count = count($_POST['passenger_count']);
        $passengers = [];
        for ($i = 1; $i <= $p_count; $i++){
            $passengers[$i]['first_name'] = $_POST['first_name_p'.$i];
            $passengers[$i]['last_name'] = $_POST['last_name_p'.$i];
            $passengers[$i]['dob'] = $_POST['dob_p'.$i];
            $passengers[$i]['pass_num'] = $_POST['pass_num_p'.$i];
            $passengers[$i]['pass_issue'] = $_POST['pass_issue_p'.$i];
            $passengers[$i]['pass_ex'] = $_POST['pass_ex_p'.$i];
//            $passengers[$i]['passport'] = $this->sb_upload_files('passport_p'.$i);
//            $passengers[$i]['profile'] = $this->sb_upload_files('profile_p'.$i);
        }
        $customer_details['passengers'] = $passengers;

    }

    public function sb_upload_files($file){
        $file_name = $_FILES[$file]['name'];
        $file_temp = $_FILES[$file]['tmp_name'];
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents( $file_temp );
        $filename = basename( $file_name );
        $filetype = wp_check_filetype($file_name);
        $filename = time().'.'.$filetype['ext'];
        if ( wp_mkdir_p( $upload_dir['path'] ) ) {
            $file = $upload_dir['path'] . '/' . $filename;
        }
        else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }
        file_put_contents( $file, $image_data );
        $wp_filetype = wp_check_filetype( $filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name( $filename ),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $file );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        return $attach_id;
    }

    public function woocommerce_add_item_data_function($cart_item_data,$product_id){
        $cart_data['fname'] = ['First name', $_POST['fname']];
        $cart_data['lname'] = ['Last name', $_POST['lname']];
        $cart_data['nationality'] = ['Nationality', $_POST['nationality']];
        $cart_data['contact_number'] = ['Contact Number', $_POST['contact_number']];
        $cart_data['email'] = ['Email', $_POST['email']];
        $p_count = count($_POST['passenger_count']);
        $passengers = [];
        for ($i = 1; $i <= $p_count; $i++){
            $passengers[$i]['first_name'] = ['First Name', $_POST['first_name_p'.$i]];
            $passengers[$i]['last_name'] = ['Last Name', $_POST['last_name_p'.$i]];
            $passengers[$i]['dob'] = ['Date of Birth', $_POST['dob_p'.$i]];
            $passengers[$i]['pass_num'] = ['Passport Number', $_POST['pass_num_p'.$i]];
            $passengers[$i]['pass_issue'] = ['Passport Issue date', $_POST['pass_issue_p'.$i]];
            $passengers[$i]['pass_ex'] = ['Passport expiry date', $_POST['pass_ex_p'.$i]];
            $passengers[$i]['passport'] = $this->sb_upload_files('passport_p'.$i);
            $passengers[$i]['profile'] = $this->sb_upload_files('profile_p'.$i);
        }
        $cart_data['passengers'] = $passengers;
        $cart_item_data['customer_details'] = $cart_data;
        return $cart_item_data;
    }
    public function woocommerce_get_item_data_function( $item_data, $cart_item){
        $count = 1;
        if ( isset($cart_item['customer_details'])) {
            foreach ($cart_item['customer_details'] as $key => $single){
                if($key == 'passengers'){
                    foreach ($cart_item['customer_details']['passengers'] as $passenger){
                        $msg = '<br />'.$passenger['first_name'][0].': '.$passenger['first_name'][1].'<br />'.
                            $passenger['last_name'][0].': '.$passenger['last_name'][1].'<br />'.
                                $passenger['dob'][0].': '.$passenger['dob'][1].'<br />'.
                                $passenger['pass_num'][0].': '.$passenger['pass_num'][1].'<br />'.
                                $passenger['pass_issue'][0].': '.$passenger['pass_issue'][1].'<br />'.
                                $passenger['pass_ex'][0].': '.$passenger['pass_ex'][1].'<br />'.
                                'Passport : <a href="'.wp_get_attachment_url($passenger['passport']).'" target="_blank">View</a><br />'.
                                'Profile : <a href="'.wp_get_attachment_url($passenger['profile']).'" target="_blank">View</a><br />';
                        $item_data[] = array(
                            'key' => 'Passenger '.$count.' Details',
                            'value' => $msg,
                        );
                        $count++;
                    }
                }
                else {
                    $item_data[] = array(
                        'key' => $single[0],
                        'value' => $single[1],
                    );
                }
            }
        }
        return $item_data;
    }
    public function woocommerce_checkout_create_order_line_item_function( $item, $cart_item_key, $values, $orders){
        $count = 1;
        if ( isset($values['customer_details'])) {
            foreach ($values['customer_details'] as $key => $single){
                if($key == 'passengers'){
                    foreach ($values['customer_details']['passengers'] as $passenger){
                        $msg = '<br />'.$passenger['first_name'][0].': '.$passenger['first_name'][1].'<br />'.
                            $passenger['last_name'][0].': '.$passenger['last_name'][1].'<br />'.
                            $passenger['dob'][0].': '.$passenger['dob'][1].'<br />'.
                            $passenger['pass_num'][0].': '.$passenger['pass_num'][1].'<br />'.
                            $passenger['pass_issue'][0].': '.$passenger['pass_issue'][1].'<br />'.
                            $passenger['pass_ex'][0].': '.$passenger['pass_ex'][1].'<br />'.
                            'Passport : <a href="'.wp_get_attachment_url($passenger['passport']).'" target="_blank">View</a><br />'.
                            'Profile : <a href="'.wp_get_attachment_url($passenger['profile']).'" target="_blank">View</a><br />';
                        $item->update_meta_data( 'Passenger '.$count.' Details', $msg );
                        $count++;
                    }
                }
                else {
                    $item->update_meta_data( $single[0], $single[1] );
                }
            }
        }
    }
    public function woocommerce_add_to_cart_redirect_function( $url ){
        return wc_get_checkout_url();
    }
    public function woocommerce_add_to_cart_validation_function( $passed ){
        if( ! WC()->cart->is_empty() )
            WC()->cart->empty_cart();
        return $passed;
    }
    public function wp_footer_function(){
        ?>
        <script>
            jQuery(document).ready(function ($){
                var url = "<?php echo get_permalink(get_option( 'visa_order_options' )[0])?>";
                $('.sb_product_list_option').change(function (){
                    var val = $(this).val();
                    $('.sb_product_list_btn a').attr('href', url+'&pro_id='+val);
                })
            });
        </script>
        <?php
    }
}
