<?php
class Docente {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'docentes';
    }

    public function get_all_docentes() {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$this->table_name}");
    }

    public function get_docente_by_id($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id));
    }

    public function insert_docente($data) {
        global $wpdb;
        return $wpdb->insert($this->table_name, $data);
    }

    public function update_docente($id, $data) {
        global $wpdb;
        return $wpdb->update($this->table_name, $data, ['id' => $id]);
    }

    public function delete_docente($id) {
        global $wpdb;
        return $wpdb->delete($this->table_name, ['id' => $id]);
    }
}