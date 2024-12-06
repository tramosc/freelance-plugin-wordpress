<?php
class Program {
    
    // Guardar un nuevo programa y sus relaciones con docentes
    public function save_program($name, $slug, $area_id, $image_url, $docentes = []) {
        global $wpdb;
        
        // Insertar el programa en la base de datos
        $wpdb->insert(
            "{$wpdb->prefix}programs",
            array(
                'name' => $name,
                'slug' => $slug,
                'area_id' => $area_id,
                'image_url' => $image_url,
            ),
            array('%s', '%s', '%d', '%s')
        );

        // Obtener el ID del programa recién insertado
        $program_id = $wpdb->insert_id;

        // Guardar las relaciones con los docentes si se especificaron
        $this->save_program_docentes($program_id, $docentes);
    }

    // Obtener todos los programas
    public function get_all_programs() {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}programs");
    }

    // Obtener un programa por su ID
    public function get_program_by_id($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}programs WHERE id = %d", $id));
    }

    // Actualizar un programa y sus relaciones con docentes
    public function update_program($id, $name, $slug, $area_id, $image_url, $docentes = []) {
        global $wpdb;
        
        // Actualizar el programa
        $wpdb->update(
            "{$wpdb->prefix}programs",
            array(
                'name' => $name,
                'slug' => $slug,
                'area_id' => $area_id,
                'image_url' => $image_url,
            ),
            array('id' => $id),
            array('%s', '%s', '%d', '%s'),
            array('%d')
        );

        // Actualizar las relaciones con los docentes
        $this->save_program_docentes($id, $docentes);
    }

    // Eliminar un programa y sus relaciones con docentes
    public function delete_program($id) {
        global $wpdb;
        
        // Eliminar el programa
        $wpdb->delete("{$wpdb->prefix}programs", array('id' => $id), array('%d'));
        
        // Eliminar las relaciones con docentes
        $this->delete_program_docentes($id);
    }

    // Guardar la relación entre un programa y sus docentes
    private function save_program_docentes($program_id, $docentes) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'program_docente';

        // Eliminar relaciones actuales
        $wpdb->delete($table_name, array('program_id' => $program_id));

        // Insertar las nuevas relaciones
        foreach ($docentes as $docente_id) {
            $wpdb->insert($table_name, array(
                'program_id' => $program_id,
                'docente_id' => $docente_id
            ), array('%d', '%d'));
        }
    }

    // Obtener los docentes asociados a un programa
    public function get_program_docentes($program_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'program_docente';

        return $wpdb->get_col($wpdb->prepare("
            SELECT docente_id FROM $table_name WHERE program_id = %d
        ", $program_id));
    }

    // Eliminar todas las relaciones con docentes para un programa
    private function delete_program_docentes($program_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'program_docente';

        $wpdb->delete($table_name, array('program_id' => $program_id));
    }

    
}
