<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Todo List</title>
</head>

<div id="task_modal" class="modal">
    <div class="modal_content">
        <div class="modal_header">
            <h2>Update or Delete Task</h2>
        </div>
        <div class="modal_body">
            <div class="form_div">
                <form class="input_form">
                    <input type="text" id="task_edit_id" hidden>
                    <input type="text" id="task_edit" maxlength="45" class="task_input">
                </form>
            </div>
            <p>- Please enter the revised task above and press "Update" to change it.</p>
            <p>- You may also press "Delete" to remove the task from the list.</p>
        </div>
        <div class="modal_footer">
            <button type="button" id="edit_btn" onclick="EditItem()" class="btn">Update</button>
            <button type="button" id="delete_btn" onclick="DeleteItem()" class="btn">Delete</button>
            <button type="button" id="cancel_btn" onClick="CloseModal()" class="btn">Cancel</button>
        </div>
    </div>
</div>

<body>
    <div id="main">
        <div class="heading">
            <h2>Todo List</h2>
        </div>

        <div class="form_div">
            <form class="input_form">
                <input type="text" id="task_input" maxlength="45" class="task_input">
                <button type="button" id="add_btn" onclick="AddItem()" class="btn">Add Task</button>
            </form>
        </div>
        
        <table id="todo_list">
            <thead>
                <tr>
                    <th>Task Description</th>
                </tr>
            </thead>
            <tbody id="table_body"></tbody>
        </table>

        <div id="task_notice">* Click on a task to edit or remove it.</div>
        
    </div>

</body>


<script>
    window.onload = PopulateTable();
    
    const modal = document.getElementById("task_modal");

    $("#todo_list tbody").on( "click", "tr", function( event ) {
        const task_id = $(this).find('td:first').text();
        document.getElementById("task_edit_id").value = task_id;

        const task_desc_id = "task_"+task_id+"_desc";
        const task = document.getElementById(task_desc_id).innerText;
        document.getElementById("task_edit").value = task;

        const modal = document.getElementById("task_modal");
        modal.style.display = "block";
    });
    
    $("#cancel_btn").onclick = function() {
        CloseModal();
    }

    function CloseModal(){
        modal.style.display = "none";
    }

    function PopulateTable(){
        $.ajax({
            url: "/TodoList.php",
            type: "POST",
            data: {
                submit_type:"fetch"
            },
            success: function( result ) {
                const table = document.getElementById("todo_list").getElementsByTagName('tbody')[0];
                const data = JSON.parse(result);
                const length = data.length;
                for(i = 0; i < length; i++){
                    var new_task = "<tr id=\"row_"+data[i].task_id+"\"><td id=\"task_"+data[i].task_id+"\" class=\"task_id_col\">"+data[i].task_id+"</td><td id=\"task_"+data[i].task_id+"_desc\">"+data[i].task_desc+"</td></tr>";
                    $('#table_body').append(new_task);
                }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    }

    function AddItem(){
        const task = document.getElementById("task_input").value;
        if(task == ""){
            alert("You must enter a task to be submitted.");
        }else{
            $.ajax({
                url: "/TodoList.php",
                type: "POST",
                data: {
                    submit_type:"add",
                    task_desc:task
                },
                success: function( result ) {
                    const data = JSON.parse(result);

                    const new_task = "<tr id=\"row_"+data.task_id+"\"><td id=\"task_"+data.task_id+"\" class=\"task_id_col\">"+data.task_id+"</td><td id=\"task_"+data.task_id+"_desc\">"+data.task_desc+"</td></tr>";
                    $('#table_body').append(new_task);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

    }

    function DeleteItem(){
        const task_id = document.getElementById("task_edit_id").value;
        
        $.ajax({
            url: "/TodoList.php",
            type: "POST",
            data: {
                submit_type:"delete",
                task_id:task_id
            },
            success: function( result ) {
                const data = JSON.parse(result);
                const row_id = "#row_"+data.task_id;
                $(row_id).remove();
                CloseModal();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    }

    function EditItem(){
        const task_id = document.getElementById("task_edit_id").value;
        const task = document.getElementById("task_edit").value;

        $.ajax({
            url: "/TodoList.php",
            type: "POST",
            data: {
                submit_type:"edit",
                task_desc:task,
                task_id:task_id
            },
            success: function( result ) {
                const data = JSON.parse(result);
                document.getElementById("task_"+data.task_id+"_desc").innerHTML = data.task_desc;
                CloseModal();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    }
</script> 
</html>