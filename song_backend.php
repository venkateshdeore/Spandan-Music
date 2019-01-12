<?php
include('includes/connection.php');
session_start();
if(!isset($_SESSION['uid']))
{
    header('Location: logout.php');
    die();
}
$uid = $_SESSION['uid']; //isko session kardo baadme, dashboard wale page se
//if button is clicked
if(isset($_POST['upload']))
{
    function clean($string)
    {
        // $string=str_replace(' ','-',$string);
        return preg_replace('/[^A-Za-z0-9\-\.\ ]/','',$string);
    }
        if($_POST['album_select']==-1 and ($_POST['album_name']=="" and $_FILES['album_art']['name']==""))
        {
            echo "<script>alert('No album selected');window.open('dashboard.php', '_self');</script>";
            die();
        }
        //if new album is to be created
        if($_POST['album_select']==-1)
        {
                $new_album_name = $_POST['album_name'];
                $file_name_album = $_FILES['album_art']['name'];
                $file_size =$_FILES['album_art']['size'];
                $file_tmp =$_FILES['album_art']['tmp_name'];
        
                if($file_size > 5242880)
                {
                    $errors[]='Image size must be less than 5MB';
                }
                if(empty($errors)==true)
                {
                    move_uploaded_file($file_tmp,"images/album_art/".$file_name_album);
                }
                else
                {
                    print_r($errors);
                }
                $type = mime_content_type("images/album_art/".$file_name_album);
                // echo "$file_name";
                if(substr($type, 0, 5)!="image")
                {
                    shell_exec("rm 'images/album_art/$file_name_album'");
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
    if(isset($_FILES['song']))
    {
        $errors= array();
        $file_name = $_FILES['song']['name'];
        $file_size =$_FILES['song']['size'];
        $file_tmp =$_FILES['song']['tmp_name'];

        if($file_size > 52428800)
        {
            $errors[]='File size must be less than 50MB';
        }
        if(empty($errors)==true)
        {
            move_uploaded_file($file_tmp,"songs/".$file_name);
        }
        else
        {
            print_r($errors);
        }
        $type = mime_content_type("songs/".$file_name);
       	// echo "$file_name";
        if(substr($type, 0, 5)!="audio")
        {
        	shell_exec("rm 'songs/$file_name'");
        	echo "<script>alert('File type is not a song. Please check again or upload another song.');window.open('dashboard.php','_self');</script>";
        	die();
        }
        $song_name=shell_exec("python3 hello.py '".$file_name."' song 2>&1");
        $song_artist=shell_exec("python3 hello.py '".$file_name."' artist 2>&1");
        $song_genre=shell_exec("python3 hello.py '".$file_name."' genre 2>&1");  
        $song_name=clean(trim(($song_name)));
        $song_artist=clean(trim(($song_artist)));
        $song_genre=clean(trim(strtolower($song_genre)));
        
        $query="select * from song_details where song_name='$song_name'";
        $res=mysqli_query($con,$query);
        $old_arr=mysqli_fetch_array($res);
        $old_song=$old_arr['song_id'];
        $qr = "SELECT * FROM `user_song_map` WHERE uid='$uid' and song_id='$old_song'";
        $rq = mysqli_query($con, $qr);
        if(mysqli_num_rows($rq)>0)
        {
            echo "<script>alert('Song already present in your account');window.open('dashboard.php','_self');</script>";
            $song_id=$old_song;
            shell_exec("rm 'songs/$file_name'");
            die();
        }
        //if song not present with the same name
        else if(mysqli_num_rows($res)==0)
        {
            $query="insert into song_details (song_name,artist,genre) values ('$song_name','$song_artist','$song_genre')";
            mysqli_query($con,$query);
            // echo "Value inserted<br>";
            $query="select max(song_id) from song_details";
            $omega=mysqli_query($con,$query);
            $omega=mysqli_fetch_array($omega);
            $extension = substr($file_name, strlen($file_name)-3);
            $omega=$omega[0];
            shell_exec("mv 'songs/$file_name' 'songs/$omega.$extension'");
            $song_id=$omega;
        }
        else
        {
            $song_id=$old_song;
            shell_exec("rm 'songs/$file_name'");
        }

        // Song rename
        $rename = $song_name;
        if($_POST['rename']!="")
        {
        	$rename = $_POST['rename'];
        }
        $query = "INSERT INTO `user_song_map`(`uid`, `song_id`, `custom_name`) VALUES ($uid, $song_id, '$rename')";
        $result = mysqli_query($con, $query);

        // echo "Value:    ".$_POST['album_select'];
        // die();

        if(isset($_POST['album_select']) and $_POST['album_select']!="-1")
        {
            $aid=$_POST['album_select'];
            $query="UPDATE user_song_map SET album_id='$aid' WHERE uid='$uid' AND custom_name='$rename'";
            mysqli_query($con,$query);
            echo "<script>  window.open('dashboard.php','_self');</script>";
            die();
        }
        //album details
        //create new album

        

        $query = "SELECT * from album_details WHERE uid=$uid";
        $result = mysqli_query($con,$query);
        $aid;
        // No entry for user so album id =1
        if(mysqli_num_rows($result) == 0)
        {
        	$query = "INSERT INTO `album_details` (`uid`, `album_id`, `album_name`, `album_art`) VALUES ('$uid','1','$new_album_name','$file_name_album')";
        	mysqli_query($con,$query);
        	$aid=1;
        }
        else // else update the max index of album for new album craetion
        {
        	$query = "SELECT max(album_id) from album_details WHERE uid='$uid'";
        	$result = mysqli_query($con,$query);
        	$result = mysqli_fetch_array($result);
        	$aid = $result[0];
        	$aid++;
        	$query = "INSERT INTO `album_details` (`uid`, `album_id`, `album_name`, `album_art`) VALUES ('$uid','$aid','$new_album_name','$file_name_album')";
        	mysqli_query($con,$query);
        }
        $query="UPDATE user_song_map SET album_id='$aid' WHERE uid='$uid' AND custom_name='$rename'";
        mysqli_query($con,$query);
        echo "<script>  window.open('dashboard.php','_self');</script>";
    }
}

else
{
    header('Location: logout.php');
    die();
}
?>
