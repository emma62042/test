<?php
$id = $_GET['id'];
$conn = mysqli_connect("localhost:33060", "root", "root","center88_DB");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "DELETE FROM center88_board 
        WHERE msg_id = '" . $id . "'" ;
if (mysqli_query($conn, $sql)) 
{
    mysqli_close($conn);
    header("Location: board.php");
} 
else 
{
    echo "刪除失敗!!";
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    mysqli_close($conn);
}
?>