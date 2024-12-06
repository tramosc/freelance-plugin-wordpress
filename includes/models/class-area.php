<?php
class Area {

    // Método para guardar una nueva área
    public function save_area($name) {
        global $wpdb;

        // Sanitizar el nombre del área
        $name = sanitize_text_field($name);

        // Generar el slug automáticamente a partir del nombre del área
        $slug = sanitize_title_with_dashes($name);

        // Insertar el área en la base de datos, incluyendo el slug
        $result = $wpdb->insert(
            "{$wpdb->prefix}areas",
            array(
                'name' => $name,
                'slug' => $slug
            )
        );

        // Verificar si la inserción fue exitosa
        if ($result === false) {
            return new WP_Error('db_insert_error', 'Error al guardar el área en la base de datos.');
        }

        return $wpdb->insert_id; // Retorna el ID de la nueva área si la inserción fue exitosa
    }

    // Método para obtener un área por ID
    public function get_area($id) {
        global $wpdb;

        // Consultar el área en la base de datos
        $area = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}areas WHERE id = %d", 
            $id
        ));

        // Verificar si se encontró el área
        if (null === $area) {
            return new WP_Error('area_not_found', 'Área no encontrada.');
        }

        return $area;
    }

    // Método para obtener todas las áreas
    public function get_all_areas() {
        global $wpdb;

        // Consultar todas las áreas en la base de datos
        $areas = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}areas");

        return $areas;
    }

    // Método para actualizar un área existente
    public function update_area($id, $name) {
        global $wpdb;

        // Sanitizar el nombre del área
        $name = sanitize_text_field($name);
        $slug = sanitize_title_with_dashes($name);

        // Actualizar el área en la base de datos
        $result = $wpdb->update(
            "{$wpdb->prefix}areas",
            array(
                'name' => $name,
                'slug' => $slug
            ),
            array('id' => $id)
        );

        // Verificar si la actualización fue exitosa
        if ($result === false) {
            return new WP_Error('db_update_error', 'Error al actualizar el área en la base de datos.');
        }

        return true;
    }

    // Método para eliminar un área por ID
    public function delete_area($id) {
        global $wpdb;

        // Eliminar el área de la base de datos
        $result = $wpdb->delete(
            "{$wpdb->prefix}areas",
            array('id' => $id)
        );

        // Verificar si la eliminación fue exitosa
        if ($result === false) {
            return new WP_Error('db_delete_error', 'Error al eliminar el área en la base de datos.');
        }

        return true;
    }
}
