$(document).ready(function () {
    // Delete action. Grabbing element id and sending it to the server
    // with action value 'delete'. Once we get confirmation remove it pretty from the the dome
    $(".delete-action").click(function () {
        let postId = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "index.php",
            data: { id: postId, action: 'delete' }
        }).done(function() {
            $("#" + postId).slideUp();
        });
    });

    // Once checkbox is checked we are updating our database with the relevant value
    // To insure that this action is persisted and displayed after page refresh
    $("[id^=checkbox-]").click(function () {
        let postId = $(this).data('id');
        let status = ($("#checkbox-" + postId).is(":checked")) ? 'true' : 'false';

        $.ajax({
            method: "POST",
            url: "index.php",
            data: {
                id: postId,
                action: 'checked',
                status: status
            }
        });
    });

    // When edit button is clicked make input box editable
    $(".to-do-edit").click(function () {
        let postId = $(this).data('id');
        $("#todo-input-" + postId).removeAttr('readonly');
    });

    // Once save button is clicked we want to update todo and reload the page
    $(".to-do-save").click(function () {
        let postId = $(this).data('id');
        let status = ($("#checkbox-" + postId).is(":checked")) ? 'true' : 'false';
        let toDoText = $("#todo-input-" + postId).val();

        $.ajax({
            method: "POST",
            url: "index.php",
            data: {
                id: postId,
                action: 'update',
                status: status,
                to_do: toDoText
            }
        }).done(function () {
            location.reload();
        });
    });
});