<?php $title = $attachment->getTitle() ? $attachment->getTitle() : $attachment->getUrl() ?>

<?php echo link_to($title, image_path($attachment->getAttachmentRoute()), 'class=link target=_blank') ?>

<?php echo link_to_remote('delete', 
            array(
              'url' => '@cs_attachable_delete?attachment_id='.$attachment->getId().
                                     '&object_id='.$object->getId().
                                     '&table='.$table,
              'update' => 'attachments_display',
                 'loading'  => "Element.show('indicator'); Element.hide('btn_submit')",
                 'complete' => "Element.hide('indicator'); Element.show('btn_submit')"
            ), 
            array('class' => 'delete', 'confirm' => 'Are you sure?')
        ) ?>