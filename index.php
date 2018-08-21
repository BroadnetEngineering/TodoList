<?php
/*
      Author  : William "Jake" Jacobs
      Email   : jake@proweb.agency
      GitHub  : https://github.com/jake46a
*/ 
?>

<html>
<head>
  <!-- Defaulted to Bootstrap 3.x since has glyphicon support built in already -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="alertify/css/alertify.core.css">
  <link rel="stylesheet" type="text/css" href="alertify/css/alertify.default.css">
  <link rel="stylesheet" type="text/css" href="css/custom.css">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Simple ToDo list</title>
</head>
<body>
  <br><br>

  <div class="container" >
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-info" role="alert">
           <center><h3>Simple todo list</h3></center>
        </div>
      </div>
    </div>
    <div class="row">
      <div id="list" class="col-md-8 col-md-offset-2">  
        <?php include 'list.php' ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="input-group">
          <input type="text" class="form-control" id="txtNewItem" placeholder="Enter new todo item...">
          <span class="input-group-btn">
            <button class="btn btn-primary" id="addButton" onclick="return validateForm();" type="button">Add New</button>
          </span>
        </div><!-- /input-group -->
      </div>
    </div>
  </div>

  

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/core.js"></script> -->
  <script src="alertify/js/alertify.min.js"></script>

  <script>

    function validateForm(){
      var val=document.getElementById("txtNewItem").value;
      if (val.length<10) {
        alertify.error("Todo description must contain at least 10 characters!");
        return false;
      }else{
        InsertItemInDatabase();

      }
    }


    function validateEdit(desc){
      var desc=document.getElementById("txtNewItem").value;
      if (desc.length<10) {
        alertify.error("Todo description must contain at least 10 characters!");
        return false;
      }else{
        return true;

      }
    }



  </script>

  <script>   
    // insert new todo item into database
    function InsertItemInDatabase() {
      
        var buttonString= "<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate' id='spinner'></span> "+$('#addButton').html();
        $('#addButton').html(buttonString);
      
      var new_desc=document.getElementById("txtNewItem").value;
      document.getElementById("txtNewItem").value="";
      $.ajax({
        url:'process.php?insert_description=' + new_desc,
        complete: function (response) {
          var status = JSON.parse(response.responseText);
               // Alerify response);
               if(status.status =="success"){
                alertify.success("New todo item saved successfully");
              }else if(status.status =="error"){
                alertify.error("Error saving todo item");
              }
                  $( "#list" ).load( "list.php");
                  $( "#spinner" ).remove();
                },
                error: function () {
                },
              });

    }


      // insert new todo item in to database

      function DeleteItem(id) {
        alertify.confirm("Are you sure? Once deleted it can not be restored!", function (e) {
          if (e) {
            //for spinner
            var buttonString= "<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate' id='spinner'></span> "+$('#delete_'+id).html();
            $('#delete_'+id).html(buttonString);

            $.ajax({
              url:'process.php?delete_id=' + id,
              complete: function (response) {
                     var status = JSON.parse(response.responseText);
                     if(status.delete_status =="success"){
                      alertify.success("Todo item deleted");
                           $( "#list" ).load( "list.php" );// reload list after deletion
                         }else if(status.delete_status =="error"){
                          alertify.error("Error: could not delete todo item!");
                        }
                      },
                      error: function () {
                        $('#output').html('There was an error!');
                      },
                    });
          }
        });
      }


      //Edit todo item and save to database
      function EditItem(id) {
        $.ajax({
          url:'process.php?edit_id=' + id,
          complete: function (response) {
                var status = JSON.parse(response.responseText);
                if(status.edit_status =="success"){
                  alertify.success("Todo item updated");
                      $( "#list" ).load( "list.php" );// reload list after edit
                    }else if(status.edit_status =="error"){
                      alertify.error("Error: could not edit todo item!");
                    }
                  },
                  error: function () {
                    $('#output').html('There was an error!');
                  },
                });
      }


      function checks(id,desc){
        //var id= $(this).attr('id');
        alertify.prompt("Edit todo ID="+id, function (e, str) {
        if (e) {
            if (str.length>10) {
              var buttonString= "<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate' id='spinner'></span> "+$('#edit_'+id).html();
            $('#edit_'+id).html(buttonString);
            
              $.ajax({
                url:'process.php',
                data : {edit_id:id, new_desc:str},
                complete: function (response) {
                var status = JSON.parse(response.responseText);
                if(status.edit_status =="success"){
                  alertify.success("Todo update completed!");
                      $( "#list" ).load( "list.php" );// reload after update
                      $( "#spinner" ).remove(); 
                    }else if(status.edit_status =="error"){
                      alertify.error("Error: could not update todo item!");
                    }
                  },
                  error: function () {
                    $('#output').html('There was an error!');
                  },
                });
              
              //alertify.success("Valid");
              /*--if valid ends*/
             }else{
              alertify.error("Todo description must contain at least 10 characters! ");
             }
        } else {
            //alertify.error("Process canceled!");
        }
      }, desc);
  }
  </script>
  </body>
  </html>





