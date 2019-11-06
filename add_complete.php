<?php
$conn = mysqli_connect("localhost:33060", "root", "root","center88_DB");
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

if (!empty($_POST["nickname"]) && !empty($_POST["msg_title"]) && !empty($_POST["msg"])) //不允許add送空字串
{
    $nickname = $_POST["nickname"];
    $msg_title = $_POST["msg_title"];
    $msg = $_POST["msg"];
    $sql = "INSERT INTO center88_board (nickname, msg_title, msg)
            VALUES ('$nickname' , '$msg_title' , '$msg' )";
    if (mysqli_query($conn, $sql))
    {
        mysqli_close($conn);
        header("Location:board.php");
    }
    else
    {
        echo "新增失敗!!";
        echo "Error: " . $sql . "<br/>" . mysqli_error($conn);
        mysqli_close($conn);
    }
}
?>