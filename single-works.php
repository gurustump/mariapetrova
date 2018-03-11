<?php get_header(); ?>

			<div id="content">

				<div id="inner-content">

						<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<?php if ($post->post_content !== "") { ?>
								<section class="entry-content wrap cf" itemprop="articleBody">
									<div class="work-description">
										<?php the_content(); ?>
									</div>
								
									<?php /* Gallery for this work */ 
									/*$workMeta = get_post_meta(get_the_ID());
									echo '<pre style="background:rgba(0,100,0,.2);padding:30px;color:black;">';
									print_r($workMeta);
									echo '</pre>';*/
									$workGalleryMeta = get_post_meta(get_the_ID(), '_gurustump_works_gallery_item', true);
									if (count($workGalleryMeta[0]) > 0 && $workGalleryMeta[0] != '' && !ctype_space($workGalleryMeta[0])) { ?>
									<ul class="work-gallery">
										<?php foreach($workGalleryMeta as $key => $galleryItem) {
											$img_meta = wp_get_attachment_metadata($galleryItem[image_id]);
											?>
											<li><?php /* <pre><?php print_r($galleryItem); ?></pre> */ ?>
												<img src="<?php echo $galleryItem[image]; ?>"<?php echo $galleryItem[offset_right] ? ' style="margin-left:'.$galleryItem[offset_right].'px"' : ''; ?> alt="<?php echo $img_meta[image_meta][title] ? $img_meta[image_meta][title] : $img_meta[file]; ?>">
											</li>
										<?php } ?>
									</ul>
									<?php } ?>
								</section>
								<?php } ?>
								
								<?php /* Prev/Next Work Navigation */ ?>
								<nav class="prev-next">
									<ul>
										<li class="prev"><?php echo previous_post_link('%link', 'Previous'); ?></li>
										<li class="next"><?php echo next_post_link('%link', 'Next'); ?></li>
									</ul>
								</nav>
								
								<?php /* Thumbnail Navigation for other works */
								$items = get_posts(array(
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
