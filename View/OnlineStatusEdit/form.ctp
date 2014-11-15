<?php
/**
 * announcements edit form view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->Form->create(null);

//echo $this->Form->unlockField('Frame.id');
//echo $this->Form->unlockField('OnlineFrameSetting.id');
//echo $this->Form->unlockField('OnlineFrameSetting.display_visitor');
//echo $this->Form->unlockField('OnlineFrameSetting.display_login_user');
//echo $this->Form->unlockField('OnlineFrameSetting.display_registration_user');


echo $this->Form->input('Frame.id', array(
			'type' => 'hidden',
			'value' => (int)$frameId,
			'ng-model' => 'edit.data.Frame.id'
		)
	);

echo $this->Form->input('OnlineFrameSetting.id', array(
			'type' => 'hidden',
			'value' => (int)$online_frame_setting['OnlineFrameSetting']['id'],
			'ng-model' => 'edit.data.OnlineFrameSetting.id',
		)
	);

//オンラインユーザを表示する
echo $this->Form->input('OnlineFrameSetting.display_visitor', array(
			//'label' => false,
			'type' => 'checkbox',
//			'type' => 'hidden',
//			'label' => 'オンラインユーザを表示する',
//			'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
			'value' => $online_frame_setting['OnlineFrameSetting']['display_visitor'],
//			'value' => '',
			'ng-model' => 'edit.data.OnlineFrameSetting.display_visitor',
		)
	);

//ログインユーザを表示する
echo $this->Form->input('OnlineFrameSetting.display_login_user', array(
			//'label' => false,
			'type' => 'checkbox',
//			'type' => 'hidden',
//			'label' => 'ログインユーザを表示する',
//			'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
			'value' => $online_frame_setting['OnlineFrameSetting']['display_login_user'],
//			'value' => 'xxxxx',
			'ng-model' => 'edit.data.OnlineFrameSetting.display_login_user',
		)
	);
//リンク先参照回数を表示する
echo $this->Form->input('OnlineFrameSetting.display_registration_user', array(
			//'label' => false,
			'type' => 'checkbox',
//			'type' => 'hidden',
//			'label' => '登録ユーザを表示する',
//			'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
			'value' => $online_frame_setting['OnlineFrameSetting']['display_registration_user'],
//			'value' => '',
			'ng-model' => 'edit.data.OnlineFrameSetting.display_registration_user',
		)
	);

echo $this->Form->end();
