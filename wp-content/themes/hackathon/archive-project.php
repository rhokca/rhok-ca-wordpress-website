<?php get_header(); ?>

<?php include('searchbar-project.php'); ?>

<style>
.btn-view {
	background-color: #ccc;
	color:#666;
	margin: 0 10px;
}
</style>

<section style="padding:20px 0 0 0 ;">
	<div class="container cf">
		<a href="<?php bloginfo('url'); ?>/submit-project/" class="btn right">Submit your project</a>
	  	<a href="?view=table" class="btn right btn-view">Table view</a>
		<a href="?view=grid" class="btn right btn-view">Grid view</a>
	</div>
</section>

<section>
  <div class="container cf">
    <?php if ( have_posts() ): include( ($_GET["view"]=="table")?'loop-project-table.php':'loop-project.php' ); else: ?>
    <p class="empty-section">Nothing yet! Check back soon.</p>
	<?php endif; ?>
  </div><!-- /container -->
</section>
<?php get_footer(); ?>
