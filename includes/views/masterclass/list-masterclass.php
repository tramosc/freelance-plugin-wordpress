<!-- File: includes/views/masterclass/list-masterclass.php -->

<h1>Lista de Masterclasses</h1>
<table class="widefat fixed" cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Slug</th>
            <th>Hora de Inicio</th>
            <th>Fecha de Inicio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($masterclasses as $masterclass): ?>
            <tr>
                <td><?php echo esc_html($masterclass->nombreMasterclass); ?></td>
                <td><?php echo esc_html($masterclass->slugMasterclass); ?></td>
                <td><?php echo esc_html($masterclass->hora_inicio); ?></td>
                <td><?php echo esc_html($masterclass->fecha_inicio); ?></td>
                <td>
                    <a href="<?php echo admin_url('admin.php?page=mentory-edit-masterclass&masterclass_id=' . $masterclass->id); ?>">Editar</a> |
                    <a href="<?php echo admin_url('admin.php?page=mentory-delete-masterclass&masterclass_id=' . $masterclass->id); ?>" onclick="return confirm('¿Estás seguro de eliminar esta masterclass?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
