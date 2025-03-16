<?php include "head.php" ?>
    <button class="scroll-topBtn"><i class="ri-plane-line"></i></button>
<?php include "navigation.php" ?>
    <div class="thank-page-content">
        <div class="thank-you-content">
            <h1>Thank you for your <br> interest</h1>
            <p>Our team will get in touch with you.</p>
            <a href="index.php" class="know-more mt-5">Back To Home</a>
        </div>
    </div>
  <?php include "footer.php" ?>
  <?php include "tail.php" ?>
  <script>
var url1  = localStorage.getItem("currentURL");
if (url1 === null){
    var url  = "https://revestravels.com/";
}else{
    var url = url1;
}
var count = 5;
setInterval(function(){
    count--;
    if (count === 0) {
        window.location=url;
    }
},1000);

</script>