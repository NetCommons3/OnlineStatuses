<?php
/**
 * online-statuses manage template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="panel panel-default">
<div class="panel-body">
<form action="/OnlineStatuses/online_status_edit/view/<?php echo $frameId; ?>/"
	  id="OnlineStatusFormForm<?php echo $frameId; ?>">

	<div class='form-group'>
		<?php
			//オンラインユーザを表示する
			echo $this->Form->input('OnlineFrameSetting.display_visitor', array(
						'type' => 'checkbox',
						'label' => 'オンラインユーザを表示する',
						'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
						'ng-model' => 'edit.data.OnlineFrameSetting.display_visitor',
					)
				);
		?>
	</div>

	<div class='form-group'>
		<?php
			//ログインユーザを表示する
			echo $this->Form->input('OnlineFrameSetting.display_login_user', array(
						'type' => 'checkbox',
						'label' => 'ログインユーザを表示する',
						'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
						'ng-model' => 'edit.data.OnlineFrameSetting.display_login_user',
					)
				);
		?>
	</div>

	<div class='form-group'>
		<?php
			//リンク先参照回数を表示する
			echo $this->Form->input('OnlineFrameSetting.display_registration_user', array(
						'type' => 'checkbox',
						'label' => '登録ユーザを表示する',
						'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
						'ng-model' => 'edit.data.OnlineFrameSetting.display_registration_user',
					)
				);
		?>
	</div>
</form>
	<!-- debug -->
	<pre>{{edit|json}}</pre>
</div>
</div>

<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="cancel()" ng-disabled="sending">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('net_commons', 'Cancel'); ?>
	</button>

	<button type="button" class="btn btn-primary" ng-click="save()" ng-disabled="sending">
		設定する
	</button>
</p>
