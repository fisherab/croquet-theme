# WordPress theme for croquet

It provides a users.php to list members

It provides improved security for wp-members via functions in functions.php

While wp-members allows users to request as password reset and enter a very weak password each time a that a new version is installed the following change must be made. Find wp-members/includes/class-wp-members-pwd-reset.php and find near line 160 the lines:

    /** This action is documented in wp-login.php */
    // do_action( 'validate_password_reset', $errors, $user );

and replace them with:

    /** This action is documented in wp-login.php */
    if (! $errors->has_errors()) {
        do_action( 'wpmem_validate_password_reset', $errors, $user, $pass1);
        if ($errors->has_errors()) {
            $result = 'pwdchangerr';
            $msg = '<div class="wpmem_msg" align="center"><p>' . $errors->get_error_message() . '<br /><br />Please try again.</p></div>';
        }
    }
