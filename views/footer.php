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
});
</script>
</body>
</html>