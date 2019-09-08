function signOut() {
  var auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {
    console.log('User signed out.');
  });
  $(".landingPage").css("display","block");
  $(".userDashboard").css("display","none");
  $(".activeGame").css("display","none");
  $("#pic").attr('src',"");
}