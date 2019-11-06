<?php 
session_start();
$errname = "";
$errtitle = "";
$errmsg = "";
if(isset($_GET['id'])){
    $title = "修改";
    $id = $_GET['id'];
    $conn = mysqli_connect("localhost:33060", "root", "root","center88_DB");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * 
            FROM center88_board 
            WHERE msg_id = " . $id . " 
            ORDER BY time DESC";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nickname = $row["nickname"];
    $msg_title = $row["msg_title"];
    $msg = $row["msg"];
    //echo $msg_id."|".$nickname."|".$msg_title."|".$msg."|".$time;
    mysqli_close($conn);
}
else {
    $title = "新增";
    $nickname = !empty($_SESSION["nickname"]) ? $_SESSION["nickname"] : "";
    $msg_title = !empty($_SESSION["msg_title"]) ? $_SESSION["msg_title"] : "";
    $msg = !empty($_SESSION["msg"]) ? $_SESSION["msg"] : "";
    $errname = !empty($_SESSION["errname"]) ? $_SESSION["errname"] : "";
    $errtitle = !empty($_SESSION["errtitle"]) ? $_SESSION["errtitle"] : "";
    $errmsg = !empty($_SESSION["errmsg"]) ? $_SESSION["errmsg"] : "";
    $id = "";
    session_destroy();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>center88留言板-修改留言</title>
    <link rel=stylesheet type="text/css" href="css/board.css">
</head>

<body>

    <div id='container'>
        <div id='sign'>
        </div>
        <div id='banner'>
            <p><a href="board.php">center88留言板</a></p>

        </div>
        <div id='sidebar'>
            <table id="bar_tb">
                <tr>
                    <td>
                        <a href="board-modify.php">新增留言</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="board.php?mode=search">查詢留言</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="board.php">回首頁</a>
                    </td>
                </tr>
            
            </table>
        </div>
        <div id='content'>
            <h3><?php echo $title ?>留言</h3>
            <form action="modify_complete.php" method="post">
            <table  style="border:3px #000000 dashed;" cellpadding="10" width="600" border="1" align="center">
                <tr>
                    <td>
                       	 您的暱稱：
                    </td>
                    <td>
                        <input type="text" name="nickname" size="38" style="font-size:20px" value="<?php echo $nickname ?>">
                        <br/>
                        <?php echo $errname ?>
                    </td>
                </tr>
                <tr>
                    <td>
						留言標題：
                    </td>
                    <td>
                        <input type="text" name="msg_title" size="38" style="font-size:20px" value="<?php echo $msg_title ?>">
                        <br/>
                        <?php echo $errtitle ?>
                    </td>
                </tr>
                <tr>
                    <td>
                                                                        留言內容：
                    </td>
                    <td>
                        <textarea cols="45" rows="5" type="text" name="msg" style="font-size:16px"><?php echo $msg ?></textarea>
                        <br/>
                        <?php echo $errmsg ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                    	<input type="hidden" name="id" value="<?php echo $id ?>">
                        <button type="submit"><?php echo $title ?>完成</button>
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</body>
</html>