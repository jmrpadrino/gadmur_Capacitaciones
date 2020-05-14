<?php
/* Custon post type Ordenazas */
if ( ! function_exists('cpt_capacitaciones') ) {

    // Register Custom Post Type
    function cpt_capacitaciones() {
    
        $labels = array(
            'name'                  => _x( 'Capacitaciones', 'Post Type General Name', 'gadmur' ),
            'singular_name'         => _x( 'Capacitación', 'Post Type Singular Name', 'gadmur' ),
            'menu_name'             => __( 'Capacitaciones', 'gadmur' ),
            'name_admin_bar'        => __( 'Capacitación', 'gadmur' ),
            'archives'              => __( 'Archivo de Capacitaciones', 'gadmur' ),
            'attributes'            => __( 'Atributos de la Capacitación', 'gadmur' ),
            'parent_item_colon'     => __( 'Parent Item:', 'gadmur' ),
            'all_items'             => __( 'Todas las Capacitaciones', 'gadmur' ),
            'add_new_item'          => __( 'Agregar nueva Capacitación', 'gadmur' ),
            'add_new'               => __( 'Agregar nueva', 'gadmur' ),
            'new_item'              => __( 'Nueva Capacitación', 'gadmur' ),
            'edit_item'             => __( 'Editar Capacitación', 'gadmur' ),
            'update_item'           => __( 'Actualiza Capacitación', 'gadmur' ),
            'view_item'             => __( 'Ver Capacitación', 'gadmur' ),
            'view_items'            => __( 'Ver Capacitaciones', 'gadmur' ),
            'search_items'          => __( 'Buscar Capacitación', 'gadmur' ),
            'not_found'             => __( 'No se encuentra', 'gadmur' ),
            'not_found_in_trash'    => __( 'No se encuentra en papelera', 'gadmur' ),
            'featured_image'        => __( 'Imagen destacada', 'gadmur' ),
            'set_featured_image'    => __( 'Colocar imagen destacada', 'gadmur' ),
            'remove_featured_image' => __( 'Quitar imagen destacada', 'gadmur' ),
            'use_featured_image'    => __( 'Usar como imagen destacada', 'gadmur' ),
            'insert_into_item'      => __( 'Insertar en el item', 'gadmur' ),
            'uploaded_to_this_item' => __( 'Cargado a este item', 'gadmur' ),
            'items_list'            => __( 'Lista de Capacitaciones', 'gadmur' ),
            'items_list_navigation' => __( 'Navegación de la lista de Capacitaciones', 'gadmur' ),
            'filter_items_list'     => __( 'Filtrar la lista de Capacitaciones', 'gadmur' ),
        );
        $rewrite = array(
            'slug'                  => 'capacitacion',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $args = array(
            'label'                 => __( 'Capacitación', 'gadmur' ),
            'description'           => __( 'Post Type Description', 'gadmur' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'thumbnail', 'revisions'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => GADMUR_CAPACITACIONES_PLUGIN_URL . 'images/gadmur-admin-menu-icon.png',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'capacitaciones',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'rest_Capacitacione',
        );
        register_post_type( 'capacitacion', $args );
    
    }
    add_action( 'init', 'cpt_capacitaciones', 0 );
    
    }