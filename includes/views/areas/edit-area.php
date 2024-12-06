<?php
// Verificar si se pasó un ID de área válido
if (isset($_GET['area_id'])) {
    global $wpdb;
    $area_id = intval($_GET['area_id']);
    
    // Obtener los datos del área desde la base de datos
    $area = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}areas WHERE id = %d", $area_id));

    if ($area): 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesar el formulario de edición
            $new_name = sanitize_text_field($_POST['name']);
            $new_slug = sanitize_title_with_dashes($new_name);

            // Actualizar los datos del área en la base de datos
            $wpdb->update(
                "{$wpdb->prefix}areas",
                array(
                    'name' => $new_name,
                    'slug' => $new_slug,
                ),
                array('id' => $area_id)
            );

            echo '<div class="updated"><p>Área actualizada correctamente.</p></div>';
            $area->name = $new_name;  // Actualizar el nombre del área en la variable local
        }
    endif;
} else {
    echo '<div class="error"><p>No se ha proporcionado un ID de área válido.</p></div>';
}
?>

<div class="wrap">
    <h1 class="wp-heading-inline">Editar Área</h1>

    <?php if (isset($area)): ?>
        <form method="POST">
            <table class="form-table">
                <tr>
                    <th><label for="name">Nombre del Área</label></th>
                    <td><input type="text" id="name" name="name" value="<?php echo esc_attr($area->name); ?>" required /></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="Actualizar Área" />
            </p>
        </form>
    <?php endif; ?>
</div>
