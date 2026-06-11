let id_input = document.querySelector('#id_input');
let ps_input = document.querySelector('#ps_input');
let btn1 = document.querySelector('#btn1');
let result = document.querySelector('#result');

btn1.addEventListener('click', function () {

    const regId = /^[a-zA-Z0-9]{4,12}$/;
    const regPw = /^.{8,}$/;

    if (!regId.test(id_input.value)) {
        result.textContent = '아이디 형식 오류';
        return;
    }

    if (!regPw.test(ps_input.value)) {
        result.textContent = '비밀번호 형식 오류';
        return;
    }

    result.textContent = '가입 성공!';

});