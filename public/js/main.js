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

  $("input[name='activation_code']").blur(function(event) {
    let value = $(this).val();
    $.ajax({
      url: '/checkpin',
      type: 'GET',
      data: { activation_code: value },
      dataType: 'json',
      success: function(response) {
        _setAccountType(response.type)
        $("#signup").prop('disabled', false)
      },
      error: function(err) {
        alert('Invalid Activation Code!')
        $("#signup").attr('disabled', 'disabled')
      }
    })
  });

  function _setAccountType(type) {
    $("#user_type").val(type.id)
  }

})()
