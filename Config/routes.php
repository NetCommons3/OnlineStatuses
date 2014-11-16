<?php
/**
 * OnlineStatuses routes configuration
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

Router::connect('/auth/:action', array(
	'plugin' => 'auth', 'controller' => 'auth'
));
