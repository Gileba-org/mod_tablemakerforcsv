<?php
/**
* @Author  Mostafa Shahiri
* @license	GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die();

// Include the helper class
use Joomla\CMS\Helper\ModuleHelper;

// Params
$fileurl=$params->get('fileurl');
$separator=$params->get('separator');
$min_char=(int) $params->get('min_char');
$captions=$params->get('caption');
$table_style=$params->get('table_style');
$pretext=$params->get('pretext');
$posttext=$params->get('posttext');
$lookup=$params->get('lookup');
$sortable=$params->get('sortable');
$styling=$params->get('styling');
$textalign=$params->get('table_text_align');
$tablefont=$params->get('table_font');
$borderradius=$params->get('table_border_radius');
$padding=$params->get('table_padding');
$evenbg=$params->get('even_bg');
$oddbg=$params->get('odd_bg');
$firstrow_bg=$params->get('firstrow_bg');
$firstrow_color=$params->get('firstrow_color');
$firstrow_font=$params->get('firstrow_font');
$row_num=(int) $params->get('row_num');
$pagination=$params->get('pagination');
$pagalign=$params->get('pagalign');
$paglink_bg=$params->get('paglink_bg');
$paglink_color=$params->get('paglink_color');
$paglink_active=$params->get('paglink_active');
$paglink_hoverbg=$params->get('paglink_hoverbg');
$paglink_hovercolor=$params->get('paglink_hovercolor');
$moduleclass_sfx = "";
if (!empty($params->get('moduleclass_sfx'))) {
    $moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
}

if (!empty($captions)) {
    if (!empty(trim($captions))) {
        $caption=explode('@#',$captions);
    }
}

$tags = array();
$attribs = array();
if ($params->get('allow_html')) {
    $allowed_tags = $params->get('allowed_tags');
    if (!empty(trim($allowed_tags))) {
        $tags=explode(',',$allowed_tags);
    }
    $allowed_attribs = $params->get('allowed_attribs');
    if (!empty(trim($allowed_attribs))) {
        $attribs=explode(',',$allowed_attribs);
    }
}


// Display the template
require ModuleHelper::getLayoutPath('mod_tablemakerforcsv');
