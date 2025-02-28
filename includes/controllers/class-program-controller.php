<?php
ob_start();
require_once(plugin_dir_path(__FILE__) . '../models/class-program.php');

class Program_Controller {

    private $model;

    public function __construct() {
        $this->model = new Program();
    }

    // Crear un programa
    public function create_program() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener los valores del formulario
            $program_name = sanitize_text_field($_POST['program_name']);
            $area_id = isset($_POST['area_id']) ? intval($_POST['area_id']) : 0;
            $program_image_url = '';

            //Nueva imagen 2da(se comento que necesitan esto para la parte de inicio-index)
            $second_image_url = '';


            $docentes = isset($_POST['docentes']) ? array_map('intval', $_POST['docentes']) : [];
    
            // Aquí se agregan las demás variables necesarias
            $tipo_especializacion = isset($_POST['tipo_especializacion']) ? sanitize_text_field($_POST['tipo_especializacion']) : '';
            $fecha_inicio = isset($_POST['fecha_inicio']) ? sanitize_text_field($_POST['fecha_inicio']) : '';
            $fecha_fin = isset($_POST['fecha_fin']) ? sanitize_text_field($_POST['fecha_fin']) : '';
            $link_video = isset($_POST['link_video']) ? esc_url_raw($_POST['link_video']) : '';
            $descripcion = isset($_POST['descripcion']) ? wp_unslash(wp_kses_post($_POST['descripcion'])) : '';
            $que_aprenderas = isset($_POST['que_aprenderas']) ? wp_unslash(wp_kses_post($_POST['que_aprenderas'])) : '';
            $nro_modulos = isset($_POST['nro_modulos']) ? intval($_POST['nro_modulos']) : 0;
            $nro_horas = isset($_POST['nro_horas']) ? sanitize_text_field($_POST['nro_horas']) : '';
            $malla_curricular = isset($_POST['malla_curricular']) ? wp_kses_post($_POST['malla_curricular']) : '';
            $tipo_certificacion = isset($_POST['tipo_certificacion']) ? sanitize_text_field($_POST['tipo_certificacion']) : '';
            $hora_inicio = isset($_POST['hora_inicio']) ? sanitize_text_field($_POST['hora_inicio']) : '';
            $hora_fin = isset($_POST['hora_fin']) ? sanitize_text_field($_POST['hora_fin']) : '';
            $precio = isset($_POST['precio']) ? sanitize_text_field($_POST['precio']) : '';
    
            // Validación de los datos
            if (empty($program_name)) {
                add_action('admin_notices', function() {
                    echo '<div class="error"><p>El nombre del programa es obligatorio.</p></div>';
                });
                return;
            }
    
            // Manejo de la imagen
            if (isset($_FILES['program_image']) && $_FILES['program_image']['error'] === UPLOAD_ERR_OK) {
                $program_image_url = $this->handle_image_upload($_FILES['program_image']);
            }


            // Manejo de la segunda imagen
            if (isset($_FILES['second_image_url']) && $_FILES['second_image_url']['error'] === UPLOAD_ERR_OK) {
                $second_image_url = $this->handle_image_upload($_FILES['second_image_url']);
            }
    
            // Insertar programa usando el modelo
            $program_slug = sanitize_title($program_name);
            $this->model->save_program($program_name, $program_slug, $area_id, $program_image_url, $second_image_url, $tipo_especializacion, $fecha_inicio, $fecha_fin, $link_video, $descripcion, $que_aprenderas, $nro_modulos, $nro_horas, $malla_curricular, $tipo_certificacion, $hora_inicio, $hora_fin, $precio, $docentes);
    
            // Redirigir después de guardar el programa
            wp_redirect(admin_url('admin.php?page=mentory-list-programs'));
            exit;
        }
    
        // Obtener áreas y docentes para el formulario
        global $wpdb;
        $areas = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}areas");
        $docentes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}docentes");
    
        // Incluir vista de formulario
        include(plugin_dir_path(__FILE__) . '../views/programs/create-program.php');
    }
    

    // Editar un programa
    public function edit_program($program_id) {
        if (!isset($_GET['program_id'])) {
            wp_die('Programa no encontrado.');
        }
    
        $program_id = intval($_GET['program_id']);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $program_name = sanitize_text_field($_POST['program_name']);
            $area_id = isset($_POST['area_id']) ? intval($_POST['area_id']) : 0;
    
            // Si no se seleccionó una nueva imagen, mantener la imagen actual
            $program_image_url = $this->handle_image_upload($_FILES['program_image'], $program_id);

            // Si no se seleccionó una nueva imagen, mantener la imagen actual segunda
            $second_image_url = $this->handle_image_upload($_FILES['second_image_url'], $program_id);

            if (empty($program_image_url)) {
                // Si no se sube una nueva imagen, mantener la imagen actual
                global $wpdb;
                $current_program = $wpdb->get_row($wpdb->prepare("SELECT image_url FROM {$wpdb->prefix}programs WHERE id = %d", $program_id));
                $program_image_url = $current_program ? $current_program->image_url : '';
            }


            if (empty($second_image_url)) {
                // Si no se sube una nueva imagen, mantener la imagen actual
                global $wpdb;
                $current_programsecond = $wpdb->get_row($wpdb->prepare("SELECT second_image_url FROM {$wpdb->prefix}programs WHERE id = %d", $program_id));
                $second_image_url = $current_programsecond ? $current_programsecond->second_image_url : '';
            }


    
            $docentes = isset($_POST['docentes']) ? array_map('intval', $_POST['docentes']) : [];

            $tipo_especializacion = isset($_POST['tipo_especializacion']) ? sanitize_text_field($_POST['tipo_especializacion']) : '';
            $fecha_inicio = isset($_POST['fecha_inicio']) ? sanitize_text_field($_POST['fecha_inicio']) : '';
            $fecha_fin = isset($_POST['fecha_fin']) ? sanitize_text_field($_POST['fecha_fin']) : '';
            $link_video = isset($_POST['link_video']) ? esc_url_raw($_POST['link_video']) : '';
            $descripcion = isset($_POST['descripcion']) ? wp_unslash(wp_kses_post($_POST['descripcion'])) : '';
            $que_aprenderas = isset($_POST['que_aprenderas']) ? wp_unslash(wp_kses_post($_POST['que_aprenderas'])) : '';
            $nro_modulos = isset($_POST['nro_modulos']) ? intval($_POST['nro_modulos']) : 0;
            $nro_horas = isset($_POST['nro_horas']) ? sanitize_text_field($_POST['nro_horas']) : '';
            $malla_curricular = isset($_POST['malla_curricular']) ? wp_kses_post($_POST['malla_curricular']) : '';
            $tipo_certificacion = isset($_POST['tipo_certificacion']) ? sanitize_text_field($_POST['tipo_certificacion']) : '';
            $hora_inicio = isset($_POST['hora_inicio']) ? sanitize_text_field($_POST['hora_inicio']) : '';
            $hora_fin = isset($_POST['hora_fin']) ? sanitize_text_field($_POST['hora_fin']) : '';
            $precio = isset($_POST['precio']) ? sanitize_text_field($_POST['precio']) : '';
    
            // Actualizar programa usando el modelo
            $program_slug = sanitize_title($program_name);
            $this->model->update_program($program_id, $program_name, $program_slug, $area_id, $program_image_url, $second_image_url, $tipo_especializacion, $fecha_inicio, $fecha_fin, $link_video, $descripcion, $que_aprenderas, $nro_modulos, $nro_horas, $malla_curricular, $tipo_certificacion, $hora_inicio, $hora_fin, $precio, $docentes);
    
            // Redirigir después de actualizar
            wp_redirect(admin_url('admin.php?page=mentory-list-programs'));
            exit;
        }
    
        // Obtener datos para editar
        global $wpdb;
        $program = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}programs WHERE id = %d", $program_id));
        if (!$program) {
            wp_die('No se ha encontrado el programa.');
        }
    
        // Obtener áreas y docentes para el formulario
        $areas = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}areas");
        $docentes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}docentes");
        $program_docentes = $this->get_program_docentes($program_id);
    
        // Incluir vista de formulario
        include(plugin_dir_path(__FILE__) . '../views/programs/edit-program.php');
    }
    
    // Guardar relación entre programa y docentes
    private function save_program_docentes($program_id, $docentes) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'program_docente';

        // Eliminar relaciones anteriores
        $wpdb->delete($table_name, array('program_id' => $program_id));

        // Insertar nuevas relaciones
        foreach ($docentes as $docente_id) {
            $wpdb->insert($table_name, array(
                'program_id' => $program_id,
                'docente_id' => $docente_id
            ));
        }
    }

    // Obtener docentes asociados al programa
    private function get_program_docentes($program_id) {
        global $wpdb;
        return $wpdb->get_col($wpdb->prepare("
            SELECT docente_id FROM {$wpdb->prefix}program_docente WHERE program_id = %d
        ", $program_id));
    }

    // Manejo de carga de imagen
private function handle_image_upload($file, $program_id = null, $is_second_image = false) {
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($file, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            // Si hay un programa ID (edición), eliminar la imagen anterior
            if ($program_id) {
                global $wpdb;
                
                // Determinar qué imagen eliminar (primera o segunda)
                $column = $is_second_image ? 'second_image_url' : 'image_url';
                $program = $wpdb->get_row($wpdb->prepare("SELECT $column FROM {$wpdb->prefix}programs WHERE id = %d", $program_id));
                
                if ($program && !empty($program->$column)) {
                    $old_image_path = ABSPATH . parse_url($program->$column, PHP_URL_PATH);
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            return $movefile['url'];
        } else {
            error_log('Error al cargar la imagen: ' . $movefile['error']);
            return ''; // En caso de error
        }
    }
    return ''; // Si no se subió imagen
}

    // Listar todos los programas
    public function list_programs() {
        global $wpdb;
        $programs = $wpdb->get_results("
            SELECT p.*, a.name AS area_name 
            FROM {$wpdb->prefix}programs p
            LEFT JOIN {$wpdb->prefix}areas a ON p.area_id = a.id
        ");

        // Incluir vista de lista de programas
        include(plugin_dir_path(__FILE__) . '../views/programs/list-programs.php');
    }
}
