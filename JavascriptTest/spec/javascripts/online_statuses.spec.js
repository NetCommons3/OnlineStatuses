/**
 * OnlineStatuses Test
 *
 * @return {void}
 */
describe('OnlineStatuses Test', function() {

  /*
   * beforeEach it毎の前処理
   */
  //load module
  beforeEach(module('NetCommonsApp'));

  //controller
  beforeEach(inject(function($controller) {
    //spec body
    scope = {};
    var OnlineStatusesController =
        $controller('OnlineStatuses', { $scope: scope });
    expect(OnlineStatusesController).toBeDefined();
  }));

  /*
   * Test
   */
  it('OnlineStatuses#initialize()', inject(function($controller) {
    var frameId = 1;
    var online_status = 'test value';
    scope.initialize(frameId, online_status);

    // 同一値チェック
    expect(scope.frameId).toBe(frameId);
    expect(scope.visibleManage).toBe(false);
    expect(scope.online_status).toBe(online_status);
  }));
});
