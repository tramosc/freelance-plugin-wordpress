<?php
class Program {
    
    // Guardar un nuevo programa y sus relaciones con docentes
    public function save_program($name, $slug, $area_id, $image_url, $tipo_especializacion, $fecha_inicio, $fecha_fin, $link_video, $descripcion, $que_aprenderas, $nro_modulos, $nro_horas, $malla_curricular, $tipo_certificacion, $hora_inicio, $hora_fin, $precio, $docentes = []) {
        global $wpdb;
        
        // Asegurarse de que los parámetros obligatorios no estén vacíos
        if (empty($name) || empty($slug) || empty($area_id) || empty($fecha_inicio) || empty($fecha_fin)) {
            return new WP_Error('missing_fields', 'Faltan campos obligatorios');
        }

        // Insertar el programa en la base de datos
        $wpdb->insert(
            "{$wpdb->prefix}programs",
            array(
                'name' => $name,
                'slug' => $slug,
                'area_id' => $area_id,
                'image_url' => $image_url,
                'tipo_especializacion' => $tipo_especializacion,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'link_video' => $link_video,
                'descripcion' => $descripcion,
                'que_aprenderas' => $que_aprenderas,
                'nro_modulos' => $nro_modulos,
                'nro_horas' => $nro_horas,
                'malla_curricular' => $malla_curricular,
                'tipo_certificacion' => $tipo_certificacion,
                'hora_inicio' => $hora_inicio,
                'hora_fin' => $hora_fin,
                'precio' => $precio,
            ),
            array('%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );

        // Obtener el ID del programa recién insertado
        $program_id = $wpdb->insert_id;

        // Guardar las relaciones con los docentes si se especificaron
        if (!empty($docentes)) {
            $this->save_program_docentes($program_id, $docentes);
        }

        return $program_id;
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
    public function update_program($id, $name, $slug, $area_id, $image_url, $tipo_especializacion, $fecha_inicio, $fecha_fin, $link_video, $descripcion, $que_aprenderas, $nro_modulos, $nro_horas, $malla_curricular, $tipo_certificacion, $hora_inicio, $hora_fin, $precio, $docentes = []) {
        global $wpdb;
        
        // Actualizar el programa
        $wpdb->update(
            "{$wpdb->prefix}programs",
            array(
                'name' => $name,
                'slug' => $slug,
                'area_id' => $area_id,
                'image_url' => $image_url,
                'tipo_especializacion' => $tipo_especializacion,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'link_video' => $link_video,
                'descripcion' => $descripcion,
                'que_aprenderas' => $que_aprenderas,
                'nro_modulos' => $nro_modulos,
                'nro_horas' => $nro_horas,
                'malla_curricular' => $malla_curricular,
                'tipo_certificacion' => $tipo_certificacion,
                'hora_inicio' => $hora_inicio,
                'hora_fin' => $hora_fin,
                'precio' => $precio,
            ),
            array('id' => $id),
            array('%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'),
            array('%d')
        );

        // Actualizar las relaciones con los docentes
        if (!empty($docentes)) {
            $this->save_program_docentes($id, $docentes);
        }
    }

    // Eliminar un programa y sus relaciones con docentes
    public function delete_program($id) {
        global $wpdb;
        
        // Eliminar el programa
        $wpdb->delete("{$wpdb->prefix}programs", array('id' => $id), array('%d'));
        
        // Eliminar las relaciones con docentes
        $this->delete_program_docentes($id);
    }

    // Obtener los docentes asociados a un programa
    public function get_program_docentes($program_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'program_docente';

        return $wpdb->get_col($wpdb->prepare("SELECT docente_id FROM $table_name WHERE program_id = %d", $program_id));
    }

    // Eliminar todas las relaciones con docentes para un programa
    private function delete_program_docentes($program_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'program_docente';

        $wpdb->delete($table_name, array('program_id' => $program_id));
    }
}
?>
