<?php
function croquet_enqueue_styles() {

    $parent_style = 'twentyseventeen-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.0.6/css/all.css'); 
}
add_action( 'wp_enqueue_scripts', 'croquet_enqueue_styles' );

function mucd_primary_table_to_copy($primary_tables) {
    $primary_tables[] = 'masterslider_sliders';
    $primary_tables[] = 'masterslider_options';
    return $primary_tables;
}

add_filter('mucd_default_primary_tables_to_copy', 'mucd_primary_table_to_copy');

function croquet_subdirectory_install() {
    return true;
}
add_filter( 'allow_subdirectory_install', 'croquet_subdirector_install');

add_theme_support( 'sportspress' );

function write_log($log) {
    if (! defined('WP_DEBUG')) return; 
    if (is_array($log) || is_object($log)){
        error_log(print_r($log,true));
    } else {
        error_log($log);
    }
}

add_filter('wpmem_pwd_change_error', 'croquet_reset_password',10,3);

add_filter( 'wpmem_pre_register_data', 'croquet_weak_password' );

add_filter( 'wpmem_pre_update_data', 'croquet_weak_password' );

add_filter('wpmem_msg_dialog', 'croquet_bad_pw_dialog', 10, 2);

add_filter('wpmem_validate_password_reset', 'croquet_validate_password_reset',10,3);

function croquet_password_check($user,$pass,$min_length,$min_char_type) { 

    $lc_pass = strtolower($pass);
    $denum_pass = strtr($lc_pass,'5301!','seoll');
    $lc_user = strtolower($user);

    if (strlen($pass) < $min_length) { 
        return 'The password must have at least ' . $min_length . ' characters.';
    } 

    if (($lc_pass == $lc_user) || ($lc_pass == strrev($lc_user)) || ($denum_pass == $lc_user)
        || ($denum_pass == strrev($lc_user))) { 
            return 'The password is based on the username.';
        } 

    $uc = 0;
    $lc = 0;
    $num = 0;
    $other = 0;
    for ($i = 0, $j = strlen($pass); $i < $j; $i++) { 
        $c = substr($pass,$i,1);
        if (preg_match('/^[[:upper:]]$/',$c)) { 
            $uc++;
        } elseif (preg_match('/^[[:lower:]]$/',$c)) { 
            $lc++;
        } elseif (preg_match('/^[[:digit:]]$/',$c)) { 
            $num++;
        } else { 
            $other++;
        } 
    } 

    if ($uc < $min_char_type) { 
        return "The password must have at least " . $min_char_type . " upper case letters.";
    } 
    if ($lc < $min_char_type) { 
        return "The password must have at least " . $min_char_type . " lower case letters.";
    } 
    if ($num < $min_char_type) { 
        return "The password must have at least " . $min_char_type . " numbers.";
    } 
    if ($other < $min_char_type) { 
        return "The password must have at least " . $min_char_type . " special characters.";
    } 

    return false;
}

function croquet_weak_password( $fields ) {
    global $wpmem_themsg;
    write_log($fields);    
    if (array_key_exists('password', $fields)) { 
        $user=$fields['username'];
        $pass=$fields['password'];
        if ($err = croquet_password_check($user, $pass, 6, 1)) {
            $wpmem_themsg = $err;
        }
    }
    return $fields;
}

function croquet_reset_password($is_error, $user_ID, $pass) {
    write_log([$is_error, $user_ID, $pass]);
    if (! $is_error) {
        $user = get_user_by('ID', $user_ID)->user_login;
        write_log($user);
        if ($err = croquet_password_check($user, $pass, 6, 1)) {
            $is_error = 'pwdchangerr';
            global $croquet_pw_error;
            $croquet_pw_error = $err;
            write_log($err);
        }
    }
    return $is_error;
}

function croquet_bad_pw_dialog($str, $tag) {
    write_log([$str, $tag]);
    if ($tag === 'pwdchangerr') {
        global $croquet_pw_error;
        if (isset($croquet_pw_error)) {
            $str = '<div class="wpmem_msg" align="center"><p>' . $croquet_pw_error . '<br /><br />Please try again.</p></div>';
            $croquet_pw_error = null;
        }
    }
    return $str;
}

function croquet_validate_password_reset($errors, $user, $pass) {
    write_log([$errors,$user->user_login, $pass]);
    if ($err = croquet_password_check($user->user_login, $pass, 6, 1)) {
        $errors->add('password_reset_mismatch',$err);
        write_log($err);
    }
}
?>
