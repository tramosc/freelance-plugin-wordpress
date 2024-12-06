<?php
ob_start();
class Area_Controller {

    public function create_area() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mentory_create_area_nonce']) && wp_verify_nonce($_POST['mentory_create_area_nonce'], 'mentory_create_area')) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'areas';
            $name = sanitize_text_field($_POST['name']);
            $slug = sanitize_title($name);

            $wpdb->insert($table_name, [
                'name' => $name,
                'slug' => $slug,
            ]);

            echo '<div class="notice notice-success"><p>Área creada con éxito.</p></div>';
        }

        // Formulario para crear un área
        echo '<h2>Crear Área</h2>';
        echo '<form method="POST">';
        wp_nonce_field('mentory_create_area', 'mentory_create_area_nonce');
        echo '<label for="name">Nombre del Área:</label>';
        echo '<input type="text" name="name" required>';
        echo '<button type="submit">Guardar</button>';
        echo '</form>';
    }

    public function list_areas() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'areas';
        $areas = $wpdb->get_results("SELECT * FROM $table_name");

        echo '<h2>Lista de Áreas</h2>';
        echo '<table><tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>';
        foreach ($areas as $area) {
            echo "<tr><td>{$area->id}</td><td>{$area->name}</td>";
            echo "<td><a href='" . admin_url("admin.php?page=mentory-edit-area&id={$area->id}") . "'>Editar</a> | ";
            echo "<a href='" . admin_url("admin.php?page=mentory-delete-area&id={$area->id}") . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar esta área?\");'>Eliminar</a></td></tr>";
        }
        echo '</table>';
    }

    public function edit_area() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'areas';

        if (isset($_GET['id'])) {
            $area_id = intval($_GET['id']);
            $area = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $area_id));
            
            if (!$area) {
                echo '<div class="notice notice-error"><p>Área no encontrada.</p></div>';
                return;
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mentory_edit_area_nonce']) && wp_verify_nonce($_POST['mentory_edit_area_nonce'], 'mentory_edit_area')) {
                $name = sanitize_text_field($_POST['name']);
                $slug = sanitize_title($name);

                $wpdb->update($table_name, [
                    'name' => $name,
                    'slug' => $slug,
                ], ['id' => $area_id]);

                echo '<div class="notice notice-success"><p>Área actualizada con éxito.</p></div>';
            }

            // Formulario de edición
            echo '<h2>Editar Área</h2>';
            echo '<form method="POST">';
            wp_nonce_field('mentory_edit_area', 'mentory_edit_area_nonce');
            echo '<label for="name">Nombre del Área:</label>';
            echo '<input type="text" name="name" value="' . esc_attr($area->name) . '" required>';
            echo '<button type="submit">Actualizar</button>';
            echo '</form>';
        }
    }

 // Método para obtener un área por ID
 public function get_area($area_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'areas';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $area_id));
}

// Método para eliminar un área
public function delete_area($area_id) {
    // Obtén el área primero para verificar si existe
    $area = $this->get_area($area_id);

    if ($area) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'areas';
        $result = $wpdb->delete($table_name, array('id' => $area_id));

        if ($result === false) {
            return new WP_Error('delete_failed', 'No se pudo eliminar el área.');
        }

        return true; // El área fue eliminada con éxito
    } else {
        return new WP_Error('area_not_found', 'Área no encontrada.');
    }
}
}