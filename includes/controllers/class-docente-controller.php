<?php
require_once(plugin_dir_path(__FILE__) . '/../models/class-docente.php');

class Docente_Controller {
    private $model;

    public function __construct() {
        $this->model = new Docente();
    }

    // Método para obtener un docente por su ID
    public function get_docente_by_id($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'docentes';
        return $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
    }

    public function get_all_docentes() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'docentes';

        // Consulta para obtener todos los docentes
        $results = $wpdb->get_results("SELECT * FROM $table_name");

        return $results;
    }

    public function list_docentes() {
        $docentes = $this->model->get_all_docentes();
        include(plugin_dir_path(__FILE__) . '/../views/docentes/list-docentes.php');
    }

    public function create_docente($data) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'docentes';

        // Subir la imagen
        $foto_url = '';
        if (!empty($_FILES['foto']['name'])) {
            $uploaded_file = $_FILES['foto'];

            // Usa la función de WordPress para manejar la carga del archivo
            $upload = wp_handle_upload($uploaded_file, array('test_form' => false));

            if (isset($upload['url']) && !isset($upload['error'])) {
                $foto_url = $upload['url'];
            } else {
                wp_die("Error al cargar la imagen: " . $upload['error']);
            }
        }

        // Insertar los datos del docente en la base de datos
        $wpdb->insert($table_name, array(
            'nombre' => sanitize_text_field($data['nombre']),
            'apellidos' => sanitize_text_field($data['apellidos']),
            'cargo' => sanitize_text_field($data['cargo']),
            'foto_url' => esc_url_raw($foto_url),
            'descripcion' => sanitize_textarea_field($data['descripcion'])
        ));

        echo '<div class="notice notice-success"><p>Docente creado con éxito.</p></div>';
    }

    // Método para actualizar los datos de un docente
    public function update_docente($id, $data) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'docentes';
    
        // Obtener la URL de la foto existente
        $docente = $this->get_docente_by_id($id);
        $existing_foto_url = $docente->foto_url;
    
        // Subir la imagen (si se ha subido una nueva)
        $foto_url = !empty($_FILES['foto']['name']) ? $this->handle_image_upload() : $existing_foto_url;
    
        // Actualizar docente en la base de datos
        $wpdb->update($table_name, array(
            'nombre' => sanitize_text_field($data['nombre']),
            'apellidos' => sanitize_text_field($data['apellidos']),
            'cargo' => sanitize_text_field($data['cargo']),
            'foto_url' => esc_url_raw($foto_url),
            'descripcion' => sanitize_textarea_field($data['descripcion'])
        ), array('id' => $id));
    }
    // Método para manejar la carga de imágenes
    private function handle_image_upload() {
        if (!empty($_FILES['foto']['name'])) {
            $uploaded_file = $_FILES['foto'];

            // Usa la función de WordPress para manejar la carga del archivo
            $upload = wp_handle_upload($uploaded_file, array('test_form' => false));

            if (isset($upload['url']) && !isset($upload['error'])) {
                return $upload['url'];
            } else {
                wp_die("Error al cargar la imagen: " . $upload['error']);
            }
        }
        return ''; // Si no se carga una imagen, devuelve una cadena vacía
    }
    

    public function edit_docente($id, $data) {
        $this->model->update_docente($id, $data);
    }

    // Método para eliminar un docente
    public function delete_docente($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'docentes';
        $wpdb->delete($table_name, array('id' => $id));
    }
}
