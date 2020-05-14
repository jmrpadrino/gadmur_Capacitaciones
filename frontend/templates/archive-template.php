<?php 
$materias = get_terms( array(
    'taxonomy' => 'direccion',
    'hide_empty' => false,
) );
get_header(); 
$term_query = get_queried_object()->term_id;
?>
<div class="container">
    <div class="row">
        <div class="col col-sm-12">
            <h1><?php echo (isset($_GET['all'])) ? 'Listado de Capacitaciones' : 'Próximas Capacitaciones'; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-8">
            <ul class="d-flex gadmur-materia-list list-display-inline">
                <li><strong>Dirección</strong></li>
                <?php 
                    if ($materias){
                        foreach($materias as $materia){
                            $css = '';
                            if (!empty($term_query)){
                                if ($term_query == $materia->term_id) {
                                    $css = 'text-shadow: 1px 1px 2px #8a8a8a; font-size: 20px;';
                                }
                            }
                            $color = get_term_meta($materia->term_id, 'direccion-color', true);
                            if ( !$color )
                                $color = 'gray';
                            echo '<li data-toggle="tooltip" data-placement="top" title="'.$materia->name.'"><a href="'.get_term_link( $materia->term_id,'direccion' ).'"><i class="fas fa-circle" style="color: '.$color.'; '.$css.'"></i></a></li>';
                        }
                    }
                ?>
            </ul>
        </div>
        <div class="col col-sm-4">
            <div class="row">
                <div class="col-sm-1">
                    <a href="<?php echo get_post_type_archive_link( 'capacitacion' ) ?>?all" data-toggle="tooltip"
                        data-placement="top" title="Ver todas las capacitaciones"><i class="far fa-eye"></i></a>
                </div>
                <div class="col-sm-9">
                    <form role="search" method="get" id="searchform" class="gadmur-searchform"
                        action="<?php echo home_url(); ?>/">
                        <input type="hidden" value="capacitacion" name="post_type" />
                        <div class="input-group">
                            <input name="s" type="text" class="form-control" placeholder="Buscar Capacitación"
                                aria-label="Buscar Titulo de la Capacitación" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-seccess btn-outline-secondary" type="submit"
                                    id="button-addon2">&nbsp;<i class="fas fa-search"></i>&nbsp;</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-1">
                    <a class="btn btn-info" data-toggle="collapse" href="#collapse_filters" role="button"
                        aria-expanded="false" aria-controls="collapse_filters"><i class="fas fa-filter"></i></a>
                </div>
            </div>
        </div>
    </div>
<?php 
if(
    isset( $_GET['date_start'] ) &&
    isset( $_GET['date_end'] ) 
){
    if( $_GET['date_start'] > $_GET['date_end'] ) {
?>
<div class="row">
    <div class="col">
    <div class="alert alert-danger" role="alert">
    Error en los parámetros de fecha.
    </div>
    </div>
</div>
<?php 
    }
}
?>
    <div class="row">
        <div class="col col-sm-12">
            <div class="collapse gadmur-filters-placeholder" id="collapse_filters">
                <div class="card card-body text-left">
                    <div class="row">
                        <div class="col col-sm-12">
                            <h4>Filtrar por</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-6">
                            <strong>Rango de fechas</strong>
                            <form role="search" method="get"
                        action="<?php echo get_post_type_archive_link( 'capacitacion' ); ?>/">
                            <ul class="d-flex gadmur-materia-list justify-content-between list-display-inline">
                                <li>Desde: <input id="gadmur_date_start" type="date" name="date_start" value="<?php echo (isset($_GET['date_start'])) ? $_GET['date_start'] : ''?>" required></li>
                                <li>Hasta: <input id="gadmur_date_end" type="date" name="date_end" value="<?php echo (isset($_GET['date_end'])) ? $_GET['date_end'] : ''?>" required></li>
                            </ul>
                            <button class="btn btn-seccess btn-filter-dates btn-outline-secondary" type="submit"
                                    id="button-addon2">Filtrar por fechas</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ( have_posts() ) { ?>
    <div class="row">
        <div class="col col-sm-12">
            <div class="accordion gadmur-accordion" id="accordionExample">
                <?php 
                    $i = 0;
                    while ( have_posts() ){ the_post(); 
                        $terms;
                ?>
                <div class="card">
                    <div class="card-header" id="heading_<?php echo get_the_ID(); ?>">
                        <div class="row">
                            <div class="col col-md-10">
                                <button class="btn btn-link gadmur-btn-collapse collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapse_<?php echo get_the_ID(); ?>"
                                    aria-expanded="false" aria-controls="collapse_<?php echo get_the_ID(); ?>">
                                    <div class="row">
                                        <div class="col col-md-2">
                                            <?php echo date('d-m-Y', strtotime(get_post_meta(get_the_ID(), 'gmCap_inicio', true))); ?>
                                        </div>
                                        <div class="col col-md-10">
                                            <?php echo get_the_title(); ?>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <?php 
                                $today = date('U');
                                $event_date = date('U', strtotime(get_post_meta(get_the_ID(), 'gmCap_inicio', true)));
                                $dia1 = date('Ymd',$today);
                                
                            ?>
                            <div class="col col-md-2 d-flex1 justify-content-end align-items-center">
                                <?php
                                if (date('Ymd', $today) == date('Ymd', $event_date)){
                                    echo '<span class="label-status status-2">En Curso</span>';
                                }else{
                                    if ($today > $event_date){
                                        echo '<span class="label-status status-3">Completado</span>';
                                    }else{
                                        echo '<span class="label-status status-1">Programada</span>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div id="collapse_<?php echo get_the_ID(); ?>" class="collapse "
                        aria-labelledby="heading_<?php echo get_the_ID(); ?>" data-parent="#accordionExample">
                        <div class="card-body">
                            <h3><?php echo get_the_title(); ?></h3>
                            <ul class="d-flex gadmur-item-feature">
                                <li title="Fecha de inicio"><i class="far fa-calendar-alt"></i>
                                    <?php echo get_post_meta(get_the_ID(), 'gmCap_inicio', true); ?>
                                </li>
                                <li title="Fecha de finalización"><i class="far fa-calendar-alt"></i>
                                    <?php echo get_post_meta(get_the_ID(), 'gmCap_fin', true); ?>
                                </li>
                            </ul>

                            <p class="ordenanza-archive-observaciones"><?php echo get_post_meta(get_the_ID(), 'gmCap_descripcion', true); ?></p>
                            <?php 
                                $fileIds = get_post_meta( get_the_ID(), 'gmCap_ordenanza_pdf', true );
                                $fielIds = explode(',', $fileIds);
                                $files = new WP_Query( 
                                    array( 
                                        'post__in' => $fielIds,
                                        'post_type' => 'attachment',
                                        'post_status' => 'inherit',
                                        'posts_per_page' => -1
                                    ) 
                                );
                                //var_dump($files);
                                $upload_dir = wp_get_upload_dir() ;
                                if ($files->have_posts()){
                            ?>
                            <h6>Archivos Descargables</h6>
                            <ul>
                                <?php 
                                while($files->have_posts()){
                                    $files->the_post();
                                    $attach_metas = get_post_meta(get_the_ID());
                                    echo '<li><a href="'.$upload_dir['baseurl'].'/'.$attach_metas['_wp_attached_file'][0].'" download>'.get_the_title().'</a></li>';
                                }
                                ?>
                            </ul>
                            <?php } //End if ?>
                        </div>
                    </div>
                </div>
                <?php 
                    $i++;
                    } // END while loop 
                ?>
            </div>
        </div>
    </div>
    <div class="row gadmur-archive-pagination">
        <div class="col col-md-12">
            <?php
                //https://developer.wordpress.org/reference/functions/paginate_links/
                global $wp_query;
                $big = 999999999; // need an unlikely integer 
                echo paginate_links( array(
                    'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format'  => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    'total'   => $wp_query->max_num_pages
                ) );
            ?>
        </div>
    </div>
    <?php }else{ ?>
        <h1>No hay capacitaciones con este tipo de parámetro</h1>
        <p><a href="<?php echo get_post_type_archive_link( 'capacitacion' ); ?>">Volver</a></p>
    <?php } // END if have posts ?>
</div>
<script>
jQuery(function() {
    jQuery('[data-toggle="tooltip"]').tooltip()
})
</script>
<?php get_footer(); ?>