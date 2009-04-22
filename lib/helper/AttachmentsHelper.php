<?php
/**
 * Output a List of Attachments
 *
 * @param string $attachments 
 * @return $result
 * @author Joshua Pruitt
 */
function attachments_list($attachments)
{
  $icons = array('application/msword' => 'word.png',
                 'image/jpeg'         => 'image.png',
                 'application/pdf'    => 'pdf.png');
  
  if (count($attachments > 0))
  {
    $result = '<ul>';

    foreach ($attachments as $attachment)
    {
      $filesize = ($attachment['size'] > 1024 ? round($attachment['size'] / 1024) . ' MB' : $attachment['size'] . ' KB');
      
      $result .= '<li>'
              .  image_tag('attachable/icons/' . $icons[$attachment['content_type']],
                           array('align' => 'absmiddle',
                                 'style' => 'margin-right: 5px;'))
              .  '<strong>' . link_to($attachment, 'uploads/attachments/' . $attachment['filename']) . '</strong>'
              .  '<br />'
              .  '<span class="file-size" style="font-style: italic;">' . $attachment['content_type'] . ' - ' . $filesize . '</span>'
              .  '</li>';
    }

    $result .= '</ul>';

    return $result;
  }

  return false;
}
