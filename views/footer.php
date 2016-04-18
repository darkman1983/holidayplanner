<hr>
<?php include 'views/login.php'; ?>
      <footer>
        <p>&copy; 2016 Timo Stepputtis</p>
      </footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo @$viewModel->get('AssetPath'); ?>js/moviedb.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo @$viewModel->get('AssetPath'); ?>js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $("#loginBtn").click(function(){
        $("#loginModal").modal();
    });
});
</script>
</body>
</html>