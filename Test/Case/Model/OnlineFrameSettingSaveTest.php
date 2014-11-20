<?php
/**
 * OnlineFrameSettingSave Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('OnlineFrameSetting', 'OnlineStatuses.Model');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');

/**
 * OnlineFrameSetting Model Test Case
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\OnlineStatuses\Test\Case\Model
 */
class OnlineFrameSettingSaveTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.OnlineStatuses.OnlineFrameSetting',
		'plugin.OnlineStatuses.frame',
		'plugin.OnlineStatuses.block',
		'plugin.OnlineStatuses.plugin',
		'plugin.frames.box',
		'plugin.frames.language',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OnlineFrameSetting = ClassRegistry::init('OnlineStatuses.OnlineFrameSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OnlineFrameSetting);
		parent::tearDown();
	}

/**
 * __assertGetOnlineFrameSetting method
 *
 * @param array $expected correct data
 * @param array $result result data
 * @return void
 */
	private function __assertGetOnlineFrameSetting($expected, $result) {
		$unsets = array(
			'created_user',
			'created',
			'modified_user',
			'modified'
		);

		//OnlineFrameSettingデータのテスト
		foreach ($unsets as $key) {
			if (array_key_exists($key, $result['OnlineFrameSetting'])) {
				unset($result['OnlineFrameSetting'][$key]);
			}
		}

		$this->assertArrayHasKey('OnlineFrameSetting', $result, 'Error ArrayHasKey OnlineFrameSetting');
		$this->assertEquals($expected['OnlineFrameSetting'], $result['OnlineFrameSetting'], 'Error Equals OnlineFrameSetting');
	}

/**
 * testSaveOnlineFrameSetting method
 *
 * @return void
 */
	public function testSaveOnlineFrameSetting() {
		$frameId = 1;
		/*
		Array
		(
			[OnlineFrameSetting] => Array
				(
					[id] => 1
					[display_visitor] => true
					[display_login_user] => true
					[display_registration_user] => true
				)
			[Frame] => Array
				(
					[id] => 5
				)
		)
		*/
		$postData = array(
			'OnlineFrameSetting' => array(
				'id' => 1,
				'display_visitor' => 'true',
				'display_login_user' => 'true',
				'display_registration_user' => 'true',
			),
			'Frame' => array(
				'id' => $frameId,
			)
		);

		//登録
		$result = $this->OnlineFrameSetting->saveOnlineFrameSetting($postData);
		$this->assertArrayHasKey('OnlineFrameSetting', $result, 'Error seveOnlineFrameSetting');

		//取得
		$onlineFrameSetting = $this->OnlineFrameSetting->getOnlineFrameSetting($frameId);

		$expected = array(
			'OnlineFrameSetting' => array(
				'id' => 1,
				'frame_key' => 'frame_1',
				'display_visitor' => 1,
				'display_login_user' => 1,
				'display_registration_user' => 1,
			)
		);

		$this->__assertGetOnlineFrameSetting($expected, $onlineFrameSetting);
	}
}
