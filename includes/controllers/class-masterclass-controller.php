<?php
class Masterclass_Controller {
    private $model;

    public function __construct() {
        require_once(plugin_dir_path(__FILE__) . '../models/class-masterclass.php');
        $this->model = new Masterclass();
    }

    public function create_masterclass() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploaded_file_url = '';
            if (isset($_FILES['img_masterclass']) && !empty($_FILES['img_masterclass']['name'])) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                $upload = wp_handle_upload($_FILES['img_masterclass'], ['test_form' => false]);
                if ($upload && !isset($upload['error'])) {
                    $uploaded_file_url = $upload['url'];
                }
            }
    
            // Datos principales de la masterclass
            $nombre = sanitize_text_field($_POST['nombreMasterclass']);
            $slug = sanitize_title($nombre);
            $slug = $this->generate_unique_slug($slug);

            $data = array(
                'nombreMasterclass' => $nombre,
                'slugMasterclass' => $slug,
                'hora_inicio' => sanitize_text_field($_POST['hora_inicio']),
                'fecha_inicio' => sanitize_text_field($_POST['fecha_inicio']),
                'link_inscripcion' => esc_url_raw($_POST['link_inscripcion']),
                'img_masterclass' => $uploaded_file_url,
                'area_id' => intval($_POST['area_id']),
            );
    
            // Crear la masterclass y obtener el ID
            $masterclass_id = $this->model->create_masterclass($data);
    
            // Guardar relación con docentes seleccionados
            if (!empty($_POST['docente_ids'])) {
                $docentes = array_map('intval', $_POST['docente_ids']);
                $this->model->assign_docentes_to_masterclass($masterclass_id, $docentes);
            }
    
            wp_redirect(admin_url('admin.php?page=mentory-list-masterclass'));
            exit;
        }
        include(plugin_dir_path(__FILE__) . '../views/masterclass/create-masterclass.php');
    }

    // Función para generar un slug único
    private function generate_unique_slug($slug, $suffix = 1) {
        global $wpdb;
        $new_slug = $suffix > 1 ? "{$slug}-{$suffix}" : $slug;

        $slug_exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}masterclass WHERE slugMasterclass = %s",
            $new_slug
        ));

        return $slug_exists ? $this->generate_unique_slug($slug, ++$suffix) : $new_slug;
    }

    public function list_masterclass() {
        $masterclasses = $this->model->get_all_masterclasses();
        include(plugin_dir_path(__FILE__) . '../views/masterclass/list-masterclass.php');
    }

    public function edit_masterclass($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar si se ha subido una nueva imagen
            $uploaded_file_url = '';
            if (isset($_FILES['img_masterclass']) && !empty($_FILES['img_masterclass']['name'])) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                $upload = wp_handle_upload($_FILES['img_masterclass'], ['test_form' => false]);
                if ($upload && !isset($upload['error'])) {
                    $uploaded_file_url = $upload['url'];
                }
            } else {
                // Si no se subió nueva imagen, mantener la existente en la BD
                $uploaded_file_url = sanitize_text_field($_POST['existing_img_masterclass']);
            }
    
            // Verificar si el usuario ha proporcionado un slug nuevo o usar el generado automáticamente
            $slug = !empty($_POST['slugMasterclass']) ? sanitize_title($_POST['slugMasterclass']) : sanitize_title($_POST['nombreMasterclass']);
            $slug = $this->generate_unique_slug($slug);
    
            $data = array(
                'nombreMasterclass' => sanitize_text_field($_POST['nombreMasterclass']),
                'slugMasterclass' => $slug,
                'hora_inicio' => sanitize_text_field($_POST['hora_inicio']),
                'fecha_inicio' => sanitize_text_field($_POST['fecha_inicio']),
                'link_inscripcion' => esc_url_raw($_POST['link_inscripcion']),
                'img_masterclass' => $uploaded_file_url,
                'area_id' => intval($_POST['area_id']),
            );
    
            $this->model->update_masterclass($id, $data);
    
            // Actualizar los docentes asociados a la masterclass en la tabla de relación
            if (isset($_POST['docentes'])) {
                $docentes_ids = array_map('intval', $_POST['docentes']);
                $this->model->update_masterclass_docentes($id, $docentes_ids);
            }
    
            wp_redirect(admin_url('admin.php?page=mentory-list-masterclass'));
            exit;
        }
    
        // Obtener los datos actuales de la masterclass
        $masterclass = $this->model->get_masterclass($id);
    
        // Obtener todos los docentes disponibles
        $docentes = $this->model->get_all_docentes();
    
        // Obtener los docentes actualmente asociados a esta masterclass
        $selected_docentes = $this->model->get_docentes_by_masterclass($id);
    
        include(plugin_dir_path(__FILE__) . '../views/masterclass/edit-masterclass.php');
    }
    

    public function delete_masterclass($id) {
        $this->model->delete_masterclass($id);
        wp_redirect(admin_url('admin.php?page=mentory-list-masterclass'));
        exit;
    }
}
