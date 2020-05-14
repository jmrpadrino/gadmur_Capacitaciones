<?php
/**
 * @package Gadmur
 * @version 1.0.0
 */
/*
Plugin Name: GADMUR - Capacitaciones
Plugin URI: https://choclomedia.com
Description: Administración y visualización de <strong>Capacitaciones</strong> para el Gobierno Municipal de Rumiñahui
Author: Jose Manuel Rodriguez Padrino (Choclomedia)
Version: 1.0.0
Author URI: https;//choclomedia.com
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo '¡Hola! solo soy un plugin, no pueden hacer mucho accediendo directamente';
	exit;
}

define( 'GADMUR_CAPACITACIONES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'GADMUR_CAPACITACIONES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
/*
$estados = array(
	1 => 'VIGENTE',
	2 => 'Perdió vigencia',
	3 => 'DEROGADO'
);
define('GADMUR__ESTADOS', $estados );
*/

// BACKEND FILES
require_once( GADMUR_CAPACITACIONES_PLUGIN_DIR . '/backend/cpt__Capacitaciones.php' );
require_once( GADMUR_CAPACITACIONES_PLUGIN_DIR . '/backend/taxonomy_materia_Capacitaciones.php' );
require_once( GADMUR_CAPACITACIONES_PLUGIN_DIR . '/backend/metabox__Capacitaciones.php' );
require_once( GADMUR_CAPACITACIONES_PLUGIN_DIR . '/backend/admin_columns_Capacitaciones.php' );
require_once( GADMUR_CAPACITACIONES_PLUGIN_DIR . '/backend/pre_get_post__Capacitaciones.php' );

// FRONTEND FILES
require_once( GADMUR_CAPACITACIONES_PLUGIN_DIR . '/frontend/functions__Capacitaciones.php' );
