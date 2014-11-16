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

echo $this->Form->input('Frame.id', array(
			'type' => 'hidden',
			'value' => (int)$frameId,
			'ng-model' => 'edit.data.Frame.id'
		)
	);

echo $this->Form->input('OnlineFrameSetting.id', array(
			'type' => 'hidden',
			'value' => (int)$onlineFrameSetting['OnlineFrameSetting']['id'],
			'ng-model' => 'edit.data.OnlineFrameSetting.id',
		)
	);

//オンラインユーザを表示する
echo $this->Form->input('OnlineFrameSetting.display_visitor', array(
			'type' => 'checkbox',
			'value' => $onlineFrameSetting['OnlineFrameSetting']['display_visitor'],
			'ng-model' => 'edit.data.OnlineFrameSetting.display_visitor',
		)
	);

//ログインユーザを表示する
echo $this->Form->input('OnlineFrameSetting.display_login_user', array(
			'type' => 'checkbox',
			'value' => $onlineFrameSetting['OnlineFrameSetting']['display_login_user'],
			'ng-model' => 'edit.data.OnlineFrameSetting.display_login_user',
		)
	);
//リンク先参照回数を表示する
echo $this->Form->input('OnlineFrameSetting.display_registration_user', array(
			'type' => 'checkbox',
			'value' => $onlineFrameSetting['OnlineFrameSetting']['display_registration_user'],
			'ng-model' => 'edit.data.OnlineFrameSetting.display_registration_user',
		)
	);

echo $this->Form->end();
