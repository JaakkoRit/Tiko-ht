
function openLogin(loginId){
	document.getElementById("login-selection").style.display = "none";
	document.getElementById(loginId).style.display = "block";
	document.getElementById("login").style.display = "block";
}
function changeLoginType(){
	var x = document.getElementsByClassName("form-signin");
	for (var i = 0; i < x.length; i++)
		x[i].style.display = "none";
	document.getElementById("login").style.display = "none";
	document.getElementById("login-selection").style.display = "block";
}