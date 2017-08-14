
<table>
  <?php

  $id=15;
  $firstname="hello";
  $lastname="world";
  ?>
  <tr id="<?php echo $id; ?>" class="edit_tr">

    <td class="edit_td">
      <span id="first_<?php echo $id; ?>" class="text"><?php echo $firstname; ?></span>
      <input type="text" value="<?php echo $firstname; ?>" class="editbox" id="first_input_<?php echo $id; ?>"/>;
    </td>

    <td class="edit_td">
      <span id="last_<?php echo $id; ?>" class="text"><?php echo $lastname; ?></span>
      <input type="text" value="<?php echo $lastname; ?>" class="editbox" id="last_input_<?php echo $id; ?>"/>
    </td>

  </tr>
  <?php
  ?>
</table>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
  $(".edit_tr").click(function()
  {
    var ID=$(this).attr('id');
    $("#first_"+ID).hide();
    $("#last_"+ID).hide();
    $("#first_input_"+ID).show();
    $("#last_input_"+ID).show();
  }).change(function()
  {
    var ID=$(this).attr('id');
    var first=$("#first_input_"+ID).val();
    var last=$("#last_input_"+ID).val();
    var dataString = 'id='+ ID +'&firstname='+first+'&lastname='+last;
    $("#first_"+ID).html('<img src="load.gif" />'); // Loading image

    if(first.length>0&& last.length>0)
    {

      $.ajax({
        type: "POST",
        url: "table_edit_ajax.php",
        data: dataString,
        cache: false,
        success: function(html)
        {
          $("#first_"+ID).html(first);
          $("#last_"+ID).html(last);
        }
      });
    }
    else
    {
      alert('Enter something.');
    }

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

});
</script>
