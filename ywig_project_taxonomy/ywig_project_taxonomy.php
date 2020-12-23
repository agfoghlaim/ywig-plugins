<?php

/**
 * Plugin Name:       YWIG ProjectName Taxonomy
 * Version:           1.0.0
 * Author:            MOH
 * License:           GPL v2 or later
 */


function setup_project_names_taxonomy()
{
  add_action('init', 'ywig_register_project_names_taxonomy');
  add_action('project_names_add_form_fields', 'ywig_add_project_names_social_meta');
  add_action('project_names_edit_form_fields', 'ywig_edit_project_names_fields_meta');
  add_action('create_project_names', 'ywig_save_project_names_fields_meta');
  add_action('edit_project_names', 'ywig_save_project_names_fields_meta');
}
setup_project_names_taxonomy();

function ywig_register_project_names_taxonomy()
{
  $labels = array(
    'name'              => _x('ProjectNames', 'taxonomy general name', 'text-domain'),
    'singular_name'     => _x('ProjectName', 'taxonomy singular name', 'text-domain'),
    'search_items'      => __('Search ProjectNames', 'text-domain'),
    'all_items'         => __('All ProjectNames', 'text-domain'),
    'parent_item'       => __('Parent ProjectName', 'text-domain'),
    'parent_item_colon' => __('Parent ProjectName:', 'text-domain'),
    'edit_item'         => __('Edit ProjectName', 'text-domain'),
    'update_item'       => __('Update ProjectName', 'text-domain'),
    'add_new_item'      => __('Add New ProjectName', 'text-domain'),
    'new_item_name'     => __('New ProjectName Name', 'text-domain'),
    'menu_name'         => __('ProjectName', 'text-domain'),
  );

  register_taxonomy('project_names', 'quickpost', array('labels' => $labels, 'public' => true, 'show_in_rest' => true ));
}

function ywig_util_create_project_names_term_meta($id, $name, $type) {
  return array(
    'id'   => esc_html__($id, 'text-domain'),
    'name' => esc_html__($name, 'text-domain'),
    'type' => esc_html__($type, 'text-domain'),
  );
}
function ywig_list_of_project_names_fields() {
  $project_namesName = ywig_util_create_project_names_term_meta('project_namesName', 'ProjectName Name', 'text');
  // $eircode = ywig_util_create_project_names_term_meta('eircode', 'Eircode', 'text');
  // $address = ywig_util_create_project_names_term_meta('address', 'Address', 'text');
  // $phone = ywig_util_create_project_names_term_meta('phone', 'Phone', 'text');

  return array( $project_namesName );
}

function ywig_add_project_names_social_meta() {
  wp_nonce_field(basename(__FILE__), 'project_names_social_nonce');
  $project_names_fields = ywig_list_of_project_names_fields();
?>
  <h1>ProjectName Details (for front page)</h1>
  <?php
  foreach ($project_names_fields as $project_names_field => $value) {
    // var_dump($value['id'])
  ?>
    <div class="form-field">
      <label for="">
        <?php echo $value['name']; ?>
      </label>
        <input type="text" name="<?php printf(esc_html__('ywig_project_names_%s_metadata', 'text-domain'), esc_attr($value['id'])); ?>" value="<?php ?>">
        <p>Put instructions here.</p>
    </div>
  <?php

  }
}

function ywig_edit_project_names_fields_meta($term) {
  wp_nonce_field(basename(__FILE__), 'project_names_social_nonce');
  $project_names_fields = ywig_list_of_project_names_fields();

  ?>
  
  <?php
  foreach ($project_names_fields as $project_names_field => $value) {
    echo $value['id'];
    // echo $project_names_field;
    $term_key = sprintf('ywig_project_names_%s_metadata', $value['id']);
    $metadata = get_term_meta($term->term_id, $term_key, true);

  ?>

    <tr class="form-field" >
      <th scope="row">
          <label for="<?php printf(esc_html__('%s-metadata', 'text-domain'), $project_names_field); ?>">
            <?php printf(esc_html__('ProjectName %s', 'text-domain'), $value['name'], 'text-domain'); ?>
          </label>
      </th>
      <td>
        <input type="text" name="<?php printf(esc_html__('ywig_project_names_%s_metadata', 'text-domain'), esc_attr($value['id'])); ?>" value="<?php echo (!empty($metadata)) ? esc_attr($metadata) : ''; ?>">
        <p class="description">Instructions go here.</p>
      </td>
    </tr>
<?php
  }
}

// 
function ywig_save_project_names_fields_meta($term_id) {

  if (!isset($_POST['project_names_social_nonce'])) return;
  if (!wp_verify_nonce($_POST['project_names_social_nonce'], basename(__FILE__))) return;

  $project_names_fields = ywig_list_of_project_names_fields();

  foreach ($project_names_fields as $project_names_field => $value) {
    // echo $project_names_field;
    // var_dump($value);
    $term_key = sprintf('ywig_project_names_%s_metadata', $value['id']);

    if (isset($_POST[$term_key])) {

      update_term_meta(
        $term_id,
        esc_attr($term_key),
        sanitize_text_field($_POST[$term_key])
      );
    }
	}
	return $term_id;

}



