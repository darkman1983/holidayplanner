<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">It-Solutions Urlaubsplaner</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo $viewModel->get('BaseUrl'); ?>">Index <span class="sr-only">(current)</span></a></li>
        <?php
        $loggedIN = $viewModel->get ( 'loggedIN' );
        $level = $viewModel->get ( 'level' );
        
        if($loggedIN) {
        ?>
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Urlaub <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li class="dropdown-header">Allgemein</li>
        <li><a href="<?php echo $viewModel->get('BaseUrl'); ?>holiday">Übersicht</a></li>
        <?php if($level == 1) { ?><li><a href="<?php echo $viewModel->get('BaseUrl'); ?>feastdays">Urlaubs- & Feiertage</a></li><?php } ?>
        </ul>
        </li>
        <?php
        }
        
        if ( $loggedIN && $level > 1 ) {
          $holiday_menu = array("**Allgemein" => array(3, ""), "Benutzer" => array(3, "user"), "Urlaubs- & Feiertage" => array (3,"feastdays" ), "**Urlaub" => array(2, ""),"Übersicht Anträge" => array (2,"manager" ) );
        
        ?>
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Verwaltung <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <?php
        $first = '';
          foreach ( $holiday_menu as $entry => &$data ) {
            if ( $data [0] <= $level ) {
              if (empty($first)) {
                $first = $entry;
              }
              if ( !strstr($entry, '**') ) {
                printf ( '<li><a href="%s%s">%s</a></li>', $viewModel->get ( 'BaseUrl' ), $data [1], $entry );
              } else {
                echo ($entry != $first) ? '<li role="separator" class="divider"></li>' : '';
                printf('<li class="dropdown-header">%s</li>', substr($entry, 2));
                echo '<li role="separator" class="divider"></li>';
              }
            }
          }
        
          echo '</ul>
        </li>';
        }
        ?>
      </ul>
      </li>
      </ul>
      <!--  <form class="navbar-form navbar-left" role="search">
        <div class="row">
  <div class="col-lg-10">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search for..." />
      <span class="input-group-btn">
        <button class="glyphicon glyphicon-search btn btn-secondary" type="button"></button>
      </span>
    </div>
  </div>
</div>
      </form> -->
      <ul class="nav navbar-nav navbar-right" style="margin-right: 5px">
        <?php         
        if ($loggedIN)
        {
          echo sprintf('<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Willkommen %s %s <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="%slogin/logout">Logout</a></li>
            <!-- <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li> -->
          </ul>
        </li>', $viewModel->get('firstname'), $viewModel->get('lastname'), $viewModel->get('BaseUrl'));
        }else {
          echo '<li><a href="#" class="glyphicon glyphicon-user text-uppercase bold-font" id="loginBtn">&nbsp;Login</a></li>';
        }
        ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php if($viewModel->get('loggedIN')) { ?>
<?php include 'views/logouttime.php';?>
<?php } ?>