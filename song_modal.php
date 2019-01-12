
	<style>
input[type='file']{
  color:blue;
  font-size:10px;
}
.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #e22727;
	font-size: 20px;
}

.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #59B2E0;
	outline: none;
	color: #fff;
	font-size: 12px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #53A3CD;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
div.upload {
    width: 157px;
    height: 57px;
    background: url(https://lh6.googleusercontent.com/-dqTIJRTqEAQ/UJaofTQm3hI/AAAAAAAABHo/w7ruR1SOIsA/s157/upload.png);
    overflow: hidden;
}

div.upload input {
    display: block !important;
    width: 157px !important;
    height: 57px !important;
    opacity: 0 !important;
    overflow: hidden !important;
}
</style>
<!-- BEginning of modal -->
<div class="modal fade" id="Modal3" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: #191919; color:white;">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle3">Upload Song</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      		<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form3" action="song_backend.php" method="post" role="form" style="display: block;" enctype="multipart/form-data">
									<fieldset>
										<legend style="color:white; ">Song:</legend>
									<div class="form-group">
										<div class="upload">
									        <input type="file" name="song" />
									    </div>
									</div>
									<div class="form-group">
										<input type="text" name="rename" id="rename3" tabindex="2" class="form-control" placeholder="Name you want">
									</div>
								</fieldset>
								<fieldset>
										<legend  style="color:white; ">Album:</legend>
										<button id="exist_button3" type="button" class="btn btn-primary">Existing Album</button>
										<button id="new_album_button3" type="button" class="btn btn-primary">New Album</button><hr>
									<div class="dropdown" id="exist_album3">
									  <select class="btn btn-primary dropdown-toggle" id="album_select3" name="album_select">
									  		<option value='-1'>Select from previous album</option>
									  	<?php
									  	include('includes/connection.php');
									  	$query = "SELECT * FROM `album_details` WHERE uid='$uid'";
									  	$result = mysqli_query($con, $query);
									  	while($row = mysqli_fetch_array($result))
									  	{
									  		echo "<option value=".$row['album_id'].">".$row['album_name']."</option>";
									  	}
									  	?>
									  </select>
									</div>
									<div id="new_album3">
									<!-- <h4 style="text-align: center;">---OR---</h4> -->
									<h5>Create New Album</h5>
									<div class="form-group">
										<input type="text" name="album_name" id="album_name3" tabindex="3" class="form-control" placeholder="New Album Name">
									</div>
									<div class="form-group">
										Album Art:
										<div class="upload">
									        <input type="file" name="album_art" id="album_art_input3"/>
									    </div>
									</div>
								</div><hr>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="upload" id="upload3" tabindex="4" class="form-control btn btn-login" value="Upload" style="background-color:#e22727">
											</div>
										</div>
									</div>
									</fieldset>
								</form>
								</div>
						</div>
					</div>
      </div>
    </div>
  </div>
</div>
<!-- End of modal -->
<!-- Implementing new album and existing album -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#exist_album3").hide();
		$("#new_album3").hide();
		console.log("abc");
		$("#album_select3").attr("required", true);
		$("#album_name3").attr("required", true);
		$("#album_art_input3").attr("required", true);
	})
	$("#exist_button3").click(function(){
		console.log("def");
		$("#exist_album3").show();
		$("#new_album3").hide();
		$("#album_select3").attr("required", true);
		$("#album_name3").attr("required", false);
		$("#album_art_input3").attr("required", false);
	});
	$("#new_album_button3").click(function(){
		$("#exist_album3").hide();
		$("#new_album3").show();
		$("#album_select3").attr("required", false);
		$("#album_name3").attr("required", true);
		$("#album_art_input3").attr("required", true);
	});
</script>


</html>	