<?php
// Email verificatioon
if( isset( $_GET['verification_key'] ) && $_GET['verification_key'] != "" && !is_user_logged_in()  )
{
    $token  = $_GET['verification_key'];
    $token_url  =   explode( '-exertio-uid-', $token );
    $key    =   $token_url[0];
    $uid    =   $token_url[1];
    $token_db   =   get_user_meta( $uid, 'sb_email_verification_token', true );
    if( $token_db != $key )
    {
        echo '1|' .__( 'Invalid security token', 'exertio_framework' );
        die;
    }
    else
    {
        echo '0|' .__( 'Your account has been verified.', 'exertio_framework' );
        update_user_meta($uid, 'sb_email_verification_token', '');
        update_user_meta($uid, 'is_email_verified', 1 );

        // Set the user's role (and implicitly remove the previous role).
        $user = new WP_User( $uid );
        $user->set_role( 'subscriber' );
    }
}