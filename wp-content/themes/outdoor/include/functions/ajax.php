<?php
/***************************************************************************************
 * Get portfolio item info
 **************************************************************************************/
function outdoor_portfolio_item() {
    $portfolio_id = ( isset( $_POST['item_id'] ) ) ? intval( $_POST['item_id'] ) : false;

    if( !$portfolio_id ) {
        echo -1;exit();
    }

    $return_data = array();
    $portfolio = get_post( $portfolio_id );
    if( $portfolio ) {
        $return_data['title']       = $portfolio->post_title;
        $return_data['description'] = $portfolio->post_content;

        $portf_cats         = wp_get_post_terms( $portfolio->ID, 'portfolio-category', array( 'fields' => 'names' ) );
        $portf_cats_str     = ( is_array( $portf_cats ) ) ? implode( ', ', $portf_cats ) : '';
        $portf_cats_str     = trim( $portf_cats_str, ',' );
        $return_data['category']    = $portf_cats_str;

        $client     = ( get_field( 'client', $portfolio_id ) )  ? get_field( 'client', $portfolio_id ) : '';
        $link       = ( get_field( 'link', $portfolio_id ) )    ? get_field( 'link', $portfolio_id ) : '';
        $gallery    = ( get_field( 'gallery', $portfolio_id ) ) ? get_field( 'gallery', $portfolio_id ) : '';
        $return_data['client']      = $client;
        $return_data['url']         = $link;

        foreach( $gallery as $photo ) {
            $return_data['photos'][] = $photo['url'];
        }
    }

    echo wp_json_encode( $return_data, JSON_FORCE_OBJECT );exit();
}
add_action( 'wp_ajax_outdoor_portfolio_item', 'outdoor_portfolio_item' );
add_action( 'wp_ajax_nopriv_outdoor_portfolio_item', 'outdoor_portfolio_item' );

/***************************************************************************************
 * Send the contact form
 **************************************************************************************/
function outdoor_send_contact_form() {
    global $outdoor_opt;

    $email_to   = ( isset( $outdoor_opt['od-send-email'] ) ) ? $outdoor_opt['od-send-email'] : '';
    $form_args = wp_parse_args( $_POST['args'] );

    if( ! $email_to || ! $form_args || ( ! isset( $form_args['outdoor_contact_form_nonce'] ) &&
        ! wp_verify_nonce( $form_args['outdoor_contact_form_nonce'], 'outdoor_contact_form' ) ) ) {
        echo wp_json_encode( array(
            'status'    => 'fail',
            'error'     => 'Error send contact form!'
        ) );exit();
    }

    $name       = sanitize_text_field( $form_args['uname'] );
    $email      = sanitize_email( $form_args['email'] );
    $comment    = sanitize_text_field( $form_args['comment'] );

    $subject    = 'New message from ' . $name . "\n";
    $body_text  = 'Name: ' . $name . "\n";
    $body_text .= 'Email: ' . $email . "\n\n";
    $body_text .= 'Message: ' . $comment;

    if( wp_mail( $email_to, $subject, $body_text ) ) {
        echo wp_json_encode( array(
            'status'    => 'success',
            'text'      => __( 'Your message is sent! Thanks!', 'outdoor' )
        ) );exit();
    } else {
        echo wp_json_encode( array(
            'status'    => 'fail',
            'error'     => 'Error wp_mail()'
        ) );exit();
    }

}
add_action( 'wp_ajax_outdoor_send_contact_form', 'outdoor_send_contact_form' );
add_action( 'wp_ajax_nopriv_outdoor_send_contact_form', 'outdoor_send_contact_form' );

/***************************************************************************************
 * Newsletter form
 **************************************************************************************/
function outdoor_newsletter_form() {
    global $wpdb, $outdoor_opt;

    $form_args  = wp_parse_args( $_POST['args'] );
    $email      = sanitize_email( $form_args['newsletters-email'] );

    if( !is_email( $email ) ) {
        echo wp_json_encode( array(
            'status'    => 'fail',
            'error'     => __( 'Invalid email address!', 'outdoor' )
        ) );exit();
    }

    // If MailChimp integration enable
    if( isset( $outdoor_opt['od-mailchimp-enable'] ) && $outdoor_opt['od-mailchimp-enable'] == true ) {

        $mc_key     = ( isset( $outdoor_opt['od-mailchimp-key'] ) )     ? $outdoor_opt['od-mailchimp-key'] : '';
        $mc_listid  = ( isset( $outdoor_opt['od-mailchimp-listid'] ) )  ? $outdoor_opt['od-mailchimp-listid'] : '';

        if( '' != $mc_key && '' != $mc_listid ) {

            $api = new MCAPI( $mc_key );

            if( $api->listSubscribe( $mc_listid , $email) !== true ) {

                if( $api->errorCode == 214 ) {
                    echo wp_json_encode( array(
                        'status'    => 'fail',
                        'error'     => __( 'MailChimp error: Email already exists!', 'outdoor' )
                    ) );exit();
                } else {
                    echo wp_json_encode( array(
                        'status'    => 'fail',
                        'error'     => 'MailChimp error: #' .$api->errorCode . ' ' . $api->errorMessage
                    ) );exit();
                }

            } else {
                echo wp_json_encode( array(
                    'status'    => 'success',
                    'text'      => __( 'MailChimp: You have successfully subscribed! Thanks!', 'outdoor' )
                ) );exit();
            }

        } else {
            echo wp_json_encode( array(
                'status'    => 'fail',
                'error'     => __( 'MailChimp error: invalid api key or list id', 'outdoor' )
            ) );exit();
        }

    } else {

        $exists_email = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $wpdb->od_subscribers WHERE email='%s'", $email ));

        if( (int) $exists_email > 0 ) {
            echo wp_json_encode( array(
                'status'    => 'fail',
                'error'     => __( 'Email already exists!', 'outdoor' )
            ) );exit();
        } else {
            $new_subscriber = $wpdb->insert(
                $wpdb->od_subscribers,
                array( 'email' => $email ),
                array( '%s' )
            );

            if( (int) $new_subscriber == 1 ) {
                echo wp_json_encode( array(
                    'status'    => 'success',
                    'text'      => __( 'You have successfully subscribed! Thanks!', 'outdoor' )
                ) );exit();
            } else {
                echo wp_json_encode( array(
                    'status'    => 'fail',
                    'error'     => __( 'Error, please contact administrator!', 'outdoor' )
                ) );exit();
            }
        }

    }
}
add_action( 'wp_ajax_outdoor_newsletter_form', 'outdoor_newsletter_form' );
add_action( 'wp_ajax_nopriv_outdoor_newsletter_form', 'outdoor_newsletter_form' );

/***************************************************************************************
 * Add new subscriber
 **************************************************************************************/
function outdoor_add_subscriber() {
    global $wpdb;
    $email = sanitize_email( $_POST['email'] );

    if( !is_email( $email ) ) {
        echo wp_json_encode( array(
            'status'    => 'fail',
            'error'     => __( 'Invalid email address!', 'outdoor' )
        ) );exit();
    }

    $exists_email = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $wpdb->od_subscribers WHERE email='%s'", $email ));

    if( (int) $exists_email > 0 ) {
        echo wp_json_encode( array(
            'status'    => 'fail',
            'error'     => __( 'Email already exists!', 'outdoor' )
        ) );exit();
    } else {

        $new_subscriber = $wpdb->insert(
            $wpdb->od_subscribers,
            array( 'email' => $email ),
            array( '%s' )
        );

        if( (int) $new_subscriber == 1 ) {
            echo wp_json_encode( array(
                'status'    => 'success',
                'text'      => __( 'Error subscribe!', 'outdoor' ),
                'data'      => array(
                    'id'    => $wpdb->insert_id,
                    'email' => $email
                )
            ) );exit();
        }

    }
}
add_action( 'wp_ajax_outdoor_add_subscriber', 'outdoor_add_subscriber' );

/***************************************************************************************
 * Remove all subscribers
 **************************************************************************************/
function outdoor_remove_subscribers() {
    global $wpdb;

    $deleted = $wpdb->query("DELETE FROM $wpdb->od_subscribers");

    if( $deleted ) {
        echo wp_json_encode( array(
            'status'    => 'success',
            'error'     => __( 'Subscribers removed successful', 'outdoor' )
        ) );exit();
    }

    echo wp_json_encode( array(
        'status'    => 'fail',
        'error'     => __( 'Subscribers remove is fail', 'outdoor' )
    ) );exit();
}
add_action( 'wp_ajax_outdoor_remove_subscribers', 'outdoor_remove_subscribers' );