<div class="field">
    <div class="field_meta">
        <table class="widefat">
            <tr>
                <td class="field_order">

                </td>
                <td class="field_label">
                    <a class="cstmfield_edit_field row-title"><?php echo esc_html( $field->label ); ?></a>
                </td>
                <td class="field_name">
                    <?php echo esc_html( $field->name ); ?>
                </td>
                <td class="field_type">
                    <a class="cstmfield_edit_field"><?php echo esc_html( $field->type ); ?></a>
                </td>
            </tr>
        </table>
    </div>

    <div class="field_form">
        <table class="widefat">
            <tbody>
                <tr class="field_basics">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="field_label">
                                    <label>
                                        <?php _e( 'Label', 'worplex-frame' ); ?>
                                        <div class="cstmfield_tooltip">?
                                            <div class="tooltip_inner"><?php _e( 'The field label that editors will see.', 'worplex-frame' ); ?></div>
                                        </div>
                                    </label>
                                    <input type="text" name="cstmfield[fields][<?php echo $field->weight; ?>][label]" value="<?php echo empty( $field->id ) ? '' : esc_attr( $field->label ); ?>" />
                                </td>
                                <td class="field_name">
                                    <label>
                                        <?php _e( 'Name', 'worplex-frame' ); ?>
                                        <div class="cstmfield_tooltip">?
                                            <div class="tooltip_inner">
                                                <?php _e( 'The field name is passed into get() to retrieve values. Use only lowercase letters, numbers, and underscores.', 'worplex-frame' ); ?>
                                            </div>
                                        </div>
                                    </label>
                                    <input type="text" name="cstmfield[fields][<?php echo $field->weight; ?>][name]" value="<?php echo empty( $field->id ) ? '' : esc_attr( $field->name ); ?>" />
                                </td>
                                <td class="field_type">
                                    <label><?php _e( 'Field Type', 'worplex-frame' ); ?></label>
                                    <select name="cstmfield[fields][<?php echo $field->weight; ?>][type]">
                                        <?php foreach ( WORPLEX_CFS()->fields as $type ) : ?>
                                        <?php $selected = ($type->name == $field->type) ? ' selected' : ''; ?>
                                        <option value="<?php echo $type->name; ?>"<?php echo $selected; ?>><?php echo $type->label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <?php WORPLEX_CFS()->fields[ $field->type ]->options_html( $field->weight, $field ); ?>

                <tr class="field_notes">
                    <td class="label">
                        <label>
                            <?php _e( 'Notes', 'worplex-frame' ); ?>
                            <div class="cstmfield_tooltip">?
                                <div class="tooltip_inner"><?php _e( 'Notes for editors during data entry', 'worplex-frame' ); ?></div>
                            </div>
                        </label>
                    </td>
                    <td>
                        <textarea name="cstmfield[fields][<?php echo $field->weight; ?>][notes]"><?php echo esc_textarea( $field->notes ); ?></textarea>
                    </td>
                </tr>
                <tr class="field_actions">
                    <td class="label"></td>
                    <td style="vertical-align:middle">
                        <input type="hidden" name="cstmfield[fields][<?php echo $field->weight; ?>][id]" class="field_id" value="<?php echo $field->id; ?>" />
                        <input type="hidden" name="cstmfield[fields][<?php echo $field->weight; ?>][parent_id]" class="parent_id" value="<?php echo $field->parent_id; ?>" />
                        <input type="button" value="<?php _e( 'Close', 'worplex-frame' ); ?>" class="button-secondary cstmfield_edit_field" />
                        &nbsp; -<?php _e( 'or', 'worplex-frame' ); ?>- &nbsp; <span class="cstmfield_delete_field"><?php _e( 'delete', 'worplex-frame' ); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>