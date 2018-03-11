<?php
/*
 Template Name: Works Page
 *
 * Page for displaying a grid of the "Works" post-type
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content">

						<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<?php if ($post->post_content !== "") { ?>
								<section class="entry-content wrap cf" itemprop="articleBody">
									<p>TESTORAMA</p>
									<?php
										// the content (pretty self explanatory huh)
										the_content();

										/*
										 * Link Pages is used in case you have posts that are set to break into
										 * multiple pages. You can remove this if you don't plan on doing that.
										 *
										 * Also, breaking content up into multiple pages is a horrible experience,
										 * so don't do it. While there are SOME edge cases where this is useful, it's
										 * mostly used for people to get more ad views. It's up to you but if you want
										 * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
										 *
										 * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
										 *
										*/
										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
										) );
									?>
								</section>
								<?php } ?>
								<?php $items = get_posts(array(
									'posts_per_page'=>-1,
									'post_type'=>'works',
									'orderby'=>'menu_order',
									'order'=>'ASC'
								));
								if (count($items) > 0) {
								?>
								<section class="thumb-grid-container">
									<ul class="thumb-grid">
										<?php
										foreach($items as $key => $item) {
											$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID));
											$itemMeta = get_post_meta($item->ID); ?>
											<li>
												<?php /* <pre><?php print_r($item); ?></pre>
												<pre style="background:black;color:yellow;padding:20px;"><?php print_r($itemThumbArray); ?></pre>
												<pre><?php print_r($itemMeta); ?></pre> 
												<pre><?php echo get_permalink($item->ID); ?></pre> */ ?>
												<a href="<?php echo get_permalink($item->ID); ?>">
													<img class="item-thumb" src="<?php echo $itemThumbArray[0]; ?>" />
												</a>
											</li>
										<?php } ?>
									</ul>
								</section>
								<?php } ?>
							</article>

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</main>


				</div>

			</div>


<?php get_footer(); ?>
