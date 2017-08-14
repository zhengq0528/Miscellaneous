
function editHeader() {
    var person = prompt("Please enter your name", "Harry Potter");
    var p = document.getElementById("pn").value;
    if (person != null) {
        document.getElementById("location").innerHTML =  p;
    }
}

$(document).ready(function()
{

  $('.bftype').focus(function(e) {
    e.target.click();
  });

  $('.watts1').focus(function(e) {
    e.target.click();
  });
  $('.watts2').focus(function(e) {
    e.target.click();
  });
  $('.watts3').focus(function(e) {
    e.target.click();
  });
  $('.code').focus(function(e) {
    e.target.click();
  });
  $('.uses').focus(function(e) {
    e.target.click();
  });
  // Edit input box click action
  $(".editbox").mouseup(function()
  {
    return false
  });

  // Outside click action
  $(document).mouseup(function()
  {
    $(".editbox").hide();
    $(".text").show();
  });

  $(".uses").click(function()
  {
    var ID=$(this).attr('id');
    $("#uses_"+ID).hide();
    $("#uses_input_"+ID).show();
    $("#uses_input_"+ID).focus();
  }).change(function()
  {
    var ID=$(this).attr('id');
    var uses=$("#uses_input_"+ID).val();
    var dataString = 'id='+ ID +'&uses='+uses;
    $.ajax({
      type: "POST",
      url: "table_edit_ajax.php",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $("#uses_"+ID).html(uses);
      }
    });
  });

  $(".watts1").click(function()
  {
    var ID=$(this).attr('id');
    $("#watts1_"+ID).hide();
    $("#watts1_input_"+ID).show().focus();
  }).change(function()
  {
    var ID=$(this).attr('id');
    var uses=$("#watts1_input_"+ID).val();
    var dataString = 'id='+ ID +'&watts1='+uses;
    $.ajax({
      type: "POST",
      url: "table_edit_ajax.php",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $("#watts1_"+ID).html(uses);
      }
    });
  });

  $(".watts2").click(function()
  {
    var ID=$(this).attr('id');
    $("#watts2_"+ID).hide();
    $("#watts2_input_"+ID).show().focus();
  }).change(function()
  {
    var ID=$(this).attr('id');
    var uses=$("#watts2_input_"+ID).val();
    var dataString = 'id='+ ID +'&watts2='+uses;
    $.ajax({
      type: "POST",
      url: "table_edit_ajax.php",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $("#watts2_"+ID).html(uses);
      }
    });
  });
  $(".watts3").click(function()
  {
    var ID=$(this).attr('id');
    $("#watts3_"+ID).hide();
    $("#watts3_input_"+ID).show().focus();
  }).change(function()
  {
    var ID=$(this).attr('id');
    var uses=$("#watts3_input_"+ID).val();
    var dataString = 'id='+ ID +'&watts3='+uses;
    $.ajax({
      type: "POST",
      url: "table_edit_ajax.php",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $("#watts3_"+ID).html(uses);
      }
    });
  });

  $(".code").click(function()
  {
    var ID=$(this).attr('id');
    $("#code_"+ID).hide();
    $("#code_input_"+ID).show().focus();
  }).change(function()
  {
    var ID=$(this).attr('id');
    var code=$("#code_input_"+ID).val();
    var dataString = 'id='+ ID +'&code='+code;
    $.ajax({
      type: "POST",
      url: "table_edit_ajax.php",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $("#code_"+ID).html(code);
      }
    });
  });


  $(".bftype").click(function()
  {
    var ID=$(this).attr('id');
    $("#bftype_"+ID).hide();
    $("#bftype_input_"+ID).show().focus();
  }).change(function()
  {
    var ID=$(this).attr('id');
    var uses=$("#bftype_input_"+ID).val();
    var dataString = 'id='+ ID +'&bftype='+uses;
    $.ajax({
      type: "POST",
      url: "table_edit_ajax.php",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $("#bftype_"+ID).html(uses);
      }
    });
  });
});
