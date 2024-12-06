<?php
class Masterclass {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'masterclass';
    }

    public function create_masterclass($data) {
        global $wpdb;
        $wpdb->insert($this->table_name, $data);
        return $wpdb->insert_id;
    }

    public function get_all_masterclasses() {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM $this->table_name");
    }

    public function get_masterclass($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $id));
    }

    public function update_masterclass($id, $data) {
        global $wpdb;
        $wpdb->update($this->table_name, $data, array('id' => $id));
    }

    public function delete_masterclass($id) {
        global $wpdb;
        $wpdb->delete($this->table_name, array('id' => $id));
    }

    public function assign_docentes_to_masterclass($masterclass_id, $docentes) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'masterclass_docente';
    
        // Eliminar relaciones existentes para evitar duplicados
        $wpdb->delete($table_name, ['masterclass_id' => $masterclass_id]);
    
        // Insertar nuevas relaciones
        foreach ($docentes as $docente_id) {
            $wpdb->insert($table_name, [
                'masterclass_id' => $masterclass_id,
                'docente_id' => $docente_id
            ]);
        }
    }

    public function get_all_docentes() {
        global $wpdb;
        return $wpdb->get_results("SELECT id, nombre, apellidos FROM {$wpdb->prefix}docentes");
    }
    
    public function get_docentes_by_masterclass($masterclass_id) {
        global $wpdb;
        $results = $wpdb->get_results(
            $wpdb->prepare("SELECT docente_id FROM {$wpdb->prefix}masterclass_docente WHERE masterclass_id = %d", $masterclass_id),
            ARRAY_A
        );
        return array_column($results, 'docente_id');
    }

    public function update_masterclass_docentes($masterclass_id, $docentes_ids) {
        global $wpdb;
    
        // Eliminar las asociaciones actuales de esta masterclass
        $wpdb->delete("{$wpdb->prefix}masterclass_docente", array('masterclass_id' => $masterclass_id));
    
        // Insertar las nuevas asociaciones
        foreach ($docentes_ids as $docente_id) {
            $wpdb->insert(
                "{$wpdb->prefix}masterclass_docente",
                array(
                    'masterclass_id' => $masterclass_id,
                    'docente_id'     => $docente_id
                ),
                array('%d', '%d')
            );
        }
    }
    
    
}
