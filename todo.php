<?php
session_start();

if (!isset($_SESSION['mylist'])) {
  $default_list = [
    '20180515070000' => ['msg' => 'go to the store'],
    '20180515070001' => ['msg' => 'pick up mail'],
  ];
  $_SESSION['mylist'] = $default_list;
}

$show_form = true;
$item_form = '
<fieldset id="editform">
  <h2>Add new todo item</h2>
  <form method="post">
    <input type="hidden" name="item" value="' . date("YmdHis") . '" />
    <input type="text" name="msg" value="" />
    <input type="hidden" name="type" value="add" />
    <input type="submit" value="Create Todo Item" />
  </form>
</fieldset>';

if (isset($_POST) &&
  (isset($_POST['type']) && in_array($_POST['type'], ['add', 'edit', 'delete', 'update'])) ) {
  $item = $_POST['item'];
  switch ($_POST['type']) {
    case 'edit':
      $show_edit_form = true;
      $item_form = '
      <fieldset id="editform">
        <h2>Edit todo item</h2>
        <form method="post">
          <input type="hidden" name="item" value="' . $item . '" />
          <input type="text" name="msg" value="' . $_SESSION['mylist'][$item]['msg'] . '" />
          <input type="hidden" name="type" value="update" />
          <input type="submit" value="Update" />
        </form>
      </fieldset>';
      break;
    case 'update':
      $show_form = true;
      $_SESSION['mylist'][$item]['msg'] = $_POST['msg'];
      break;
    case 'delete':
      unset($_SESSION['mylist'][$item]);
      break;
    case 'add':
      $_SESSION['mylist'][$item]['msg'] = $_POST['msg'];
      break;
  }
}

$listitems = [];
foreach ($_SESSION['mylist'] as $key => $value) {
  $listitems[] = '<li class="listitem"><form method="post" style="display:inline"><input type="submit" value="Edit" /><input type="hidden" name="item" value="' . $key . '" /><input type="hidden" name="type" value="edit" /></form> <form method="post" style="display:inline"><input type="submit" value="Delete" /><input type="hidden" name="item" value="' . $key . '" /><input type="hidden" name="type" value="delete" /></form> <label>' . $value['msg'] . '</label></li>';
}
?>
<html>
  <head></head>
  <body>
    <fieldset id="listitems">
      <h1>Todo List</h1>
      <ul><?php print implode("\n\r", $listitems); ?></ul>
    </fieldset>
    <?php print ($show_form) ? $item_form : ''; ?>
  </body>
</html>
