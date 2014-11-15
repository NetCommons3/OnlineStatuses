<?php
/**
 * OnlineStatusEdit Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('OnlineStatusesAppController', 'OnlineStatuses.Controller');

/**
 * OnlineStatusEdit Controller
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\OnlineStatuses\Controller
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
	 */
	public function beforeFilter() {
//CakeLog::debug(print_r("beforeFilter:" . $this->response->statusCode(), true));
		parent::beforeFilter();
		$this->Auth->allow();

		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
//CakeLog::debug(print_r("beforeFilter002:", true));
			throw new ForbiddenException(__d('net_commons', 'Security Error! Unauthorized input.'));
		}
	}

	/**
	 * afterFilter
	 *
	 * @return void
	 */
//	public function afterFilter() {
//		parent::afterFilter();
//
//	}

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
		$online_frame_setting = $this->OnlineFrameSetting->getOnlineFrameSetting();

		//viewにセット
		$this->set('online_frame_setting', $online_frame_setting);

		return $this->render('OnlineStatusEdit/view', false);
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
	 * post method
	 *
	 * @return string JSON that indicates success
	 * @throws MethodNotAllowedException
	 * @throws ForbiddenException
	 */
//	public function edit($frameId = 0) {
	public function edit() {
//CakeLog::debug(print_r("edit-000:" . $this->response->statusCode(), true));

		if (! $this->request->isPost()) {
			throw new MethodNotAllowedException();
		}

		$postData = $this->data;
//unset($postData['OnlineFrameSetting']['id']);

		$frameId = (isset($postData['Frame']['id']) ? (int)$postData['Frame']['id'] : 0);
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException();
		}

//CakeLog::debug(print_r($postData, true));
		//登録
		$result = $this->OnlineFrameSetting->saveOnlineFrameSetting($postData);
//CakeLog::debug(print_r('====result====', true));
//CakeLog::debug(print_r($result, true));
		if (! $result) {
			throw new ForbiddenException(__d('net_commons', 'Failed to register data.'));
		}

//		$announcement = $this->OnlineFrameSetting->getOnlineFrameSetting(
//			$result['Announcement']['block_id'],
//			$this->viewVars['contentEditable']
//		);
		$online_frame_setting = $this->OnlineFrameSetting->getOnlineFrameSetting();

		$result = array(
			'name' => __d('net_commons', 'Successfully finished'),
			'online_frame_setting' => $online_frame_setting,
		);
//		$result = array(
//			'name' => __d('net_commons', 'Successfully finished.'),
//			'online_frame_setting' => $result,
//		);
//CakeLog::debug(print_r('====result====', true));
//CakeLog::debug(print_r(compact('result'), true));
//CakeLog::debug(print_r("edit-100:" . $this->response->statusCode(), true));

//		$this->response->statusCode(200);
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
//CakeLog::debug(print_r('====result2====', true));
		return $this->render(false);
//		return $this->render('OnlineStatusEdit/view', false);
	}
}