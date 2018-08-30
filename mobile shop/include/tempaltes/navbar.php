
  
  <nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- <a class="navbar-brand" href="buy.php?do=Manage">Home</a> -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<?php 
 
        $stmt=$con->prepare("SELECT * from  shop");
         $stmt->execute();
         $shops=$stmt->fetchALL();
?>      
   

      <ul class="nav navbar-nav">
      <?php  foreach ($shops as $shop) {
           echo "<li><a href='shop1.php?do=Manage&shopid=".$shop['ShopID']."'>"; 

           echo $shop['ShopName']. "</a></li>";
      } ?>
       
       <?php if(isset($_SESSION['admin'])){?>
        <li><a href="users.php?do=Manage">مستخدمين</a></li>
       <?php }?>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">خيارات<span class="caret"></span></a>
          <ul class="dropdown-menu">
              
       <?php if(isset($_SESSION['admin'])){?>
                <li><a href="users.php?do=Edit&userid=<?php echo $_SESSION['id']; ?>">تعديل</a></li>
      
                  <li><a href="revok.php?do=Manage">نواقص</a></li>
       <?php }?>
        
           
            
            <li><a href="logout.php">تسجيل خروج</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

