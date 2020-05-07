$(document).ready( function () {
  $('#datepicker').datepicker({
      uiLibrary: 'bootstrap4'
  });
  let dt = $('#table_id').DataTable( {
    "autoWidth": false,
      "columns": [
          { "title": "id" },
          { "title": "Task" },
          { "title": "Description" },
          { "title": "Status" },
          { "title": "Due Date" },
          { "title": "created"},
          { "title": "updated"}

      ],
      "order": [[2, 'asc']]
  } );

  initTable(dt);

  var detailRows = [];

$('#table_id tbody').on( 'click', 'tr', function () {
  var tr = $(this).closest('tr');
  if (!tr.hasClass('childRow')) {
    var row = dt.row( tr );
    var idx = $.inArray( tr.attr('id'), detailRows );

    if ( row.child.isShown() ) {
        tr.removeClass( 'details' );
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice( idx, 1 );
    }
    else {
        tr.addClass( 'details' );
        row.child( format( row.data() ), "childRow" ).show();
        $(document).on("click", "button.update" , function() {
          let updateStatus = 1;
          if($(this).html()=="Reopen"){
            updateStatus = 0;
          }
          update(this.id.substring(6),updateStatus);
        });
        $(document).on("click", "button.delete" , function() {
          deleteTask(this.id.substring(6));
        });

        // Add to the 'open' array
        if ( idx === -1 ) {
            detailRows.push( tr.attr('id') );
        }
    }
  }
} );

$(document).on("click", "button#add" , function() {
  add();
});

function update(id,updateStatus){
  $.ajax({
        url: "./ajax.php",
        type: "POST",
        data: {
            route:"update",
            id: id,
            updateStatus: updateStatus
        },
        success: function( result ) {
          location.reload(); 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}

function format ( d ) {
  let button = 'Mark as done';
  if(d[3] == "Closed"){
    button = 'Reopen';
  }
  return 'Description: '+d[2]+'<br />'+
    'Date created: '+d[5]+'<br />'+
    'Date updated: '+d[6]+'<br />'+
    '<form><button type="submit" class="btn btn-primary update" id="update'+d[0]+'">'+button+'</button>'+
    '&nbsp<button type="submit" class="btn btn-danger delete" id="delete'+d[0]+'">Delete task</button></form>';
}

function initTable(dt){
    $.ajax({
        url: "./ajax.php",
        type: "POST",
        data: {
            route:"fetch"
        },
        success: function( result ) {
            var results = jQuery.parseJSON(result);
            if(results.length){
              results.forEach(item => {
                let status = "Closed";
                if(item.status == 0){
                  status = "Open";
                }
                dt.row.add([item.id,item.title,item.description,status,item.due,item.created,item.updated]).node().id=item.id;
                dt.column( 0 ).visible(false);
                dt.column( 2 ).visible(false);
                dt.column( 5 ).visible(false);
                dt.column( 6 ).visible(false);
                dt.draw();
              });
              $("#tasks").show();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}
function add(){
  let title = $("#titleInput").val();
  let description = $("#descriptionInput").val();
  let rawDate = $("#datepicker").val();
  let year = rawDate.substring(6);
  let month = rawDate.substring(0,2);
  let day = rawDate.substring(3,5)
  let due = year+"-"+month+"-"+day;

  if(title!=""&&description!=""&&due!=""){
    $.ajax({
        url: "./ajax.php",
        type: "POST",
        data: {
            route:"add",
            title: title,
            description: description,
            due: due
        },
        success: function( result ) {
          location.reload(); 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
  } else{ 
    if(title==""){
    }
    if(description==""){
    }
    if(due==""){
    }
  }
}

function deleteTask(id,updateStatus){
  $.ajax({
        url: "./ajax.php",
        type: "POST",
        data: {
            route:"delete",
            id: id
        },
        success: function( result ) {
          location.reload(); 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}
} );