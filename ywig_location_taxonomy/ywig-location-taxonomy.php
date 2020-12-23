<?php

/**
 * Plugin Name:       YWIG Location Taxonomy
 * Version:           1.0.0
 * Author:            MOH
 * License:           GPL v2 or later
 */


function setup()
{
  add_action('init', 'ywig_register_location_taxonomy');
  add_action('location_add_form_fields', 'ywig_add_location_social_meta');
  add_action('location_edit_form_fields', 'ywig_edit_location_social_meta');
  add_action('create_location', 'ywig_save_location_social_meta');
  add_action('edit_location', 'ywig_save_location_social_meta');
}
setup();

function ywig_register_location_taxonomy()
{
  $labels = array(
    'name'              => _x('Locations', 'taxonomy general name', 'text-domain'),
    'singular_name'     => _x('Location', 'taxonomy singular name', 'text-domain'),
    'search_items'      => __('Search Locations', 'text-domain'),
    'all_items'         => __('All Locations', 'text-domain'),
    'parent_item'       => __('Parent Location', 'text-domain'),
    'parent_item_colon' => __('Parent Location:', 'text-domain'),
    'edit_item'         => __('Edit Location', 'text-domain'),
    'update_item'       => __('Update Location', 'text-domain'),
    'add_new_item'      => __('Add New Location', 'text-domain'),
    'new_item_name'     => __('New Location Name', 'text-domain'),
    'menu_name'         => __('Location', 'text-domain'),
  );

  register_taxonomy('location', 'project', array('labels' => $labels, 'public' => true, 'show_in_rest' => true ));
}

function ywig_util_create_term_meta($id, $name, $type) {
  return array(
    'id'   => esc_html__($id, 'text-domain'),
    'name' => esc_html__($name, 'text-domain'),
    'type' => esc_html__($type, 'text-domain'),
  );
}
function ywig_list_of_socials() {
  $mapLink = ywig_util_create_term_meta('mapLink', 'Map Link', 'url');
  $eircode = ywig_util_create_term_meta('eircode', 'Eircode', 'text');
  $address = ywig_util_create_term_meta('address', 'Address', 'text');
  $phone = ywig_util_create_term_meta('phone', 'Phone', 'text');

  return array( $eircode, $mapLink, $address, $phone );
}

function ywig_add_location_social_meta() {
  wp_nonce_field(basename(__FILE__), 'location_social_nonce');
  $socials = ywig_list_of_socials();
?>
  <h1>Location Details (for front page)</h1>
  <?php
  foreach ($socials as $social => $value) {
    // var_dump($value['id'])
  ?>
    <div class="form-field">
      <label for="">
        <?php echo $value['name']; ?>
      </label>
        <input type="text" name="<?php printf(esc_html__('ywig_location_%s_metadata', 'text-domain'), esc_attr($value['id'])); ?>" value="<?php ?>">
        <p>Put instructions here.</p>
    </div>
  <?php

  }
}

function ywig_edit_location_social_meta($term) {
  wp_nonce_field(basename(__FILE__), 'location_social_nonce');
  $socials = ywig_list_of_socials();

  ?>
  
  <?php
  foreach ($socials as $social => $value) {
    echo $value['id'];
    // echo $social;
    $term_key = sprintf('ywig_location_%s_metadata', $value['id']);
    $metadata = get_term_meta($term->term_id, $term_key, true);

  ?>

    <tr class="form-field" >
      <th scope="row">
          <label for="<?php printf(esc_html__('%s-metadata', 'text-domain'), $social); ?>">
            <?php printf(esc_html__('Location %s', 'text-domain'), $value['name'], 'text-domain'); ?>
          </label>
      </th>
      <td>
        <input type="text" name="<?php printf(esc_html__('ywig_location_%s_metadata', 'text-domain'), esc_attr($value['id'])); ?>" value="<?php echo (!empty($metadata)) ? esc_attr($metadata) : ''; ?>">
        <p class="description">Instructions go here.</p>
      </td>
    </tr>
<?php
  }
}

// save 'location' ~category term meta - SHOWS IN 'ADD LOCATION'
function ywig_save_location_social_meta($term_id) {

  if (!isset($_POST['location_social_nonce'])) return;
  if (!wp_verify_nonce($_POST['location_social_nonce'], basename(__FILE__))) return;

  $socials = ywig_list_of_socials();

  foreach ($socials as $social => $value) {
    echo $social;
    // var_dump($value);
    $term_key = sprintf('ywig_location_%s_metadata', $value['id']);

    if (isset($_POST[$term_key])) {

      update_term_meta(
        $term_id,
        esc_attr($term_key),
        sanitize_text_field($_POST[$term_key])
      );
    }
  }
}



