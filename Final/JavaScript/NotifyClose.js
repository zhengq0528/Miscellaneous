/*
  $(window).unload( function ()
  {
    var ID = "55";
    var uses = "quan";
    var dataString = 'id='+ ID +'&rating='+uses;
    $.ajax({
      type: "POST",
      url: "../Functions/quitting.php",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $("#rating_"+ID).html(uses);
      }
    });
  });
*/
window.addEventListener("beforeunload", function (e) {
  var confirmationMessage = "\o/";
  
  (e || window.event).returnValue = confirmationMessage; //Gecko + IE
  return confirmationMessage;                            //Webkit, Safari, Chrome
});
