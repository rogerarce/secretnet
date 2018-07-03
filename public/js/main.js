(function() {
  
  $("#btnlogin").click(function(event) {
    event.preventDefault();
    let el = $(this)
    
    $("#registerform").toggleClass("hidden");
    $("#loginform").toggleClass("hidden");
  });
  
  $("#btnregister").click(function(event) {
    event.preventDefault();
    let el = $(this)
    
    $("#registerform").toggleClass("hidden");
    $("#loginform").toggleClass("hidden");
  });

})()
