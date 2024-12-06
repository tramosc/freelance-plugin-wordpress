<?php
/**
 * Plugin Name: Mentory Plugin
 * Plugin URI: http://example.com/mentory
 * Description: Este es un plugin de ejemplo para mostrar la estructura de un plugin de WordPress.
 * Version: 1.0
 * Author: Toni Ramos
 * Author URI: http://example.com
 * License: GPL2
 */
defined('ABSPATH') or die('¡Acceso denegado!');

// Incluir Modelos
require_once(plugin_dir_path(__FILE__) . 'includes/models/class-docente.php');
require_once(plugin_dir_path(__FILE__) . 'includes/models/class-area.php');
require_once(plugin_dir_path(__FILE__) . 'includes/models/class-program.php');
require_once(plugin_dir_path(__FILE__) . 'includes/models/class-masterclass.php');

// Requerir los controladores
require_once(plugin_dir_path(__FILE__) . 'includes/controllers/class-docente-controller.php');
require_once(plugin_dir_path(__FILE__) . 'includes/controllers/class-area-controller.php');
require_once(plugin_dir_path(__FILE__) . 'includes/controllers/class-program-controller.php');
require_once(plugin_dir_path(__FILE__) . 'includes/controllers/class-masterclass-controller.php');

// Activación del plugin
function mentory_activate() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Crear las tablas
    $sql_programs = "CREATE TABLE {$wpdb->prefix}programs (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        slug tinytext NOT NULL,
        area_id INT(11) NOT NULL DEFAULT 0,
        image_url varchar(255) DEFAULT '' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    $sql_areas = "CREATE TABLE {$wpdb->prefix}areas (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        slug tinytext NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Crear la tabla 'docentes'
    $sql_docentes = "CREATE TABLE {$wpdb->prefix}docentes (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombre tinytext NOT NULL,
        apellidos tinytext NOT NULL,
        cargo tinytext NOT NULL,
        foto_url varchar(255) DEFAULT '' NOT NULL,
        descripcion text NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";


    //zona de relacion de tablas
    // Tabla de relación entre programas y docentes
    $sql_program_docente = "CREATE TABLE {$wpdb->prefix}program_docente (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        program_id mediumint(9) NOT NULL,
        docente_id mediumint(9) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (program_id) REFERENCES {$wpdb->prefix}programs(id) ON DELETE CASCADE,
        FOREIGN KEY (docente_id) REFERENCES {$wpdb->prefix}docentes(id) ON DELETE CASCADE
    ) $charset_collate;";


    // Crear la tabla 'masterclass'
    $sql_masterclass = "CREATE TABLE {$wpdb->prefix}masterclass (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombreMasterclass tinytext NOT NULL,
        slugMasterclass tinytext NOT NULL,
        hora_inicio time NOT NULL,
        fecha_inicio date NOT NULL,
        link_inscripcion varchar(255) DEFAULT '' NOT NULL,
        img_masterclass varchar(255) DEFAULT '' NOT NULL,
        area_id INT(11) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Tabla de relación entre masterclass y docentes
    $sql_masterclass_docente = "CREATE TABLE {$wpdb->prefix}masterclass_docente (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        masterclass_id mediumint(9) NOT NULL,
        docente_id mediumint(9) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (masterclass_id) REFERENCES {$wpdb->prefix}masterclass(id) ON DELETE CASCADE,
        FOREIGN KEY (docente_id) REFERENCES {$wpdb->prefix}docentes(id) ON DELETE CASCADE
    ) $charset_collate;";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_programs);
    dbDelta($sql_areas);
    dbDelta($sql_docentes);
    dbDelta($sql_masterclass);
    

    dbDelta($sql_program_docente);
    dbDelta($sql_masterclass_docente);
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'mentory_activate');


// Encolar Bootstrap en el plugin
function mentory_enqueue_bootstrap() {
    // Agregar estilo de Bootstrap
    wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2');
    
    // Agregar JavaScript de Bootstrap (dependiente de jQuery)
    wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
}
add_action('wp_enqueue_scripts', 'mentory_enqueue_bootstrap');
add_action('admin_enqueue_scripts', 'mentory_enqueue_bootstrap');



function mentory_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'mentory_deactivate');

// Menú del plugin
function mentory_plugin_menu() {
    // En lugar de 'manage_options', usa una capacidad más permisiva como 'edit_posts'.
    add_menu_page('Mentory Plugin', 'Mentory', 'edit_posts', 'mentory-plugin', 'mentory_dashboard', 'dashicons-welcome-learn-more');


    // Submenú de Programas
    add_submenu_page('mentory-plugin', 'Crear Programa', 'Crear Programa', 'manage_options', 'mentory-create-program', 'mentory_create_program');
    add_submenu_page('mentory-plugin', 'Lista de Programas', 'Lista de Programas', 'manage_options', 'mentory-list-programs', 'mentory_list_programs');
    add_submenu_page(null, 'Editar Programa', 'Editar Programa', 'manage_options', 'mentory-edit-program', 'mentory_edit_program');
    add_submenu_page(null, 'Eliminar Programa', 'Eliminar Programa', 'manage_options', 'mentory-delete-program', 'mentory_delete_program');

    // Submenú de Áreas
    add_submenu_page('mentory-plugin', 'Crear Área', 'Crear Área', 'manage_options', 'mentory-create-area', 'mentory_create_area');
    add_submenu_page('mentory-plugin', 'Lista de Áreas', 'Lista de Áreas', 'manage_options', 'mentory-list-areas', 'mentory_list_areas');
    add_submenu_page(null, 'Editar Área', 'Editar Área', 'manage_options', 'mentory-edit-area', 'mentory_edit_area');
    add_submenu_page(null, 'Eliminar Área', 'Eliminar Área', 'manage_options', 'mentory-delete-area', 'mentory_delete_area');

    // Submenú de Docentes
    add_submenu_page('mentory-plugin', 'Crear Docente', 'Crear Docente', 'manage_options', 'mentory-create-docente', 'mentory_create_docente');
    add_submenu_page('mentory-plugin', 'Lista de Docentes', 'Lista de Docentes', 'manage_options', 'mentory-list-docentes', 'mentory_list_docentes');
    add_submenu_page(null, 'Editar Docente', 'Editar Docente', 'manage_options', 'edit_docente', 'mentory_edit_docente');
    add_submenu_page(null, 'Eliminar Docente', 'Eliminar Docente', 'manage_options', 'delete_docente', 'mentory_delete_docente');

    // Submenú de Masterclass
    add_submenu_page('mentory-plugin', 'Crear Masterclass', 'Crear Masterclass', 'manage_options', 'mentory-create-masterclass', 'mentory_create_masterclass');
    add_submenu_page('mentory-plugin', 'Lista de Masterclasses', 'Lista de Masterclasses', 'manage_options', 'mentory-list-masterclass', 'mentory_list_masterclass');
    add_submenu_page(null, 'Editar Masterclass', 'Editar Masterclass', 'manage_options', 'mentory-edit-masterclass', 'mentory_edit_masterclass');
    add_submenu_page(null, 'Eliminar Masterclass', 'Eliminar Masterclass', 'manage_options', 'mentory-delete-masterclass', 'mentory_delete_masterclass');


}
add_action('admin_menu', 'mentory_plugin_menu');

function mentory_dashboard() {
    echo '<h1>Mentory Plugin Dashboard</h1>';
}

// Funciones de Programas
function mentory_create_program() {
    $controller = new Program_Controller();
    $controller->create_program();
}

function mentory_list_programs() {
    $program_controller = new Program_Controller();
    $program_controller->list_programs();
}

function mentory_edit_program() {
    if (isset($_GET['program_id'])) {
        $program_id = intval($_GET['program_id']);
        $program_controller = new Program_Controller();
        $program_controller->edit_program($program_id);
    } else {
        wp_die('Programa no encontrado.');
    }
}

function mentory_delete_program() {
    if (isset($_GET['program_id'])) {
        $program_id = intval($_GET['program_id']);
        
        // Incluye la clase Program si no está incluida
        require_once(plugin_dir_path(__FILE__) . 'includes/models/class-program.php');
        
        // Crear instancia de Program y llamar al método delete_program
        $program = new Program();
        $program->delete_program($program_id);

        // Redirigir a la lista de programas después de eliminar
        wp_redirect(admin_url('admin.php?page=mentory-list-programs'));
        exit;
    } else {
        wp_die('ID de programa no especificado.');
    }
}

// Funciones de Áreas
function mentory_create_area() {
    $controller = new Area_Controller();
    $controller->create_area();
}

function mentory_list_areas() {
    include(plugin_dir_path(__FILE__) . 'includes/views/areas/list-areas.php');
}

function mentory_edit_area() {
    include(plugin_dir_path(__FILE__) . 'includes/views/areas/edit-area.php');
}

function mentory_delete_area() {
    ob_start();

    if (isset($_GET['area_id'])) {
        $area_id = intval($_GET['area_id']); 

        if ($area_id > 0) {
            $area_controller = new Area_Controller();
            $result = $area_controller->delete_area($area_id);

            if (is_wp_error($result)) {
                echo '<div class="error"><p>' . $result->get_error_message() . '</p></div>';
            } else {
                wp_redirect(admin_url('admin.php?page=mentory-list-areas'));
                exit;
            }
        } else {
            echo '<div class="error"><p>ID de área no válido.</p></div>';
        }
    } else {
        echo '<div class="error"><p>No se proporcionó un ID de área.</p></div>';
    }

    ob_end_clean();
}

// Funciones de Docentes
function mentory_list_docentes() {
    include plugin_dir_path(__FILE__) . 'includes/views/docentes/list-docentes.php';
}

function mentory_create_docente() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_docente'])) {
        $controller = new Docente_Controller();
        $controller->create_docente($_POST);
    }
    include(plugin_dir_path(__FILE__) . 'includes/views/docentes/create-docente.php');
}

// Función para editar docente
function mentory_edit_docente() {
    if (!current_user_can('edit_posts')) {
        wp_die('No tienes permisos suficientes para acceder a esta página.');
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $controller = new Docente_Controller();
        $docente = $controller->get_docente_by_id($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_docente'])) {
            $controller->update_docente($id, $_POST);
            wp_redirect(admin_url('admin.php?page=mentory-list-docentes'));
            exit;
        }
        include(plugin_dir_path(__FILE__) . 'includes/views/docentes/edit-docente.php');
    }
}

function mentory_delete_docente() {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $controller = new Docente_Controller();
        $controller->delete_docente($id);
        // Redirige a la lista de docentes después de la eliminación
        wp_redirect(admin_url('admin.php?page=list_docentes'));
        exit;
    }
}


// Función que muestra la página de la lista de docentes
function mentory_list_docentes_page() {
    echo '<pre>';
    print_r($_GET);
    echo '</pre>';

    // Asegúrate de que el controlador está funcionando correctamente
    $docente_controller = new Docente_Controller();
    $docente_controller->list_docentes();
}

// Función para la página principal del plugin (puedes ajustarla si es necesario)
function mentory_admin_page() {
    echo '<h1>Bienvenido a Mentory</h1>';
    echo '<p>Desde aquí puedes gestionar todos los aspectos del plugin.</p>';
}



// Reescritura de URL personalizada
function mentory_rewrite_rules() {
    add_rewrite_rule(
        '^([^/]+)/([^/]+)/?$',
        'index.php?area_slug=$matches[1]&program_slug=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        '^programas/?$',
        'index.php?all_programas=true',
        'top'
    );

    // For debugging, let's flush the rewrite rules and verify
    flush_rewrite_rules(); 
}
add_action('init', 'mentory_rewrite_rules');

function mentory_query_vars($vars) {
    $vars[] = 'program_slug';
    $vars[] = 'area_slug';
    $vars[] = 'all_programas';
    return $vars;
}
add_filter('query_vars', 'mentory_query_vars');

function mentory_template_redirect() {
    $area_slug = get_query_var('area_slug');
    $program_slug = get_query_var('program_slug');
    $all_programas = get_query_var('all_programas');


    if ($all_programas) {
        include locate_template('programas/all_programas.php');
        exit;
    }

    if ($program_slug) {
        $program = mentory_get_program_by_slug($program_slug);
        $area = mentory_get_area_by_slug($area_slug);

        if ($program && $area) {
            include locate_template('programas/detail_programa.php');
            exit;
        }
    }
}
add_action('template_redirect', 'mentory_template_redirect');

// Funciones para obtener datos
function mentory_get_programs() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'programs';
    return $wpdb->get_results("SELECT * FROM $table_name");
}

function mentory_get_program_by_slug($slug) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'programs';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE slug = %s", $slug));
}

function mentory_get_area_by_slug($slug) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'areas';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE slug = %s", $slug));
}

function mentory_get_area_by_id($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'areas';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
}

function mentory_get_docentes_by_program($program_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'program_docente';
    return $wpdb->get_results($wpdb->prepare("
        SELECT d.* FROM {$wpdb->prefix}docentes d
        INNER JOIN $table_name pd ON d.id = pd.docente_id
        WHERE pd.program_id = %d
    ", $program_id));
}

function mentory_get_all_docentes() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'docentes';

    return $wpdb->get_results("SELECT * FROM $table_name");
}

function mentory_get_all_areas() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'areas';

    return $wpdb->get_results("SELECT * FROM $table_name");
}


// Funciones de Masterclass
function mentory_create_masterclass() {
    $controller = new Masterclass_Controller();
    $controller->create_masterclass();
}

function mentory_list_masterclass() {
    $controller = new Masterclass_Controller();
    $controller->list_masterclass();
}

function mentory_edit_masterclass() {
    if (isset($_GET['masterclass_id'])) {
        $masterclass_id = intval($_GET['masterclass_id']);
        $controller = new Masterclass_Controller();
        $controller->edit_masterclass($masterclass_id);
    } else {
        wp_die('Masterclass no encontrada.');
    }
}

function mentory_delete_masterclass() {
    if (isset($_GET['masterclass_id'])) {
        $masterclass_id = intval($_GET['masterclass_id']);
        $controller = new Masterclass_Controller();
        $controller->delete_masterclass($masterclass_id);
    }
}












// Reescritura de URL personalizada para masterclass
function mentory_masterclass_rewrite_rules() {
    // Regla para mostrar todas las masterclass
    add_rewrite_rule(
        '^masterclass/?$',
        'index.php?all_masterclass=true',
        'top'
    );

    // Regla para mostrar detalles de una masterclass
    add_rewrite_rule(
        '^masterclass/([^/]+)/?$',
        'index.php?masterclass_slug=$matches[1]',
        'top'
    );
}
add_action('init', 'mentory_masterclass_rewrite_rules');

function mentory_masterclass_query_vars($vars) {
    $vars[] = 'all_masterclass';
    $vars[] = 'masterclass_slug';
    return $vars;
}
add_filter('query_vars', 'mentory_masterclass_query_vars');

// Plantilla para Masterclass
function mentory_masterclass_template_include($template) {
    $all_masterclass = get_query_var('all_masterclass');
    $masterclass_slug = get_query_var('masterclass_slug');
    
    error_log("Valor de masterclass_slug: " . $masterclass_slug); // Para verificar el slug

    if ($all_masterclass) {
        $new_template = locate_template('masterclass/index-masterclass.php');
        if (!empty($new_template)) {
            return $new_template;
        }
    }

    if ($masterclass_slug) {
        $masterclass = mentory_get_masterclass_by_slug($masterclass_slug);
        var_dump($masterclass);
        if ($masterclass) {
            $new_template = locate_template('masterclass/detail-masterclass.php');
            if (!empty($new_template)) {
                return $new_template;
            }
        }
    }

    return $template;
}
add_filter('template_include', 'mentory_masterclass_template_include');

// Función para obtener la masterclass por slug
function mentory_get_masterclass_by_slug($slug) {
    global $wpdb;
    $query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}masterclass WHERE slugMasterclass = %s", $slug);
    $masterclass = $wpdb->get_row($query);

    error_log("Masterclass obtenida: " . print_r($masterclass, true)); // Depuración

    return $masterclass;
}

// Función para vaciar las reglas de reescritura
function mentory_flush_rewrite_rules() {
    mentory_masterclass_rewrite_rules();
    flush_rewrite_rules();
}
add_action('init', 'mentory_flush_rewrite_rules');