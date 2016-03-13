<?php
/**
 * @copyright	Copyright (c) 2013 einsatzkomponente.de. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_firefighters/assets/css/firefigthers.css');

// Helper-class laden
require_once JPATH_SITE.'/administrator/components/com_firefighters/helpers/firefighters.php'; 

$app                = JFactory::getApplication();
$params_com       		= $app->getParams('com_firefighters');



		// Funktion : die X Termine aus DB laden
		$query = 'SELECT * FROM #__firefighters_termine WHERE state = "1" AND DATE_ADD(datum_start, INTERVAL 3 HOUR) > Current_TimeStamp ORDER BY datum_start ASC LIMIT '.$count.' ' ;
		$db	= JFactory::getDBO();
		$db->setQuery( $query );
		$termine = $db->loadObjectList(); 


$counter = count($termine);
$mymenuitem = $params->get('mymenuitem'); // Menü-Eintrag
$show_termin_detail = $params->get('show_termin_detail');

?>
<style type="text/css"><?php echo $params->get('css');?></style>

<<?php echo $params->get('module_tag');?> class="eiko_last<?php echo $moduleclass_sfx ?>" 
<?php if ($params->get('backgroundimage')) : ?> style="background-image:url(<?php echo $params->get('backgroundimage');?>)"<?php endif;?> >

<table class="mod_ftm_tab">

<?php
if ($termine):
$a = 0;
while($a < $counter)
   {
$curTime = strtotime($termine[$a]->datum_start); 
$termine[$a]->beschreibung = (strlen($termine[$a]->beschreibung) > 100) ? substr($termine[$a]->beschreibung,0,strrpos(substr($termine[$a]->beschreibung,0,100+1),' ')).' ...' : $termine[$a]->beschreibung;
   ?>
   
	<tr class="mod_ftm_tr">
	<td class="mod_ftm_td">  

  
  <?php 
	  $start_time = date('H:i', $curTime);
	  echo '<span class="glyphicon glyphicon-time" style="margin-right:3px;"></span>'.date('d.m.Y ', $curTime);
	  if ($start_time != '00:00') :
	  echo'@ '.date('H:i ', $curTime).' Uhr';
	  endif;
	  echo '</br>';
  ?>
  
  <?php if ($show_termin_detail=='1'):; ?>
           <a href="<?php echo JRoute::_('index.php?option=com_firefighters&Itemid='.$mymenuitem.'&view=termin&id=' . (int)$termine[$a]->id); ?>">
		   <?php echo '<span class="mod_ftm_termin_name">'.$termine[$a]->name.'</span></br>';?>
		   </a>
           <?php else:?>
           <?php echo '<span  class="mod_ftm_termin_name">'.$termine[$a]->name.'</span></br>';?>
           <?php endif;?>

  


        <?php
			//Support for multiple or not foreign key field: auswahlorga
			$termine[$a]->abteilungen = explode(',',$termine[$a]->abteilungen);
					$data = array();
					foreach($termine[$a]->abteilungen as $value):
						$db = JFactory::getDbo();
						$query	= $db->getQuery(true);
						$query
							->select('*')
							->from('`#__firefighters_abteilungen`')
							->where('id = "' .$value.'"');
						$db->setQuery($query);
						$results = $db->loadObjectList();
						if(count($results)){
							$data[] = $results[0]->name; 
							
							echo '<font color="'.$results[0]->abteilung_farbe.'">'.$results[0]->name.'</font color></br>';
							
						}
					endforeach;
					//echo implode(',',$data); ?>
  
     </td></tr>

   <?php
   $a++;
   }
   ?>
   <?php
else:
echo '<tr class="mod_ftm_tr"><td class="mod_ftm_td">keine Termine vorhanden</td></tr>';
endif;
?>

</table>

</<?php echo $params->get('module_tag');?>>



