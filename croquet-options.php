<?php
add_action('admin_menu', 'croquet_admin_add_page');
function croquet_admin_add_page() {
    add_options_page('Password Security Settings', 'Password Security Settings', 'manage_options', 'croquet', 'croquet_options_page');
}

function croquet_options_page() {
?>
<div>
<h2>Password Security Settings</h2>
Options for the Password Security of the Croquet Theme.
<form action="options.php" method="post">
<?php settings_fields('croquet_options'); ?>
<?php do_settings_sections('croquet'); ?>
<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
</form></div>
<?php
}

add_action('admin_init', 'plugin_admin_init');
function plugin_admin_init(){
    register_setting( 'croquet_options', 'croquet_options', ['sanitize_callback' => 'croquet_options_validate', 'default'=>[]] );
    add_settings_section('croquet_main_section', 'Main Settings', 'croquet_main_section_text', 'croquet');

    add_settings_field('croquet_min_length', 'Minimum length of password', 'render_croquet_min_length', 'croquet', 'croquet_main_section');
    add_settings_field('croquet_min_of_each', 'Minimum number of each type of character', 'render_croquet_min_of_each', 'croquet', 'croquet_main_section');
}

function croquet_main_section_text() {
?>
<p>Passwords must be of some minimum length. They must also contain a minimum number of each type of character.</p>
<p>Character types are:</p>
<ol>
<li>Upper case letter</li>
<li>Lower case letter</li>
<li>Digit</li>
<li>Neither a letter nor a digit</li>
</ol>
<?php
}

function render_croquet_min_length() {
    $options = get_option('croquet_options');
    echo "<input id='croquet_min_length' name='croquet_options[min_length]' size='6' type='text' value='{$options['min_length']}' />";
}

function render_croquet_min_of_each() {
    $options = get_option('croquet_options');
    echo "<input id='croquet_min_of_each' name='croquet_options[min_of_each]' size='6' type='text' value='{$options['min_of_each']}' />";
}

function croquet_options_validate($input) {
    $options=get_option('croquet_options');
    $options['min_length'] = intval($input['min_length']); 
    $options['min_of_each'] = intval($input['min_of_each']);
    if ($options['min_length'] < 4) $options['min_length'] = 4;
    if ($options['min_length'] > 20) $options['min_length'] = 20;
    if ($options['min_of_each'] < 0) $options['min_of_each'] = 0; 
    if ($options['min_of_each'] > $options['min_length']/4) $options['min_of_each'] = intval($options['min_length']/4);
    return $options;
}
