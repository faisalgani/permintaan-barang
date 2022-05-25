export function toRegister(){
    var _login = $('#kt_login');
    var cls = 'login-signup-on';
    var form = 'validation_signup_form';

    _login.removeClass('login-forgot-on');
    _login.removeClass('login-signin-on');
    _login.removeClass('login-signup-on');

    _login.addClass(cls);

    KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');

}

export function toSign(){
    var _login = $('#kt_login');
    var cls = 'login-signin-on';
    var form = 'validation_signin_form';

    _login.removeClass('login-forgot-on');
    _login.removeClass('login-signin-on');
    _login.removeClass('login-signup-on');

    _login.addClass(cls);

    KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');

}