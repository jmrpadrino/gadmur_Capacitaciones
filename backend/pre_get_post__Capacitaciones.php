<?php

 function gmCap_date_search_filter($query) {
    if ( ! is_admin() && $query->is_main_query() && !is_search() ) {

        if (is_post_type_archive('capacitacion')){
            $query->set( 'meta_key', 'gmCap_inicio' );
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'order', 'ASC' );

            if ( isset( $_GET['all'] ) ){
                $query->set( 'posts_per_page', 20 );
            }else{
                $meta_query = array(array(
                    'key'     => 'gmCap_inicio',
                    'value'   => date('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                ));
                $query->set( 'meta_query', $meta_query );
            }

            if(
                isset( $_GET['date_start'] ) &&
                isset( $_GET['date_end'] ) 
            ){
                if( $_GET['date_start'] > $_GET['date_end'] ) return;
                // https://wordpress.stackexchange.com/questions/34888/how-do-i-search-events-between-two-set-dates-inside-wp
                $meta_query = array(array(
                    'key'     => 'gmCap_inicio',
                    'value'   => array($_GET['date_start'], $_GET['date_end']),
                    'compare' => 'BETWEEN',
                    'type' => 'DATE'
                ));
                $query->set( 'meta_query', $meta_query );
            }
        }else{
            return;
        }
    }
}
add_action( 'pre_get_posts', 'gmCap_date_search_filter' ); 