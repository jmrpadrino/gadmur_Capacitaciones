<?php
/* Taxonomia Direcciónl post type Ordenazas */
if (!function_exists('tax_direccion_capacitacion')) {

    // Register Custom Taxonomy
    function tax_direccion_capacitacion()
    {

        $labels = array(
            'name'                       => _x('Direcciones', 'Taxonomy General Name', 'gadmur'),
            'singular_name'              => _x('Dirección', 'Taxonomy Singular Name', 'gadmur'),
            'menu_name'                  => __('Dirección', 'gadmur'),
            'all_items'                  => __('Todas', 'gadmur'),
            'parent_item'                => __('Item padre', 'gadmur'),
            'parent_item_colon'          => __('Item padre:', 'gadmur'),
            'new_item_name'              => __('Nuevo nombre', 'gadmur'),
            'add_new_item'               => __('Agregar nueva Dirección', 'gadmur'),
            'edit_item'                  => __('Editar Dirección', 'gadmur'),
            'update_item'                => __('Actualizar Dirección', 'gadmur'),
            'view_item'                  => __('Ver Dirección', 'gadmur'),
            'separate_items_with_commas' => __('Separe las Direcciones con comas', 'gadmur'),
            'add_or_remove_items'        => __('Agregar o quitar Direcciones', 'gadmur'),
            'choose_from_most_used'      => __('Seleccionar de los mas usados', 'gadmur'),
            'popular_items'              => __('Direcciones populares', 'gadmur'),
            'search_items'               => __('Buscar Dirección', 'gadmur'),
            'not_found'                  => __('No encontrado', 'gadmur'),
            'no_terms'                   => __('Sin Dirección', 'gadmur'),
            'items_list'                 => __('Lista de Direcciones', 'gadmur'),
            'items_list_navigation'      => __('Navegación de la lista de Direcciones', 'gadmur'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
            'query_var'                  => 'direccion',
            'show_in_rest'               => true,
            'rest_base'                  => 'rest_Direcciones',
        );
        register_taxonomy('direccion', array('capacitacion'), $args);
    }
    add_action('init', 'tax_direccion_capacitacion', 0);
}
function gmCap_random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}
function gmCap_random_color()
{
    return gmCap_random_color_part() . gmCap_random_color_part() . gmCap_random_color_part();
}
function gmCap_color_picker_assets($hook_suffix) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'gadmur-scripts', GADMUR_CAPACITACIONES_PLUGIN_URL . '/js/common-script.js', array( 'wp-color-picker' ), false, true );
 }
 add_action( 'admin_enqueue_scripts', 'gmCap_color_picker_assets' );
function gmCap_taxonomy_add_custom_field()
{
    $color = gmCap_random_color();
?>
    <div class="form-field">
        <style scoped>
            .color-term{
                display: inline-block;
                width: 15px;
                height: 15px;
                border-radius: 50%;
                background-color: #<?php echo $color; ?>;
            }
        </style>
        <label for="direccion-color"><?php _e('Color para el término', 'gadmur'); ?></label>
        <p><strong>Color preseleccionado: <span class="color-term"></span></strong></p>
        <input class="direccion-color" type="text" name="direccion-color" id="direccion-color" value="#<?php echo $color; ?>">
        <p class="description"><?php _e('Seleccione un color para esta Dirección.', 'gadmur'); ?></p>
    </div>
<?php
}
// https://gist.github.com/ms-studio/fc21fd5720f5bbdfaddc
add_action('direccion_add_form_fields', 'gmCap_taxonomy_add_custom_field', 10, 2);

function gmCap_taxonomy_edit_custom_meta_field($term) {

    $color = get_term_meta($term->term_id, 'direccion-color', true);
   ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="direccion-color"><?php _e('Color para el término', 'gadmur'); ?></label></th>
        <td>
            <input class="direccion-color" type="text" name="direccion-color" id="direccion-color" value="<?php echo $color ?>">
            <p class="description"><?php _e('Seleccione un color para esta Dirección.', 'gadmur'); ?></p>
        </td>
    </tr>
<?php
}

add_action( 'direccion_edit_form_fields', 'gmCap_taxonomy_edit_custom_meta_field', 10, 2 );

add_action( 'edit_direccion',   'gmCap_save_term_meta_text' );
add_action( 'create_direccion', 'gmCap_save_term_meta_text' );

function gmCap_save_term_meta_text( $term_id ) {
    $old_value  = get_term_meta( $term_id, 'direccion-color', true );
    $new_value = isset( $_POST['direccion-color'] ) ?  sanitize_text_field ( $_POST['direccion-color'] ) : '';

    if ( $old_value && '' === $new_value )
        delete_term_meta( $term_id, 'direccion-color' );

    else if ( $old_value !== $new_value )
        update_term_meta( $term_id, 'direccion-color', $new_value );
}

add_filter( 'manage_edit-direccion_columns', 'gmCap_edit_term_columns', 10, 3 );

function gmCap_edit_term_columns( $columns ) {

    $columns['term_color'] = '<span>' . __( 'color', 'text_domain' ) . '</span>';

    return $columns;
}

// RENDER COLUMNS (render the meta data on a column)

add_filter( 'manage_direccion_custom_column', 'gmCap_manage_term_custom_column', 10, 3 );

function gmCap_manage_term_custom_column( $out, $column, $term_id ) {

    if ( 'term_color' === $column ) {

        $color = get_term_meta($term_id, 'direccion-color', true);

        if ( ! $color )
            $color = 'gray';

        $out = '<span style="display: inline-block; width: 15px; height: 15px; border-radius: 50%; background-color: '.esc_attr( $color ).';"></span>';
    }

    return $out;
}