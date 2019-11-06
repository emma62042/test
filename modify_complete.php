<?php
session_start();
$conn = mysqli_connect("localhost:33060", "root", "root","center88_DB");
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
if(!empty($_POST['id'])){
    $time = date("Y-m-d H:i:s",time()+8*60*60); //GMT+8
    $id = $_POST['id'];
    $msg = $_POST['msg'];
    $sql = "UPDATE center88_board 
            SET msg='" . $msg . "', time= '" . $time . "'
            WHERE msg_id= '" . $id . "'";
    if (mysqli_query($conn, $sql)){
        mysqli_close($conn);
        header("Location: board.php");
    }else{
        echo "修改失敗!!";
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        mysqli_close($conn);
    }
}else{
    if (!empty($_POST["nickname"]) && !empty($_POST["msg_title"]) && !empty($_POST["msg"])){//不允許add送空字串
        $nickname = $_POST["nickname"];
        $msg_title = $_POST["msg_title"];
        $msg = $_POST["msg"];
        $sql = "INSERT INTO center88_board (nickname, msg_title, msg)
                VALUES ('$nickname' , '$msg_title' , '$msg' )";
        if (mysqli_query($conn, $sql)){
            mysqli_close($conn);
            header("Location:board.php");
        }else{
            echo "新增失敗!!";
            echo "Error: " . $sql . "<br/>" . mysqli_error($conn);
            mysqli_close($conn);
        }
    }else{
        $_SESSION["nickname"] = $_POST["nickname"];
        $_SESSION["msg_title"] = $_POST["msg_title"];
        $_SESSION["msg"] = $_POST["msg"];
        if(empty($_POST["nickname"])){
            $_SESSION["errname"] = "請輸入暱稱";
        }
        if(empty($_POST["msg_title"])){
            $_SESSION["errtitle"] = "請輸入標題";
        }
        if(empty($_POST["msg"])){
            $_SESSION["errmsg"] = "請輸入留言";
        }
        mysqli_close($conn);
        header("Location:board-modify.php");
    }
}

?>