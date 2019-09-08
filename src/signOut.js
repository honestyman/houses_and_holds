function signOut() {
	var auth2 = gapi.auth2.getAuthInstance();
	auth2.signOut().then(function () {
	  console.log('User signed out.');
	});
	$(".g-signin2").css("display","block");
    $(".loggedIn").css("display","none");
    $("#pic").attr('src',"");
}