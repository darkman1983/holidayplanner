<br>
<hr>
<?php include 'views/login.php'; ?>
<footer>
	<p>&copy; 2016 Timo Stepputtis</p>
</footer>
<script>
$(document).ready(function(){
	var loggedIN = <?php echo $viewModel->get ( 'loggedIN' ) ? 'true' : 'false'; ?>;
	
    $("#loginBtn").click(function(){
        $("#loginModal").modal();
    });

    $('#loginModal').on('shown.bs.modal', function () {
        $('#usrname').focus();
    });
    
    if(loggedIN)
    {
        $.periodic({period: 10000, decay: 1.2, max_period: 15000}, function() {
            var logouttime = <?php echo $viewModel->get ( 'logouttime' ); ?>;
            var currentTime = Math.round(new Date().getTime()/1000);
            //console.log('[' + moment().format('DD.MM.YYYY HH:mm:ss') + '] ' + "Executing periodic updater...");

            if(logouttime < currentTime)
              {
                $(window).attr("location","<?php echo $viewModel->get ( 'BaseUrl' ); ?>login/logout");
              }
            });
        }
    });
</script>
</body>
</html>