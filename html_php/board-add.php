<?php session_start(); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>center88留言板-新增留言</title>
    <link rel=stylesheet type="text/css" href="css/board.css">
</head>

<body>

    <div id='container'>
        <div id='sign'>
            <ul class='ul_member'>
                <font>會員登入</font>
                <font>會員註冊</font>
            </ul>

        </div>
        <div id='banner'>
            <p><a href="board.php">center88留言板</a></p>

        </div>
        <div id='sidebar'>
            <table id="bar_tb">
                <tr>
                    <td>
                        <a href="board-add.html">新增留言</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="board-search.php">查詢留言</a>
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
            <h3>新增留言</h3>
            <form action="board.php" method="post">
                <table style="border:3px #000000 dashed;" cellpadding="10" width="600" border="1" align="center">
                    <tr>
                        <td>
                        	您的暱稱：
                        </td>
                        <td>
                            <input type="text" name="nickname" size="41" style="font-size:20px" value="<?php echo $_SESSION['nickname']?>"><?php if (!empty($_SESSION['errnickmame']))echo $_SESSION['errnickmame']?>
                        </td>
                    </tr>
                    <tr>
                        <td>
							留言標題：
                        </td>
                        <td>
                            <input type="text" name="msg_title" size="41" style="font-size:20px" value="<?php echo $_SESSION['msg_title']?>"><?php echo $_SESSION['errmsg_title']?>
                        </td>
                    </tr>
                    <tr>
                        <td>
							留言內容：
                        </td>
                        <td>
                            <textarea cols="39" rows="5" type="text" name="msg" style="font-size:20px" wrap="hard"><?php echo $_SESSION['msg']?></textarea><?php echo $_SESSION['errmsg']?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="新增留言">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body></html>