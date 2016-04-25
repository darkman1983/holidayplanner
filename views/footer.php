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

    $.PeriodicalUpdater('<?php echo $viewModel->get ( 'BaseUrl' ); ?>ajax/checkloginstatus', {
        minTimeout: 6000,
        maxTimeout: 15000
        }, function(remoteData, success, chr, handle) {
            var result = {};
            if(success)
            {
                result = $.parseJSON(remoteData);

                if(!result['loggedIN'] && $(location).attr('href') != "<?php echo $viewModel->get ( 'BaseUrl' ); ?>")
                {
                    $(window).attr("location","<?php echo $viewModel->get ( 'BaseUrl' ); ?>");
                }
            }
    });
});
</script>
</body>
</html>