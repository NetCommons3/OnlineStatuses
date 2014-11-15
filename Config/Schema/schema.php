<?php
class AppSchema extends CakeSchema {

	public $connection = 'master';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $online_frame_settings = array(
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

}
