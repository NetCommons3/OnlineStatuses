/**
 * OnlineStatuses.edit Test
 *
 * @return {void}
 */
describe('OnlineStatuses.edit Test', function() {

  /*
   * beforeEach it毎の前処理
   */
  //load module
  beforeEach(module('NetCommonsApp'));

  //controller
  beforeEach(inject(function($controller) {
    //spec body
    var frameId = 1;
    scope = {
      online_status: {
        OnlineFrameSetting: {
          id: 1,
          display_visitor: 'true',
          display_login_user: 'true',
          display_registration_user: 'true'
        }
      }
    };
    scope.frameId = frameId;
    var OnlineStatusesEditController =
        $controller('OnlineStatuses.edit', { $scope: scope });
    expect(OnlineStatusesEditController).toBeDefined();
  }));

  /*
   * Test Case
   */
  it('OnlineStatuses.edit#initialize()', inject(function($controller) {

    //$scope.edit.data = {
    //  OnlineFrameSetting: {
    //    id:
    //      $scope.online_status.OnlineFrameSetting.id,
    //    display_visitor:
    //      $scope.online_status.OnlineFrameSetting.display_visitor,
    //    display_login_user:
    //      $scope.online_status.OnlineFrameSetting.display_login_user,
    //    display_registration_user:
    //      $scope.online_status.OnlineFrameSetting.
    //        display_registration_user
    //  },
    //  Frame: {
    //    id: $scope.frameId
    //  },
    //  _Token: {
    //    key: '',
    //    fields: '',
    //    unlocked: ''
    //  }
    //};

    scope.initialize();
    // 同一値チェック
    expect(scope.edit.data.OnlineFrameSetting.id)
      .toBe(scope.online_status.OnlineFrameSetting.id);
    expect(scope.edit.data.OnlineFrameSetting.display_visitor)
      .toBe(scope.online_status.OnlineFrameSetting.display_visitor);
    expect(scope.edit.data.OnlineFrameSetting.display_login_user)
      .toBe(scope.online_status.OnlineFrameSetting.display_login_user);
    expect(scope.edit.data.OnlineFrameSetting.display_registration_user)
      .toBe(scope.online_status.OnlineFrameSetting.display_registration_user);
    expect(scope.edit.data.Frame.id).toBe(scope.frameId);
    expect(scope.edit.data._Token.key).toBe('');
    expect(scope.edit.data._Token.fields).toBe('');
    expect(scope.edit.data._Token.unlocked).toBe('');
  }));

});
