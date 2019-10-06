function validar() {
	let email, tel, expresionR;

	expresionR = /^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/;

	email = document.getElementById("email").value;
	tel = document.getElementById("telefono").value;

	if (!expresionR.test(email)) {
		alert("correo no valido");
		return false;
	}

	if (isNan(tel)) {
		alert("El teléfono ingresado no es un número");
		return false;
	}

}