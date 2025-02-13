<?php
global $wpdb;
$areas = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}areas");

?>

<div class="wrap">
    <h1 class="wp-heading-inline">Lista de Áreas</h1> <br>
    <a href="<?php echo admin_url('admin.php?page=mentory-create-area'); ?>" class="page-title-action">Agregar Nueva Área</a>
    
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
                <th scope="col" class="manage-column">Nombre del Área</th>
                <th scope="col" class="manage-column">Slug</th>
                <th scope="col" class="manage-column">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($areas): ?>
                <?php foreach ($areas as $area): ?>
                    <tr>
                        <td><?php echo esc_html($area->name); ?></td>
                        <td><?php echo esc_html($area->slug); ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=mentory-edit-area&area_id=' . $area->id); ?>">Editar</a> |
                            <a href="<?php echo admin_url('admin.php?page=mentory-delete-area&area_id=' . $area->id); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta área?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay áreas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
