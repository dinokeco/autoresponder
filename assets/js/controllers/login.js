class Login {

  static init(){
    if (window.localStorage.getItem("token")){
      window.location="index.html";
    }else{
      $('body').show();
    }
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('token')){
      $("#change-password-token").val(urlParams.get('token'));
      Login.show_change_password_form();
    }
  }

  static show_change_password_form(){
    $("#change-password-form-container").removeClass("hidden");
    $("#login-form-container").addClass("hidden");
    $("#register-form-container").addClass("hidden");
    $("#register-form-container").addClass("hidden");
  }

  static show_forgot_form(){
    $("#login-form-container").addClass("hidden");
    $("#forgot-form-container").removeClass("hidden");
  }

  static show_register_form(){
    $("#login-form-container").addClass("hidden");
    $("#register-form-container").removeClass("hidden");
  }

  static show_login_form(){
    $("#login-form-container").removeClass("hidden");
    $("#register-form-container").addClass("hidden");
    $("#forgot-form-container").addClass("hidden");
  }

  static register(){
    $("#register-link").prop('disabled',true);
    RestClient.post("api/register", AUtils.form2json("#register-form"), function(data){
      $("#register-form-container").addClass("hidden");
      $("#form-alert").removeClass("hidden")
      $("#form-alert .alert").html(data.message);
    }, function(jqXHR, textStatus, errorThrown){
      $("#register-link").prop('disabled',false);
      toastr.error(jqXHR.responseJSON.message);
    });
  }

  static login(){
    $("#login-link").prop('disabled',true);
    RestClient.post("api/login", AUtils.form2json("#login-form"), function( data ) {
      window.localStorage.setItem("token", data.token);
      window.location = "index.html";
    }, function(jqXHR, textStatus, errorThrown){
      $("#login-link").prop('disabled',false);
      toastr.error(error.responseJSON.message);
    });
  }

  static forgot_password(){
    $("#forgot-link").prop('disabled',true);
    RestClient.post("api/forgot", AUtils.form2json("#forgot-form"), function(data) {
      $("#forgot-form-container").addClass("hidden");
      $("#form-alert").removeClass("hidden")
      $("#form-alert .alert").html(data.message);
    }, function(jqXHR, textStatus, errorThrown){
      $("#forgot-link").prop('disabled',false);
      $("#forgot-form-container").addClass("hidden");
      toastr.error(error.responseJSON.message);
    });
  }

  static change_password(){
    $("#change-link").prop('disabled',true);
    RestClient.post("api/reset", AUtils.form2json("#change-form"), function(data) {
      window.localStorage.setItem("token", data.token);
      window.location = "index.html";
    }, function(jqXHR, textStatus, errorThrown){
      $("#change-link").prop('disabled',false);
      toastr.error(error.responseJSON.message);
    });
  }
}
