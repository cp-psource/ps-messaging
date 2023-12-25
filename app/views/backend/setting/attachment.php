<h4><?php _e("Welche Rollen können Anhänge hochladen?", mmg()->domain) ?></h4>
<?php $form = new IG_Active_Form($model);
$form->open(array("attributes" => array("class" => "form-horizontal"))); ?>
<input type="hidden" name="<?php echo $form->build_name('allow_attachment') ?>[]" value="">
<table class="table table-condensed table-hover">
    <thead>
    <tr>
        <th><?php _e("Rollenname", mmg()->domain) ?></th>
        <th><?php _e("Kann hochladen", mmg()->domain) ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $roles = get_editable_roles();
    foreach ($roles as $key => $role): ?>
        <?php if (isset($role['capabilities']['upload_files']) && $role['capabilities']['upload_files'] == false || !isset($role['capabilities']['upload_files'])): ?>
            <?php $is = in_array($key, $model->allow_attachment); ?>
            <tr>
                <td><?php echo $role['name'] ?></td>
                <td>
                    <?php
                    $form->checkbox('allow_attachment', array(
                        'multiple' => true,
                        'checked' => $is,
                        'attributes' => array(
                            'value' => $key
                        )
                    )) ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>
<?php wp_nonce_field('mm_settings', '_mmnonce') ?>
<button type="submit" class="btn btn-primary"><?php _e("Änderungen speichern", mmg()->domain) ?></button>
<?php $form->close() ?>