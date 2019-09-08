function onSignIn(googleUser){
	var profile = googleUser.getBasicProfile();
    $(".g-signin2").css("display","none");
    $(".loggedIn").css("display","block");
    $("#pic").attr('src',profile.getImageUrl());
}