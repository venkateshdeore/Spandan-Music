<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['uid']))
{
    header("Location:logout.php");
    die();
}
$uid = $_SESSION['uid']; //isko session kardo baadme, dashboard wale page se
if(isset($_POST['import']))
{
    function clean($string)
    {
        // $string=str_replace(' ','-',$string);
        return preg_replace('/[^A-Za-z0-9\-\.\ ]/','',$string);
    }
    //checking for album art
        if($_POST['album_select']==-1 and ($_POST['album_name']=="" and $_FILES['album_art']['name']==""))
        {
            echo "<script>alert('No album selected');window.open('dashboard.php', '_self');</script>";
            die();
        }
        $profile_id = $_POST['profile_id'];
        $errors= array();
        $song_id = $_POST['song_id'];
        if($_POST['album_select']==-1)
        {
                $new_album_name = $_POST['album_name'];
                $file_name = $_FILES['album_art']['name'];
                $file_size =$_FILES['album_art']['size'];
                $file_tmp =$_FILES['album_art']['tmp_name'];
        
                if($file_size > 5242880)
                {
                    $errors[]='Image size must be less than 5MB';
                }
                if(empty($errors)==true)
                {
                    move_uploaded_file($file_tmp,"images/album_art/".$file_name);
                }
                else
                {
                    print_r($errors);
                }
                $type = mime_content_type("images/album_art/".$file_name);
                // echo "$file_name";
                if(substr($type, 0, 5)!="image")
                {
                    shell_exec("rm 'images/album_art/$file_name'");
                    echo "<script>alert('Album art file type is not an image. Please check again or upload another image.');window.open('dashboard.php','_self');</script>";
                    die();
                }

                $qrr = "SELECT * FROM `album_details` WHERE uid='$uid' and album_name='$new_album_name'";
                $rqq = mysqli_query($con, $qrr);
                if(mysqli_num_rows($rqq)>=1)
                {
                    echo "<script>alert('Album name cannot be same.');window.open('dashboard.php','_self');</script>";
                    die();
                }
        }
        // Song rename

        $qr = "SELECT song_name FROM `song_details` WHERE song_id='$song_id'";
        $rq = mysqli_query($con, $qr);
        $rg = mysqli_fetch_array($rq);
        $rename = $rg['song_name'];
        if($_POST['rename']!="")
        {
        	$rename = $_POST['rename'];
        }
        $query3="SELECT * FROM user_song_map WHERE uid='$uid' AND (song_id='$song_id' OR custom_name='$rename')";
        $result3=mysqli_query($con,$query3);
        if(mysqli_num_rows($result3)>0)
        {
            echo"<script>alert('Song already exists');window.open('profile.php?profile_id=".$profile_id."','_self');</script>";
            die();
        }
        $query = "INSERT INTO `user_song_map`(`uid`, `song_id`, `custom_name`) VALUES ($uid, $song_id, '$rename')";
        $result = mysqli_query($con, $query);

        if(isset($_POST['album_select']) and $_POST['album_select']!="-1")
        {
            $aid=$_POST['album_select'];
            $query="UPDATE user_song_map SET album_id='$aid' WHERE uid='$uid' AND custom_name='$rename'";
            mysqli_query($con,$query);
            echo "<script>  window.open('profile.php?profile_id=".$profile_id."','_self');</script>";
            die();
        }
        //album details
        //create new album

        
        $query = "SELECT * from album_details WHERE uid=$uid";
        $result = mysqli_query($con,$query);
        $aid;
        if(mysqli_num_rows($result) == 0)
        {
        	$query = "INSERT INTO `album_details` (`uid`, `album_id`, `album_name`, `album_art`) VALUES ('$uid','1','$new_album_name','$file_name')";
        	mysqli_query($con,$query);
        	$aid=1;
        }
        else 
        {
        	$query = "SELECT max(album_id) from album_details WHERE uid='$uid'";
        	$result = mysqli_query($con,$query);
        	$result = mysqli_fetch_array($result);
        	$aid = $result[0];
        	$aid++;
        	$query = "INSERT INTO `album_details` (`uid`, `album_id`, `album_name`, `album_art`) VALUES ('$uid','$aid','$new_album_name','$file_name')";
        	mysqli_query($con,$query);
        }
        $query="UPDATE user_song_map SET album_id='$aid' WHERE uid='$uid' AND custom_name='$rename'";
        mysqli_query($con,$query);
        echo "<script>  window.open('profile.php?profile_id=".$profile_id."','_self');</script>";
}
?>
