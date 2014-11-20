<?php
/**
 * OnlineStatusEdit Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('OnlineStatusesAppController', 'OnlineStatuses.Controller');

/**
 * OnlineStatusEdit Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package app.Plugin.OnlineStatuses.Controller
 */
class OnlineStatusEditController extends OnlineStatusesAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'OnlineStatuses.OnlineFrameSetting',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
	);

/**
 * beforeFilter
 *
 * @return void
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0) {
		$this->view($frameId);

		//viewにセット
		$this->set('frameId', $frameId);

		return $this->render('OnlineStatusEdit/form', false);
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0) {
		if ($this->response->statusCode() !== 200) {
			return $this->render(false);
		}
		//取得
		$onlineFrameSetting = $this->OnlineFrameSetting->getOnlineFrameSetting($frameId);

		//viewにセット
		$this->set('onlineFrameSetting', $onlineFrameSetting);

		return $this->render('OnlineStatusEdit/view', false);
	}

/**
 * post method
 *
 * @return string JSON that indicates success
 * @throws MethodNotAllowedException
 * @throws ForbiddenException
 */
	public function edit() {
		if (! $this->request->isPost()) {
			throw new MethodNotAllowedException();
		}

		$postData = $this->data;
		$frameId = (isset($postData['Frame']['id']) ? (int)$postData['Frame']['id'] : 0);
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException();
		}

		//登録
		$result = $this->OnlineFrameSetting->saveOnlineFrameSetting($postData);
		if (! $result) {
			throw new ForbiddenException(__d('net_commons', 'Failed to register data.'));
		}

		//取得
		$onlineFrameSetting = $this->OnlineFrameSetting->getOnlineFrameSetting($frameId);

		$result = array(
			'name' => __d('net_commons', 'Successfully finished.'),
			'onlineFrameSetting' => $onlineFrameSetting,
		);

		$this->set(compact('result'));
		$this->set('_serialize', 'result');
		return $this->render(false);
	}
}
