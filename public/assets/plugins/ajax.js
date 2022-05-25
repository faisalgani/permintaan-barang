if(typeof(Storage) !== 'undefined') {
	if(localStorage.getItem('pubkey') === null) {
		jQuery.get('/publickey.txt', (data) => {
			localStorage.setItem('pubkey', data);
		});
	}
}else{
	console.log('Penyimpanan lokal tidak tersedia dalam browser ini');
}

function encrypt_parameter(variable){
	let parameter = variable;
	// let pubkey = null;
	let pubkey = localStorage.getItem('pubkey');
	// let pubkey = localStorage.getItem('pubkey');
	if(pubkey === null) {
		return false;
	}
	let key = CryptoJS.lib.WordArray.random(16);
	let iv 	= CryptoJS.lib.WordArray.random(16);
	let enc = CryptoJS.AES.encrypt(JSON.stringify(parameter), key, { iv: iv });
	let jse = new JSEncrypt();
	jse.setPublicKey(pubkey);
	let payload = {
		cipher 	: enc.toString(),
		iv 		  : jse.encrypt(iv.toString(CryptoJS.enc.Base64)),
		key 	  : jse.encrypt(key.toString(CryptoJS.enc.Base64))
	};
	return payload;
}