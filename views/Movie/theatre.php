<?php include 'views/header.php'; ?>
<?php include 'views/navbar.php'; ?>

  <div class="jumbotron">
	<div class="container">
		<h1>This Movies are currently in Theatre's</h1>
	</div>
</div>
<div class="container">
      <?php
						
						$moviesChunks = array_chunk ( $viewModel->get ( 'moviesArray' ), 3 );
						foreach ( $moviesChunks as &$chunk ) {
							
							?>
      <div class="row">
      <?php foreach ($chunk as $key => &$movie) { ?>
        <div class="col-sm-8 col-md-4">
			<div class="thumbnail">
				<img src="<?php echo $viewModel->get('AssetPath'); ?>/images/<?php echo $movie->getPicture(); ?>" alt="...">
				<div class="caption">
					<h3><?php printf("%s (%s)", $movie->getTitle(), $movie->getYear()); ?></h3>
					<p><?php echo $movie->getDescription()->getOutlinePlot(); ?></p>
				</div>
			</div>
		</div>
  <?php } ?>
  </div>
  <?php } ?>
</div>

<?php include 'views/footer.php'; ?>