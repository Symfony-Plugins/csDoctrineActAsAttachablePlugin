<fieldset id="sf_fieldset_attachments<?php echo $type ? '_'.strtolower($type) : '' ?>">
  <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_attachments<?php echo $type ? '_'.strtolower($type) : '' ?>">
    <h2><?php echo trim($type. ' Attachments') ?></h2>
    <ul class="attachment">
    <?php foreach ($attachments->getEmbeddedForms() as $embedded): ?>
      <li>
        <?php include_partial('csAttachable/attachment_edit_item', array('attachment' => $embedded->getObject(), 'object' => $form->getObject(), 'table' => $table)) ?>
      </li>
    <?php endforeach ?>
    </ul>
    
    
    <?php echo form_tag( '@cs_attachable_save?object_id='.$form->getObject()->getId().'&table='.$table.'&attachment_type='.$type,
                     array('id' => 'addAttachment'.$type,
                           'name' => 'addAttachment'.$type,
                           'enctype' => 'multipart/form-data',
                           'target' => 'hiddenIframe'
    )) ?>

  <div style='display:block'>
  <?php echo $attachment ?>
  </div>

  <?php echo submit_tag($attachment->getButton(), array('id' => 'btn_submit')) ?>

  <div id='indicator' style='display:none;'>
    <?php echo image_tag(sfConfig::get('app_icons_loader'), array('alt' => 'loading')) ?>
    Loading...
  </div>
  </form>
  </div>
</fieldset>

