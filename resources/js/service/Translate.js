export function trans_registerForm(){
    let translate = {};
    translate.error = {};
    translate.error.required = {};
    translate.error.format = {};

	if(localStorage.getItem('language') == "ID") {
        translate.title = "Daftar";
        translate.subTitle = "Masukkan informasi dirimu untuk membuat akun baru";
        translate.firstName = "Nama Depan";
        translate.error.firstName = "Form Nama depan wajib diisi";
        translate.error.required.email = "Form Email wajib diisi";
        translate.error.required.password = "Password wajib diisi";
        translate.error.required.passwordConfirm = "Password konfirmasi wajib diisi";
        translate.error.format.email = "Form Email salah perhatikan kembali";
        translate.error.format.passwordConfirm = "Password konfirmasi tidak sama";
        translate.error.agree = 'Anda harus menerima peraturan yang berlaku';
        translate.error.message = "Maaf, mohon perhatikan kembali form yang anda isi";
        translate.checkAgree = "Saya setuju dengan peraturan yang berlaku.";
        translate.btnSave = "Kirim";
        translate.btnCancel = "Batal";
    }
	
    if(localStorage.getItem('language') == "EN") {
        translate.title = "Register";
        translate.subTitle = "Enter your details to create your account";
        translate.firstName = "First Name";
        translate.error.firstName = "First name is required";
        translate.error.required.email = "Email is required";
        translate.error.required.password = "The password is required";
        translate.error.required.passwordConfirm = "The password confirmation is required";
        translate.error.format.email = "The value is not a valid email address";
        translate.error.format.passwordConfirm = 'The password and its confirm are not the same';
        translate.error.agree = 'You must accept the terms and conditions';
        translate.checkAgree = "I Agree the terms and conditions.";
        translate.error.message = "Sorry, looks like there are some errors detected, please try again.";
        translate.btnSave = "Submit";
        translate.btnCancel = "Cancel";
    }

    return translate;
}