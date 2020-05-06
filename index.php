<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <?php require_once 'process.php'; ?>

        <?php if(isset($_SESSION["message"])): ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?>">
                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif ?>

        <div class="row justify-content-center">
                <form action="process.php" method="POST">
                    <div class="form-group" style="text-align:center;">
                        <h2><strong>Todo List</strong></h2>
                        <input class="form-control" type="text" name="todo" value="<?php echo $todo; ?>" placeholder="Add a todo...">
                    </div>
                    <div class="form-group" style="text-align:center;">
                    <?php if ($update == true): ?>
                        <button class="btn btn-success" type="submit" name="update">Update</button>
                    <?php else: ?>
                        <button class="btn btn-success" type="submit" name="save">Save</button>
                    <?php endif; ?>
                    </div>
                </form>
        </div>

        <div class="container">
        <?php
            $conn = mysqli_connect('localhost', 'root', '', 'todo-crud') or die(mysql_error($conn));
            $result = $conn->query("SELECT * FROM data") or die($conn->error);
            // pre_r($result);
        ?>

            <div class="row justify-content-center">
                <table class="table">
                        <tr>
                            <th>Todo</th>
                            <th>Created On</th>
                            <th colspan="2">Action</th>
                        </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="align-middle"><?php echo $row['todo']; ?></td>
                            <td class="align-middle"></td>
                            <td>
                                <a class="btn btn-primary" href="index.php?edit=<?php echo $row['id']; ?>">Edit</a>
                                <a class="btn btn-danger" href="process.php?delete=<?php echo $row['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
            <?php

                function pre_r( $array ) {
                    echo '<pre>';
                    print_r($array);
                    echo '</pre>';
                }
            ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>