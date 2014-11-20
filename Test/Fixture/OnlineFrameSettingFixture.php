<?php
/**
 * OnlineFrameSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * OnlineFrameSettingFixture
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\OnlineStatuses\Test\Case\Model
 */
class OnlineFrameSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
		'display_visitor' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'display visitor, 1: display or 0: no display | 閲覧ユーザの表示  0:表示しない、1:表示する | | '),
		'display_login_user' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'display login user, 1: display or 0: no display | ログインユーザの表示  0:表示しない、1:表示する'),
		'display_registration_user' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'display registration user, 1: display or 0: no display | 登録ユーザの表示  0:表示しない、1:表示する'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_online_frame_settings_frames1_idx' => array('column' => 'frame_key', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'frame_key' => 'frame_1',
			'display_visitor' => 0,
			'display_login_user' => 0,
			'display_registration_user' => 0,
			'created_user' => '1',
			'created' => '2014-10-09 16:07:57',
			'modified_user' => '1',
			'modified' => '2014-10-09 16:07:57'
		),
		array(
			'id' => 2,
			'frame_key' => 'frame_2',
			'display_visitor' => 1,
			'display_login_user' => 1,
			'display_registration_user' => 1,
			'created_user' => '1',
			'created' => '2014-10-09 16:07:57',
			'modified_user' => '1',
			'modified' => '2014-10-09 16:07:57'
		),
	);

}
