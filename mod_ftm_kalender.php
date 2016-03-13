<?php
/**
 * @copyright	@copyright	Copyright (c) 2013 einsatzkomponente.de. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$class_sfx = htmlspecialchars($params->get('class_sfx'));
$count = htmlspecialchars($params->get('count'));

require(JModuleHelper::getLayoutPath('mod_ftm_kalender', $params->get('layout', 'default')));