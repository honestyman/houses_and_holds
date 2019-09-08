function onSignIn(googleUser){
  var profile = googleUser.getBasicProfile();
  $(".landingPage").css("display","none");
  $(".userDashboard").css("display","block");
  $(".activeGame").css("display","none");
  $("#user_pic").attr('src',profile.getImageUrl());
  $("#user_email").text(profile.getEmail());
  var post = {};
  post.user_email = profile.getEmail();
  //post.user_email = "madeup@email.com";
  $.ajax({
    url: "index.php",
    method: "post",
    data: post,
    success: function(res){ console.log(res); }
  })
}