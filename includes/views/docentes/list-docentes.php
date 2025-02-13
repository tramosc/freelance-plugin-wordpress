<?php
$docente_controller = new Docente_Controller();
$docentes = $docente_controller->get_all_docentes();
?>

<div class="wrap">
    <h1 class="wp-heading-inline">Lista de Docentes</h1> <br>
    <a href="<?php echo admin_url('admin.php?page=mentory-create-docente'); ?>" class="page-title-action">Agregar Nuevo Docente</a>
    
    <table class="wp-list-table widefat fixed striped posts">
    <thead>
        <tr>
            <th scope="col" class="manage-column">Nombre</th>
            <th scope="col" class="manage-column">Apellidos</th>
            <th scope="col" class="manage-column">Cargo</th>
            <th scope="col" class="manage-column">Foto</th>
            <th scope="col" class="manage-column">Acciones</th>
        </tr>
    </thead>
        <tbody>
            <?php if ($docentes): ?>
                <?php foreach ($docentes as $docente): ?>
                    <tr>
                    <td><?php echo esc_html($docente->nombre); ?></td>
                    <td><?php echo esc_html($docente->apellidos); ?></td>
                    <td><?php echo esc_html($docente->cargo); ?></td>
                    <td>
                        <?php if (!empty($docente->foto_url)): ?>
                            <img src="<?php echo esc_url($docente->foto_url); ?>" alt="<?php echo esc_attr($docente->nombre); ?>" width="50">
                        <?php else: ?>
                            No disponible
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=edit_docente&id=' . $docente->id); ?>">Editar</a>
                        <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=delete_docente&id=' . $docente->id), 'delete_docente_' . $docente->id); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este docente?');">Eliminar</a>
                    </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay Docentes registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
