<hr>
<?php include 'views/login.php'; ?>
<footer>
	<p>&copy; 2016 Timo Stepputtis</p>
</footer>
<script>
$(document).ready(function(){
    $("#loginBtn").click(function(){
        $("#loginModal").modal();
    });

    $('#loginModal').on('shown.bs.modal', function () {
        $('#usrname').focus();
    });

    $.periodic({period: 10000, decay: 1.2, max_period: 15000}, function() {
        var logouttime = <?php echo $viewModel->get ( 'logouttime' ); ?>;
        var currentTime = Math.round(new Date().getTime()/1000);

     if(logouttime < currentTime)
     {
         $(window).attr("location","<?php echo $viewModel->get ( 'BaseUrl' ); ?>");
     }
   	 
   	});

    /*$.PeriodicalUpdater('<?php echo $viewModel->get ( 'BaseUrl' ); ?>ajax/checkloginstatus', {
        minTimeout: 6000,
        maxTimeout: 15000
        }, function(remoteData, success, chr, handle) {            
            if(success)
            {
            	var currentTime = Math.round(new Date().getTime()/1000);
                var result = $.parseJSON(remoteData);

                if(result['logouttime'] < currentTime)
                {
                    $(window).attr("location","<?php echo $viewModel->get ( 'BaseUrl' ); ?>");
                }
            }
    });*/
});
</script>
</body>
</html>