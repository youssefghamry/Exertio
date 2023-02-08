<?php
// Hooks near the bottom of profile page (if current user) 
add_action('show_user_profile', 'custom_user_profile_fields');

// Hooks near the bottom of the profile page (if not current user) 
add_action('edit_user_profile', 'custom_user_profile_fields');

// @param WP_User $user
function custom_user_profile_fields( $user ) {
	$wallet_amount = get_user_meta( $user->ID, '_fl_wallet_amount', true );
?>
    <table class="form-table">
        <tr>
            <th>
                <label for="code"><?php echo __( 'Total Money in User Wallet', 'exertio_framework' ); ?></label>
            </th>
            <td>
                <input type="number" name="wallet_amount" id="code" value="<?php echo esc_attr($wallet_amount); ?>" class="regular-text" /> <span> <?php echo fl_price_separator($wallet_amount); ?></span>
				<p><?php echo __( 'Provide amount without decimal and please be careful while changing the amount as it will reflect in the user wallet right away.', 'exertio_framework' ); ?></p>
            </td>
        </tr>
    </table>
<?php
}
// Hook is used to save custom fields that have been added to the WordPress profile page (if current user) 
add_action( 'personal_options_update', 'update_extra_profile_fields' );

// Hook is used to save custom fields that have been added to the WordPress profile page (if not current user) 
add_action( 'edit_user_profile_update', 'update_extra_profile_fields' );

function update_extra_profile_fields( $user_id ) {
    if ( current_user_can( 'edit_user', $user_id ) )
        update_user_meta( $user_id, '_fl_wallet_amount', $_POST['wallet_amount'] );
}