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

    $('#forgotPassword').popover({
		'trigger': 'hover focus',
		'placement': 'bottom',
		'title': 'Information',
		'content': 'Bitte den Administrator für ein neues Passwort Informieren!'
		});

    $('#loginModal').on('shown.bs.modal', function () {
        $('#usrname').focus();
    });

    $('#loginButton').on('click', function(e) {
    	$.ajax({
            type: "POST",
            url: '<?php echo $viewModel->get('BaseUrl'); ?>login/login',
            data: $("#loginFrm").serialize(), // serializes the form's elements.
            dataType: 'json',
            beforeSend: function(){
            	$("#loadingIndicator").toggleClass('loading-indicator-hidden');
            	$('#loginButton').attr('disabled','disabled');
            },
            success: function(data)
            {
                switch(data.status)
                {
                case 0:
                	new PNotify({
                	    title: 'Oh Nein!',
                	    text: data.text,
                	    type: 'error'
                	});
                	$('#loginButton').removeAttr('disabled');
                	break;
                case 1:
                	new PNotify({
                	    title: 'Super!',
                	    text: data.text,
                	    type: 'success'
                	});
                	$(location).wait(2500).attr('href', '<?php echo $viewModel->get('BaseUrl'); ?>');
                    break;
                }
                $("#loadingIndicator").toggleClass('loading-indicator-hidden');
            },
            fail: function() {
            	new PNotify({
            	    title: 'Oh Nein!',
            	    text: 'Es kann keine Verbindung zum Server hergestellt werden.',
            	    type: 'error'
            	});
            	$('#loginButton').removeAttr('disabled');
            }
          });
    });

    $('#loginFrm').on('submit', function(e){
    	e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $('#loginFrm input').on('keydown', function(e){
    	if(e.which == 13)
    	{
        	$('#loginButton').click();
    	}
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