<?php
/**
 * The template for displaying a list of users who are activated and not superadmin
 * Template Name: users
 */

get_header(); ?>

<div id="primary" class="entry-content">
<main id="main" class="site-main" role="main">
<h1>Members</h1>

<?php
if ( is_user_logged_in() and is_user_member_of_blog()) {
    $blogusers = get_users( array( 
        'fields' => array( 'id', 'display_name','user_email' ) , 
        'meta_key' => 'last_name',
        'orderby' => 'meta_value',
    ) );
    foreach ( $blogusers as $user ) {
        if ( is_super_admin ($user->id) and get_bloginfo('title') != 'Blewbury Croquet Club') continue;
        if ( ! wpmem_is_user_activated ($user->id)) continue;
        $first_name = get_user_meta($user->id, 'first_name', true);
        $last_name = get_user_meta($user->id, 'last_name', true);
        $name = $last_name . ', ' . $first_name;
        $address = get_user_meta($user->id, 'addr1', true);
        $addr2 = get_user_meta($user->id, 'addr2', true);
        if ($addr2 != "") $address = $address . ', ' .  $addr2;
        $address = $address . ', '  . get_user_meta($user->id, 'town', true) . ', '  . get_user_meta($user->id, 'postcode', true);
        $phone_1 = get_user_meta($user->id, 'phone_1', true);  
        $phone_2 = get_user_meta($user->id, 'phone_2', true);
        $phone = $phone_1;
        if ($phone_2 != "") $phone = $phone . ' / ' . $phone_2;
        $img = get_avatar_url($user -> id);
        $hcap = "";
        $ac = get_user_meta($user->id, 'ac_h', true);
        $gc = get_user_meta($user->id, 'gc_h', true);
        $sc = get_user_meta($user->id, 'sc_h', true);

        $hcap = "";
        if (strlen(trim($ac)) !== 0) $hcap = $hcap . "AC: ". $ac;
        if (strlen(trim($gc)) !== 0) {
            if($hcap) $hcap = $hcap . ", ";
            $hcap = $hcap . "GC: ". $gc;
        }
        if (strlen(trim($sc)) !== 0) {
            if($hcap) $hcap = $hcap . ", ";
            $hcap = $hcap . "SC: ". $sc;
        }
        if ($hcap) $hcap = "<br>" . $hcap;

        echo '<p><b><img src="' . $img . '" width="80" height="80" style="float:left; margin-right:20px;">' . esc_html($name ) . '</b> &lt;' . esc_html( $user->user_email ) . '&gt;<br/>' . $address  . '<br/>Tel: ' . $phone . $hcap . '</p>';
    }
}
?>

</main>

</div><!-- .content-area -->


<?php get_footer(); ?>
