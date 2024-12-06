<!-- includes/views/programs/list-programs.php -->
<div class="wrap">
    <h1>Lista de Programas</h1>
    <?php if ($programs): ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Área</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programs as $program): ?>
                    <tr>
                        <td><?php echo esc_html($program->name); ?></td>
                        <td><?php echo esc_html($program->slug); ?></td>
                        <td><?php echo esc_html($program->area_name); ?></td>
                        <td>
                            <a href="?page=mentory-edit-program&program_id=<?php echo esc_attr($program->id); ?>">Editar</a> |
                            <a href="?page=mentory-delete-program&program_id=<?php echo esc_attr($program->id); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este programa?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron programas.</p>
    <?php endif; ?>
</div>