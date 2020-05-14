<?php
/* Capacitaciones Metaboxes */
apply_filters( 'enter_title_here', 'Añadir el título de la capacitación', 'capacitacion' );
function gmCap_meta_box() {

    add_meta_box(
        'gmCap_meta_capacitacion',
        '<img src="'.GADMUR_CAPACITACIONES_PLUGIN_URL.'images/gadmur-admin-menu-icon.png"> GADMUR - ' .__( 'Datos adicionales para el registro de la capacitación', 'gadmur' ),
        'gmCap_meta_box_callback',
        'capacitacion',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'gmCap_meta_box' );

function gmCap_meta_box_callback(){
    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'global_notice_nonce', 'global_notice_nonce' );
?>
<div class="hcf_box">
    <script>
        // https://www.sitepoint.com/adding-a-media-button-to-the-content-editor/
        jQuery(document).ready(function(){
            jQuery('#insert-my-pdf').click(open_media_window);
        });
        function open_media_window() {
            if (this.window === undefined) {
                this.window = wp.media({
                        title: 'Insertar un PDF',
                        multiple: true,
                        button: {text: 'Seleccionar'}
                    });

                var self = this; // Needed to retrieve our variable in the anonymous function below
                this.window.on('select', function() {
                        var first = self.window.state().get('selection').first().toJSON();
                        var items = self.window.state().get('selection').toJSON();
                        jQuery('#file-icons-placeholder li').remove();
                        console.log(items.length);
                        var itemsIds = '';
                        jQuery.each(items, function(index,value){
                            console.log(value)
                            var listItem = '<li class="media-item-list" data-item="'+index+'" data-itemurl="'+value.id+'"><span id="remove-media-from-list" data-removeitem="'+index+'">x</span> <img width="20" src="'+value.icon+'">&nbsp;&nbsp;'+value.filename+'</li>';
                            if ( index+1 < items.length ) itemsIds += value.id + ',';
                            if (index+1 == items.length) itemsIds += value.id
                            jQuery('#file-icons-placeholder').append(listItem)
                        })
                        jQuery('#ordenanza_pdf').val(itemsIds)
                    });
            }

            this.window.open();
            return false;
        }
    </script>
    <style scoped>
        .inputs-placeholder {
            display: flex;
            flex-direction: column;
        }
        .input-placeholder {
            display: flex;
            width: 100%;
            border-radius: 6px;
            justify-content: space-between;
        }
        .input-placeholder-row { display: flex; }
        .input-placeholder-col {
            width: 50%;
            margin: 0 10px;
        }
        .input-placeholder-col-fullw{ width: 100%; }
        .input-label {
            font-weight: bold;
            width: 120px;
        }
        .input-field { width: calc(100% - 120px); }
        .help-text {
            color: gray;
            font-size: 10px;
            display: block;
            margin: 5px 0;
        }
        .required-field { color: darkred; }
        .input-field textarea { width: 100%; }
        .gadmur_ordenanza_pdf { width: 70%; }
        .file-icons-placeholder {
            width: 94%;
            margin: 10px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 6px;
        }
        .media-item-list {
            display: flex;
            align-items: center;
        }
        .media-item-list1:hover {
            cursor: grab;
        }
        span#remove-media-from-list {
            width: 23px;
            height: 23px;
            display: inline-flex;
            margin-right: 10px;
            border-radius: 50%;
            color: darkred;
            font-weight: 900;
            justify-content: center;
            align-items: center;
            align-content: center;
            line-height: 0;
            border: 2px solid darkred;
            cursor: pointer;
        }
    </style>
    <div class="inputs-placeholder">
    <div class="input-placeholder-row">
            <div class="input-placeholder-col input-placeholder-col-fullw">
                <div class="input-placeholder">
                    <div class="input-label">
                        <label for="gmCap_descripcion">Descripción</label>
                    </div>
                    <div class="input-field">
                        <textarea id="gmCap_descripcion" name="gmCap_descripcion" rows="7" width="100%"><?php echo esc_attr( get_post_meta( get_the_ID(), 'gmCap_descripcion', true ) ); ?></textarea>
                        <span class="help-text"><span class="required-field">Campo Requerido.</span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-placeholder-row">
            <div class="input-placeholder-col">
                <div class="input-placeholder">
                    <div class="input-label">
                        <label for="gmCap_inicio">Fecha de Inicio</label>
                    </div>
                    <div class="input-field">
                        <input id="gmCap_inicio" 
                            type="date" 
                            name="gmCap_inicio"
                            required
                            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'gmCap_inicio', true ) ); ?>">
                        <span class="help-text"><span class="required-field">Campo Requerido.</span></span>
                    </div>
                </div>
            </div>
            <div class="input-placeholder-col">
            <div class="input-placeholder">
                    <div class="input-label">
                        <label for="gmCap_fin">Fecha de Finalización</label>
                    </div>
                    <div class="input-field">
                        <input id="gmCap_fin" 
                            type="date" 
                            name="gmCap_fin"
                            required
                            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'gmCap_fin', true ) ); ?>">
                        <span class="help-text"><span class="required-field">Campo Requerido.</span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-placeholder-row">
            <div class="input-placeholder-col input-placeholder-col-fullw">
                <div class="input-placeholder">
                    <div class="input-label">
                        <label for="ordenanza_pdf">Adjuntar Archivos</label>
                    </div>
                    <div class="input-field">
                        <a id="insert-my-pdf" class="button custom-plugin-media-button">Seleccionar</a>
                        <div class="file-icons-placeholder">
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
                                $upload_dir = wp_get_upload_dir() ;
                                if ($files->have_posts()){
                                    while($files->have_posts()){
                                        $files->the_post();
                                        $attach_metas = get_post_meta(get_the_ID());
                                        $item_list .= '<li class="media-item-list" data-item="'.get_the_ID().'" data-itemurl="'.$upload_dir['baseurl'].'/'.$attach_metas['_wp_attached_file'][0].'"><span id="remove-media-from-list" data-removeitem="'.get_the_ID().'" title="Quitar">x</span> &nbsp;&nbsp;'.get_the_title().'</li>';
                                    }
                                }
                            ?>
                            <ul id="file-icons-placeholder"><?php echo $item_list; ?></ul>
                        </div>
                        <input id="ordenanza_pdf" 
                            type="hidden"
                            class="gmCap_ordenanza_pdf"
                            title="Agrege el archivo PDF." 
                            name="gmCap_ordenanza_pdf"
                            accept="application/pdf"
                            width="100%"
                            style="width: 95%;"
                            value="<?php echo $fileIds; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
}

function gmCap_save_meta_box( $post_id ) {
    $error = false;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }

    $fields = [
        'gmCap_descripcion',
        'gmCap_inicio',
        'gmCap_fin',
        'gmCap_ordenanza_pdf',
    ];
    if ( $_POST['gmCap_inicio'] > $_POST['gmCap_fin'] ) {
        $error = 'Hay un error en los parámetros de fecha, por favor revise antes de continuar.';
    }
    if ($error) {
        // Handle error.
        if ( !session_id() ) {
            session_start();
        }
        $_SESSION['gm_plugin_errors'] = $error;
        return false;
    }
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }
    
}
add_action( 'save_post', 'gmCap_save_meta_box' );

function gmCap_error_message(){
?>
    <div id="message" class="notice notice-error is-dismissible">
        <p>Hay un error en los parámetros de fecha, por favor revise antes de continuar.<?php echo $_SESSION['gm_plugin_errors']; ?></p>
        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Descartar este aviso.</span></button>
    </div>
<?php
}
//add_action( 'admin_notices', 'gmCap_error_message' );

function gmCap_update_edit_form() {
    echo ' enctype="multipart/form-data"';
} // end update_edit_form
add_action('post_edit_form_tag', 'gmCap_update_edit_form');