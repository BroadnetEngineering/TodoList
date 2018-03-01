// This file contains the front facing javascript for the To-do list.
// The intentions here are to demonstrate my knowledge of Javascript

// NOTE: The assumption is made that jquery is loaded once we hit this point.

var tasks = [];

$( document ).ready(function() {

  // send the cursor to the add item input field
  $('#addItem').focus();

  // app just loaded, pull existing tasks
  $.get( "index.php", { action: "getTasks" } )
    .done(function( data ) {
      tasks = jQuery.parseJSON(data).tasks;

      render();
    });


$("#addItem").on('keyup', function (e) {

  // Handle the enter key being pressed
  if (e.keyCode == 13) {
    // Make sure the field is not blank. we also remove unneeded whitespace
    // by trimming the value
    var task = $("#addItem").val().trim();

    // verify that the user actually entered a todo item
    if ( task == '' ){
      return;
    }

    $.get( "index.php", { action: "addItem", task: task } )
      .done(function( data ) {
        tasks = jQuery.parseJSON(data).tasks;

        render();
      });

    // reset text box
    $('#addItem').val('');
  }
});


});

function toggleCompleted(id) {

  // see the state of the checkbox
  var checked = $('input[itemid="'+id+'"]').is(':checked') ? "1" : "0";

  $.get( "index.php", { action: "updateCompleted", id: id, checked: checked } )
    .done(function( data ) {
      tasks = jQuery.parseJSON(data).tasks;

      render();
    });
}

function deleteItem(id) {

  if(confirm('Are you sure you want to delete this todo item? This cannot be undone.')){

    $.get( "index.php", { action: "deleteItem", id: id } )
      .done(function( data ) {
        tasks = jQuery.parseJSON(data).tasks;

        render();
      });
  }
}

function editItem(id) {
  // User clicked the edit button, so transform the text into an actual textbox

  // get original text
  var origText = $('div.item-text[itemid="'+id+'"]').html();

  // transform into textbox
  var text = $('div.item-text[itemid="'+id+'"]').empty().append('<input id="update-item-input" onblur="doneEditing('+id+', this.value)" value="'+origText+'" />');

  //set the cursor to the text box
  $('#update-item-input').focus();

  // handle the enter key
  $("#update-item-input").on('keyup', function (e) {

    // Handle the enter key being pressed
    if (e.keyCode == 13) {
      doneEditing(id, $("#update-item-input").val());
    }

  });
}

function doneEditing(id, text) {

  // update the todo task serverside
  $.get( "index.php", { action: "updateTask", id: id, task: text } )
    .done(function( data ) {
      tasks = jQuery.parseJSON(data).tasks;

      render();
    });

}

function render() {
  // this function loops the tasks array and constructs the list within the view

  //clear out current contents
  $('#todos').html('');

  var template = $('#lineItemTemplate').html();
  $.each( tasks, function( key, task ) {

    var line = template;

    // check to see if the item is completed
    if( task.completed == '1' ) {
      line = line.replace('[ITEM-TEXT]', '<em class="crossout">[ITEM-TEXT]</em>');
    }
    else {
      line = line.replace('checked=""', '');
      line = line.replace('checked', '');
    }

    // insert the identifying attributes
    line = line.replace('[ITEM-TEXT]', task.task);
    // line = line.replace('[ITEM-ID]', task.id);
    line = line.replace(/ITEMID/g, task.id);

    // add the html to the DOM
    $('#todos').append(line);
  });
}