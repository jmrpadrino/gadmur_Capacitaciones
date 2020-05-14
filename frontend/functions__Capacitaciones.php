<?php
/* CSS and JS */
function gmCap_add_theme_scripts()
{
    if ( is_admin() ) return;
    if (
        is_singular() ||
        is_post_type_archive('capacitacion') ||
        is_tax('direccion')
    ){

        // CSS
        wp_enqueue_style('gadmur-icons', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', array(), FALSE, 'all');
        wp_enqueue_style('gadmur-bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css', array(), FALSE, 'all');
        wp_enqueue_style('gadmur', GADMUR_CAPACITACIONES_PLUGIN_URL . '/css/common-styles.css', array(), FALSE, 'all');
        // JS
        wp_enqueue_script('gadmur-popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), NULL, true);
        wp_enqueue_script('gadmur-bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery'), NULL, true);
        wp_enqueue_script('gadmur', GADMUR_CAPACITACIONES_PLUGIN_URL . '/js/common-script.js', array('jquery'), NULL, true);  
    }
}
add_action('wp_enqueue_scripts', 'gmCap_add_theme_scripts');


/* Template include */
add_filter('template_include', 'capacitacion_archive_template', 99);
function capacitacion_archive_template($template)
{
    if (
        is_post_type_archive('capacitacion') ||
        is_tax('direccion')
        ) {
        $template = GADMUR_CAPACITACIONES_PLUGIN_DIR . '/frontend/templates/archive-template.php';
    }
    if (is_singular('capacitacion')) {
        $template = GADMUR_CAPACITACIONES_PLUGIN_DIR . '/frontend/templates/single-template.php';
    }
    return $template;
}
