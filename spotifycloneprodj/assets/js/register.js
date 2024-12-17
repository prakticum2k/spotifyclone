$(document).ready(function () {
  console.log("login was pressed");
  $("#hideLogin").click(function () {
    $("#loginForm").fadeOut(function () {
      $("#registerForm").fadeIn();
    });
  });

  $("#hideRegister").click(function () {
    console.log("register was pressed");
    $("#registerForm").fadeOut(function () {
      $("#loginForm").fadeIn();
    });
  });
});
