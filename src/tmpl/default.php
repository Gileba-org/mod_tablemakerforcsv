<?php
/**
* @Author  Mostafa Shahiri
* @license	GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();

// Libraries
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

// Custom JS
  if ($pagination) {
    $script="jQuery('document').ready(function(){pagination(".$row_num.");});";
  }

// Custom CSS
if ($styling) {
  $style=".csvtable".$moduleclass_sfx."{
    text-align:".$textalign.";
    font:".$tablefont.";
    border-radius:".$borderradius.";
    ".$table_style."
}
.csvtable".$moduleclass_sfx." td{
padding:".$padding.";
}
.csvtable".$moduleclass_sfx." tr:first-child  td{
background:".$firstrow_bg.";
color:".$firstrow_color.";
font:".$firstrow_font.";
}
.csvtable".$moduleclass_sfx." tr:nth-child(even) td{
    background: ".$evenbg.";
}
.csvtable".$moduleclass_sfx." tr:nth-child(odd) td{
    background: ".$oddbg.";
}
#csvpagination a{
background:".$paglink_bg.";
color:".$paglink_color.";
margin:5px;
}
#csvpagination a.active{
background:".$paglink_active.";
}
#csvpagination a:hover{
background:".$paglink_hoverbg.";
color:".$paglink_hovercolor.";
}
#csvpagination{
text-align:".$pagalign.";}";
}

// Load custom code
$document = Factory::getDocument();
  if ($pagination) {
$document->addCustomTag( '<script type="text/javascript">'.$script.'</script>' );
}
  if ($styling) {
$document->addStyleDeclaration($style);
}
  if ($lookup || $pagination) {
$document->addScript('modules/mod_tablemakerforcsv/js/jquery.dataTables.min.js');
}

// The template
if ($pretext !== "") {
  if (trim($pretext)!=="") {
    echo '<div class="pretext">'.$pretext.'</div>';
  }
}

if ($fileurl!=="") {
  $file = fopen('images/'.$fileurl,"r");
  if ($lookup) {
    echo '<input type="text" id="csvlookup" onkeyup="lookuptable('.$row_num.','.$min_char.')" placeholder="' . Text::_('MOD_TABLEMAKERFORCSV_SEARCHFOR') . '"><br/>';
  }

  echo '<table class="csvtable'.$moduleclass_sfx.'" id="csvtable">';

  if ($captions !== "") {
    if (trim($captions)!=="") {
      echo '<tr>';
      for ($i=0; $i<count($caption); $i++)
      {
        echo '<td>'.$caption[$i].'</td>';
      }
      echo '</tr>';
    }
  }

  while ($f=fgetcsv($file,1000,$separator)) {
    echo '<tr>';
    for ($i=0; $i<count($f); $i++) {
      echo '<td>'.$f[$i].'</td>';
    }
    echo '</tr>';
  }

  echo '</table>';

  if ($pagination) {
    echo	'<div id="csvpagination"></div>';
  }

  fclose($file);
}

if ($posttext !== "") {
  if (trim($posttext)!=="") {
    echo '<div class="posttext">'.$posttext.'</div>';
  }
}
