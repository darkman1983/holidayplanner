<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>
<div class="jumbotron">      
      <div class="container">
      <form class="form-signin">
      <h2 class="form-signin-heading">Movie DB - User Sign in</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
      </div>
    </div>
<?php include 'views/footer.php'; ?>