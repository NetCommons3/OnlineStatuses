<?php
/**
 * OnlineFrameSettingGet Test Case
 *
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
class OnlineFrameSettingGetTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.OnlineStatuses.OnlineFrameSetting',
		'plugin.OnlineStatuses.frame',
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
 * testGetOnlineFrameSetting method
 *
 * @return void
 */
	public function testGetOnlineFrameSetting() {
		$frameId = 2;

		//取得
		$result = $this->OnlineFrameSetting->getOnlineFrameSetting($frameId);

		$expected = array(
			'OnlineFrameSetting' => array(
				'id' => 2,
				'frame_key' => 'frame_2',
				'display_visitor' => 1,
				'display_login_user' => 1,
				'display_registration_user' => 1,
			)
		);

		$this->__assertGetOnlineFrameSetting($expected, $result);
	}

/**
 * testGetOnlineFrameSettingByNoFrameId method
 *
 * @return void
 */
	public function testGetOnlineFrameSettingByNoFrameId() {
		//取得
		$result = $this->OnlineFrameSetting->getOnlineFrameSetting();

		$expected = array(
			'OnlineFrameSetting' => array(
				'id' => 0,
				'frame_key' => '',
				'display_visitor' => 0,
				'display_login_user' => 0,
				'display_registration_user' => 0,
			)
		);

		$this->__assertGetOnlineFrameSetting($expected, $result);
	}
}
