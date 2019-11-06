<?php 
$conn = mysqli_connect("localhost:33060", "root", "root","center88_DB");
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
$mode = "";
$search = "";
$input = "";
if (isset($_GET['mode']) && $_GET['mode'] == 'search'){
    if (!empty($_POST['search']) || isset($_GET['input'])){ //不允許空字串
        $mode = "mode=search&"; 
        $search = !empty($_POST['search'])? $_POST['search'] : $_GET['input'];
        $input = "&input=";
        $sql = "SELECT *
                FROM center88_board
                WHERE msg_title LIKE '%" . $search . "%'
                ORDER BY time DESC";
        $result = mysqli_query($conn, $sql);
        if (!$result){
            echo "Error: " . $sql . "<br/>" . mysqli_error($conn);
        }
        $data_rows = mysqli_num_rows($result); //先知道所有留言的數量
        $per = 3;//每頁顯示項目數量
        $allpages = ceil($data_rows/$per); //取得不小於值的下一個整數 ex. 全部有7筆 7/3=2.3->取3=最末頁
        if (!isset($_GET["page"])) //假如$_GET["page"]未設置
        {
            $page=1; //則在此設定起始頁數
        }
        else
        {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page - 1) * $per; //每一頁開始的資料序號
        $result = mysqli_query($conn, $sql.' LIMIT '.$start.', '.$per); //LIMIT 1, 3 表示取出query結果的第2筆到第4筆(從2開始3筆資料)
    }
}else{
    $sql = "SELECT *
            FROM center88_board
            ORDER BY time DESC";
    $result = mysqli_query($conn, $sql);
    if (!$result){
        echo "Error: " . $sql . "<br/>" . mysqli_error($conn);
    }
    $data_rows = mysqli_num_rows($result); //先知道所有留言的數量
    $per = 3;//每頁顯示項目數量
    $allpages = ceil($data_rows/$per); //取得不小於值的下一個整數 ex. 全部有7筆 7/3=2.3->取3=最末頁
    if (!isset($_GET["page"]) || empty($_GET["page"])) //假如$_GET["page"]未設置 或是空值(0)
    {
        $page=1; //則在此設定起始頁數
    }
    else
    {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start = ($page - 1) * $per; //每一頁開始的資料序號
    $result = mysqli_query($conn, $sql.' LIMIT '.$start.', '.$per); //LIMIT 1, 3 表示取出query結果的第2筆到第4筆(從2開始3筆資料)
}


?>
<!DOCTYPE html><!-- html 5 文件類型聲明  -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />
    <title>center88留言板</title>
    <link rel = stylesheet type = "text/css" href = "css/board.css">
</head>

<body>
    <div id = 'container'>
        <div id = 'sign'>
        </div>
        <div id = 'banner'>
            <p><a href = "board.php">center88留言板</a></p>
        </div>
        <div id = 'sidebar'>
            <table id = "bar_tb">
                <tr>
                    <td>
                        <a href = "board-modify.php">新增留言</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href = "board.php?mode=search">查詢留言</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href = "board.php">回首頁</a>
                    </td>
                </tr>
            </table>
        </div>
        <div id = 'content'>
        <?php 
        if(isset($_GET['mode']) && $_GET['mode'] == 'search'){
        ?>
        	<form action="board.php?mode=search" method="post">
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
    						<button type="submit">START</button>
    					</td>
    				</tr>
    			</table>
    		</form>
    		<br/>
    	<?php 
        }
        ?>
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
                    $time = $row["time"]; ?>
                    <table id = "cont_tb">
                        <tr>
                            <td colspan = "2">
                                #<?php echo $msg_id ?>
                            </td>
                        </tr>
                        <tr>
                            <td>留言標題：</td>
                            <td width = "450">
                                <?php echo $msg_title ?>
                            </td>
                        </tr>
                        <tr>
                            <td>留言內容：</td>
                            <td width = "450">
                                <?php
                                $msg = str_replace("\n","<br/>",$msg);
                                echo $msg;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2" style = "text-align: right;">
                                <?php echo $nickname . "&nbsp;發表於&nbsp;" . $time ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2" style = "text-align: right;">
                                <button type = "button" onclick = "location.href='delete_complete.php?id=<?php echo $msg_id;?>'">刪除</button>
                                <button type = "button" onclick = "location.href='board-modify.php?id=<?php echo $msg_id;?>'">修改</button>
                            </td>
                        </tr>
                    </table>
                <br/>
                <?php 
                }
                ?>
                <p>共<?php echo $data_rows ?>筆-在<?php echo $page ?>頁-共<?php echo $allpages ?>頁</p>
                <p><a href="board.php?<?php echo $mode ?>page=1<?php echo $input; echo $search?>">首頁</a>-第
                <?php
                for( $i = 1 ; $i <= $allpages ; $i++ ) 
                {
                    if ( $page-3 < $i && $i < $page+3 ) /*前2頁 後兩頁*/
                    {?>
                    	<a href="board.php?<?php echo $mode ?>page=<?php echo $i; echo $input; echo $search?> "><?php echo $i ?></a>
                        <?php
                    }
                }?>
        		頁-<a href="board.php?<?php echo $mode ?>page=<?php echo $allpages; echo $input; echo $search?> ">末頁</a>
                </p>
            <?php 
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>

</html>