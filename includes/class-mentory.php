<?php
class mentory {

    // Constructor
    public function __construct() {
        // Inicialización del plugin
    }

    // Inicialización de la funcionalidad
    public function init() {
        // Agregar hooks, shortcodes, o cualquier otra funcionalidad
        add_action('wp_footer', array($this, 'mentory_footer_text'));
    }

    // Ejemplo de una función que agrega un texto al pie de página
    public function mentory_footer_text() {
        echo '';
    }
}