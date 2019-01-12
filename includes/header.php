<nav class="navbar navbar-inverse navbar-fixed-top" style="">
  <div class="container-fluid">
    <div class="navbar-header ">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Music</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <div class="col-md-6">
    <form class="navbar-form navbar-left" action="song_search.php" method="GET" style="width:100%;" >
      <div class="input-group" style="width:100%;"  >
        <input type="text" class="form-control" placeholder="Search" name="search" required>
        <div class="input-group-btn">
          <button class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Search by song" style="background-color:#e22727;" type="submit" name="search_song">
            <i class="glyphicon glyphicon-music"></i>
          </button>
          <button class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Search by user" style="background-color:#e22727;" type="submit" name="search_user">
            <i class="glyphicon glyphicon-user"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
  
    <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
