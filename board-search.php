<?php 
$conn = mysqli_connect("localhost:33060", "root", "root","center88_DB");
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
if (!empty($_POST['search'])) //不允許空字串
{
    $search = $_POST['search'];
    $sql = "SELECT * 
            FROM center88_board
            WHERE msg_title LIKE '%" . $search . "%'
            ORDER BY time DESC";
    $result = mysqli_query($conn, $sql);
    if ($result) 
    {
        //echo "access new msg success";
    } 
    else 
    {
        echo "Error: " . $sql . "<br/>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>center88留言板-查詢留言</title>
    <link rel=stylesheet type="text/css" href="css/board.css">
</head>

<body>
	<div id="container">
		<div id="sign">
        </div>
        <div id="banner">
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
        <form action="board-search.php" method="post">
            <table cellpadding="10" width="600" border="1" align="center">
                <tr>
                    <td>
						搜尋：<input type="text" name="search" size="41" style="font-size:20px" 
                        value="<?php 
                                    if(isset($search))
                                    {
                                        echo $search;
                                    }
                                ?>"> 
						<input type="submit" value="START">
					</td>
				</tr>
			</table>
		</form>
		<br/>
		<?php 
            if (isset($result) && mysqli_num_rows($result) > 0) 
            {
            // get data $
                $sum = 0;
                while($row = mysqli_fetch_assoc($result)) 
                {
                    $sum++;
                    $msg_id = $row["msg_id"];
                    $nickname = $row["nickname"];
                    $msg_title = $row["msg_title"];
                    $msg = $row["msg"];
                    $time = $row["time"];
        ?>
                    <table id="cont_tb">
            			<tr>
            				<td colspan="2">
            					#<?php echo $msg_id;?>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					留言標題：
            				</td>
            				<td width="450">
            					<?php echo $msg_title;?>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					留言內容：
            				</td>
            				<td width="450">
            				<?php
                                $msg = str_replace("\n","<br/>",$msg);
                                echo $msg;
                            ?>
                            </td>
            			</tr>
            			<tr>
            				<td colspan="2" style="text-align: right;">
            					<?php echo $nickname . "&nbsp;發表於&nbsp;". $time;?>
            				</td>
            			</tr>
                        <tr>
            				<td colspan="2" style="text-align: right;">
            					<input type="button" value="刪除" onclick="location.href='delete_complete.php?id=<?php echo $msg_id;?>'">
            					<input type="button" value="修改" onclick="location.href='board-modify.php?id=<?php echo $msg_id;?>'">
            				</td>
            			</tr>
            		</table>
            		<br/>
		<?php 
                    if($sum>2){break;}
                }
            }
            mysqli_close($conn);
        ?>
        </div>
    </div>
</body>
</html>