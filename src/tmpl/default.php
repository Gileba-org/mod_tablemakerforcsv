<?php
/**
* @Author  Mostafa Shahiri
* @license	GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();

// Libraries
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Filter\InputFilter;

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
.csvtable".$moduleclass_sfx." th,.csvtable".$moduleclass_sfx." td{
padding:".$padding.";
}
.csvtable".$moduleclass_sfx." tr th,.csvtable".$moduleclass_sfx." tr th a{
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
  $document->addCustomTag('<script type="text/javascript">'.$script.'</script>');
}
if ($styling) {
  $document->addStyleDeclaration($style);
}
if ($lookup || $pagination) {
  $document->addScript('modules/mod_tablemakerforcsv/js/jquery.dataTables.min.js');
}
//if (sortable) { /* ToDo */
  $document->addScript('modules/mod_tablemakerforcsv/js/tablesort.js');

// The template
if (!empty($pretext)) {
  if (!empty(trim($pretext))) {
    echo '<div class="pretext">'.$pretext.'</div>';
  }
}

if (!empty($fileurl)) {
  if (file_exists($fileurl)) {
    $file = fopen($fileurl,"r");
    if ($lookup) {
      echo '<input type="text" id="csvlookup" onkeyup="lookuptable('.$row_num.','.$min_char.')" placeholder="' . Text::_('MOD_TABLEMAKERCSV_SEARCHFOR') . '"><br /><br />';
    }

    echo '<table class="csvtable'.$moduleclass_sfx.' sortable" id="csvtable">';
    $j=0;

    if (!empty($captions)) {
      $j=2;
      if (!empty(trim($captions))) {
        echo '<thead><tr>';
        $end = count($caption);
        for ($i=0; $i<$end; $i++)
        {
          echo '<th class="sortable">'.$caption[$i].'</th>';
        }
        echo '</tr></thead>';
      }
    }

    while ($f=fgetcsv($file,1000,$separator)) {
      $j++;echo ($j==1) ? '<thead><tr>' : '<tr>';
      $end = count($f);
      $filter = new InputFilter;
      for ($i=0; $i<$end; $i++) {
        echo ($j==1) ? '<th class="sortable">' : '<td>';
        echo $f[$i];//$filter->clean($f[$i], 'string');
        echo ($j==1) ? '</th>' : '</td>';
      }
      echo '</tr>';
      echo ($j==1) ? '</thead><tbody>' : '';
    }

    echo '</tbody></table>';

    if ($pagination) {
      echo '<div id="csvpagination"></div>';
    }

    fclose($file);
  }
}

if (!empty($posttext)) {
  if (!empty(trim($posttext))) {
    echo '<div class="posttext">'.$posttext.'</div>';
  }
}
