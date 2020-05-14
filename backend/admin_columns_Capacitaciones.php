<?php

add_filter( 'manage_posts_columns', 'gmCap_columns_head' );
add_action( 'manage_posts_custom_column', 'gmCap_columns_content', 10, 2 );
add_action('admin_head', 'gmCap_styling_admin_order_list' );
function gmCap_styling_admin_order_list() {
?>
    <style>
        .label-status{
            display: block;
            border-radius: 4px;
            background-color: lightgray;
            padding: 7px 7px;
            text-align: center;
            width: 120px;
            min-width: 80px;
        }
		.status-1{
            color: green;
            border-left: 5px solid lime;
			font-weight: bold;
        }
		.status-2{
    		color: darkorange;
            border-left: 5px solid orange;
			font-weight: bold;
        }
        .status-3{
    		color: red;
            border-left: 5px solid red;
			font-weight: bold;
        }
    </style>
<?php 
}

function gmCap_columns_head($defaults){
    if ( $_GET['post_type'] == 'capacitacion' ){
        $defaults['publicada'] = 'Fecha Capacitación';
        $defaults['estado'] = 'Estado';
    }
    return $defaults;
}

function gmCap_columns_content($column_name, $post_ID){

    if ( $_GET['post_type'] == 'capacitacion' ){

        if ( $column_name == 'publicada'){
            echo date(
                'd-m-Y',
                strtotime(
                    get_post_meta( $post_ID, 'gmCap_inicio', true)
                )
            );
        }
        if ( $column_name == 'estado' ){
            $today = date('U');
            $event_date = date('U', strtotime(get_post_meta(get_the_ID(), 'gmCap_inicio', true)));
            $dia1 = date('Ymd',$today);
            if (date('Ymd', $today) == date('Ymd', $event_date)){
                echo '<span class="label-status status-2">En Curso</span>';
            }else{
                if ($today > $event_date){
                    echo '<span class="label-status status-3">Completado</span>';
                }else{
                    echo '<span class="label-status status-1">Programada</span>';
                }
            }
        }
    }

}

function gmCap_add_dashboard_widget() {

	wp_add_dashboard_widget(
		'gmCap_listado_capacitaciones',         
		'<img width="20" src="'.GADMUR_CAPACITACIONES_PLUGIN_URL.'images/gadmur-admin-menu-icon.png"> GADMUR - ' . _x('Próximas Capacitaciones', 'likoer24'),        
		'gmCap_dashboard_order_label_statues' 
	);	
}
add_action( 'wp_dashboard_setup', 'gmCap_add_dashboard_widget' );
function gmCap_dashboard_order_label_statues() {

    $args = array(
        'post_type' => 'capacitacion',
        'posts_per_page' => 15,
        'post_status' => 'publish'
    );
    $capacitaciones = new WP_Query($args);

	if (!$capacitaciones->have_posts()){
        echo 'No hay Capacitaciones agregadas aún.';
    }else{
		echo '<table class="lk24-dashboard-table" width="100%" border="0" align="center">';
		echo '<thead>';
		echo '<tr>';
		echo '<td><strong>Nombre</strong></td>';
		echo '<td width="100"><strong>Fecha</strong></td>';
		echo '<td align="center"><strong>Estado</strong></td>';
		echo '<td>&nbsp;</td>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		while($capacitaciones->have_posts()){
            $capacitaciones->the_post();
//			var_dump($order->get_status());
			echo '<tr>';
			echo '<td height="40">'. get_the_title() .'</td>';
            echo '<td>'. date('d-m-Y', strtotime(get_post_meta(get_the_ID(),'gmCap_inicio', true)) ) .'</td>';
            
            $today = date('U');
            $event_date = date('U', strtotime(get_post_meta(get_the_ID(), 'gmCap_inicio', true)));
            $dia1 = date('Ymd',$today);
            if (date('Ymd', $today) == date('Ymd', $event_date)){
                echo '<td><span class="label-status status-2">En Curso</span></td>';
            }else{
                if ($today > $event_date){
                    echo '<td><span class="label-status status-3">Completado</span></td>';
                }else{
                    echo '<td><span class="label-status status-1">Programada</span></td>';
                }
            }
            
			echo '<td aligh="center"><a href="'. get_edit_post_link(get_the_ID()).'"><span class="dashicons dashicons-admin-generic"></span></a></td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<td><strong>Nombre</strong></td>';
		echo '<td><strong>Fecha</strong></td>';
		echo '<td align="center"><strong>Estado</strong></td>';
		echo '<td>&nbsp;</td>';
		echo '</tr>';
		echo '</tfoot>';
		echo '</table>';
	}
}
