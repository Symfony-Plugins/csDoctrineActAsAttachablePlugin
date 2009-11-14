<?php use_helper('jQuery') ?>
<?php use_helper('Form') ?>
<?php $sf_response->addJavascript('/sfProtoculousPlugin/js/prototype.js'); ?>
<?php $sf_response->addStylesheet('/csDoctrineActAsAttachablePlugin/css/attachments.css'); ?>

<div id='attachments_display'>

<?php if (count($types)): ?>
	<?php foreach ($types as $type): ?>

	<?php $type_form = $type . '_form' ?>
	
	<?php include_component('csAttachable','attachments_group', 
			array('table' => $table, 
						'attachments' => $$type, 
						'attachment' => $$type_form,
						'type'			=> $type, 
						'form' => $form)) ?>
		
	<?php endforeach ?>
<?php else: ?>
	<?php include_component('csAttachable','attachments_group', 
			array('table' => $table, 
             'attachments' => $attachments, 
						'attachment' => $attachment,
						'type'		=> '', 
						'form' => $form)) ?>
<?php endif ?>

<script>
function attachment_refresh_form()
{
  jQuery('#attachments_display').load('<?php echo url_for("@cs_attachable_refresh?table=".$table."&object_id=".$form->getObject()->getId()); ?>')
}
</script>
</div>

<iframe name="hiddenIframe" style="display: none" ></iframe>