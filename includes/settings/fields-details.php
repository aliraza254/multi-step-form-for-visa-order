<?php

function visa_order_csv_details() {

    add_settings_field(
        'visa_order_csv_file',
        __( 'Form Link', 'visa_order' ),
        'visa_order_csv_file_cb',
        'visa_order',
        'visa_order_design_styling',
        array(
            'label_for'             => 'visa_order_csv_file',
            'class'                 => 'visa_order_row',
            'visa_order_custom_data' => 'custom',
        )
    );
}

function visa_order_csv_file_cb( $args ) {
    $options = get_option( 'visa_order_options' );
    $selected_value = isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : '';
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="visa_order_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="">Select Page</option>
        <?php
        $args_page = array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $pages = get_pages( $args_page );
        foreach ( $pages as $single ) {
            ?>
            <option value="<?php echo $single->ID; ?>" <?php selected( $selected_value, $single->ID ); ?>>
                <?php echo $single->post_title; ?>
            </option>
            <?php
        }
        ?>
    </select>
    <p class="description">
        <?php esc_html_e( 'Add Form URL.', 'visa_order' ); ?>
    </p>
    <?php
}
