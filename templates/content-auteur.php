  <?php if(kadence_display_sidebar()) {
        $slide_sidebar = 848;
      } else {
        $slide_sidebar = 1140;
      }
      global $post, $virtue;
      $headcontent = get_post_meta( $post->ID, '_kad_blog_head', true );
      $height      = get_post_meta( $post->ID, '_kad_posthead_height', true );
      $swidth      = get_post_meta( $post->ID, '_kad_posthead_width', true );
      if(empty($headcontent) || $headcontent == 'default') {
          if(!empty($virtue['post_head_default'])) {
              $headcontent = $virtue['post_head_default'];
          } else {
              $headcontent = 'none';
          }
      }
      if (!empty($height)) {
        $slideheight = $height; 
      } else {
        $slideheight = 400;
      }
      if (!empty($swidth)) {
        $slidewidth = $swidth; 
      } else {
        $slidewidth = $slide_sidebar;
      } 

    /**
    * 
    */
    $height = 200;
    do_action( 'kadence_single_post_begin' ); 
    ?>
<div id="content" class="container">
    <div class="row single-article" itemscope="" itemtype="http://schema.org/BlogPosting">
        <div class="main <?php echo esc_attr( kadence_main_class() ); ?>" role="main">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?>>
            <?php
             do_action( 'kadence_single_post_before' ); 

            if ($headcontent == 'flex') { ?>
                <section class="postfeat">

                    <?php  
                    $itemsize = 'tcol-lg-4 tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12';
                    if (!empty($height)) {
                        $imageHeight = $height; 
                    } else {
                        $imageHeight = 200;
                    }
                    $imageWidth = null;
                    $md = 3;
                    $sm = 3;
                    $xs = 2;
                    $ss = 1; ?>
                    <div class="full-width fredcarousel carouFredSel-gallery" style="height: <?php echo $imageHeight.'px;';?>">
                        <div id="carouselcontainer" class="rowtight fadein-carousel">
                            <div id="portfolio-carouselw" class="clearfix caroufedselclass initcaroufedsel clearfix" 
                                data-carousel-container="#carouselcontainer" data-carousel-transition="700" data-carousel-scroll="1" data-carousel-auto="true" data-carousel-speed="3000" data-carousel-id="portfolio" 
                                data-carousel-md="<?php echo esc_attr($md);?>" data-carousel-sm="<?php echo esc_attr($sm);?>" data-carousel-xs="<?php echo esc_attr($xs);?>" data-carousel-ss="<?php echo esc_attr($ss);?>">
                                <?php
                                $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                                if(!empty($image_gallery)) {
                                    $attachments = array_filter( explode( ',', $image_gallery ) );
                                    if ($attachments) {
                                        foreach ($attachments as $attachment) {
                                            $attachment_src = wp_get_attachment_image_src($attachment , 'full');
                                            $caption = get_post($attachment)->post_excerpt;
                                            $image = aq_resize($attachment_src[0], null, $imageHeight, false, false, false, $attachment);
                                                if(empty($image[0])) { $image = array($attachment_src[0], $attachment_src[1], $attachment_src[2]); }
                                            ?>
                                            
                                            <div class="<?php echo $itemsize; ?> kad_portfolio_item">
                                                <div class="grid_item portfolio_item postclass">
                        
                                                    <div class="imghoverclass">
                                                        <a href="<?php echo $attachment_src[0]; ?>" title="<?php esc_attr($caption); ?>" class="kad_portfolio_link" data-rel="lightbox">
                                                            <img src="<?php echo esc_url($image[0]); ?>" alt="<?php esc_attr($caption); ?>" 
                                                                height="100%" x-width="<?php echo esc_attr($image[1]);?>" x-height="<?php echo esc_attr($image[2]);?>" class="lightboxhover" style="display: block;"
                                                                <?php echo kt_get_srcset_output($image[1], $image[2], $attachment_src[0], $attachment); ?>
                                                            >
                                                        </a> 
                                                    </div>
                        
                                                    <?php if(!empty($caption)) { ?>
                                                        <a href="<?esc_url($attachment_src[0]) ?>" class="portfoliolink" data-rel="lightbox">
                                                            <div class="piteminfo">   
                                                                <h5><?php echo  $caption;?></h5>
                                                                <?php if($portfolio_item_types == 1) { $terms = get_the_terms( $post->ID, 'portfolio-type' ); if ($terms) {?> 
                                                                    <p class="cportfoliotag"><?php $output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?></p> 
                                                                <?php } } ?>
                                                            </div>
                                                        </a>
                                                    <?php } ?>
                        
                                                </div>
                                            </div>
                                        <?php } ?>                    
                                    <?php } ?>                    
                                <?php } ?>                    

                            
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <a id="prevport-portfolio" class="prev_carousel icon-chevron-left" href="#"></a>
                        <a id="nextport-portfolio" class="next_carousel icon-chevron-right" href="#"></a>
                    </div> <!-- fred Carousel-->
                        
                </section>
            <?php } else if ($headcontent == 'video') { ?>
                <section class="postfeat">
                    <div class="videofit">
                        <?php echo do_shortcode( get_post_meta( $post->ID, '_kad_post_video', true ) ); ?>
                    </div>
                </section>
            <?php } else if ($headcontent == 'image') {
                    if (has_post_thumbnail( $post->ID ) ) {        
                        $image_id = get_post_thumbnail_id();
                        $image_src = wp_get_attachment_image_src( $image_id, 'full' );
                        $image = aq_resize( $image_src[0], $slidewidth, $slideheight, true, false, false, $image_id); //resize & crop the image
                        if(empty($image[0])) { $image = array($image_src[0], $image_src[1], $image_src[2]); }
                        ?>
                            <div class="imghoverclass postfeat post-single-img" itemprop="image">
                                <a href="<?php echo esc_url($image_src[0]); ?>" data-rel="lightbox" class="lightboxhover">
                                    <img src="<?php echo esc_url($image[0]); ?>"  width="<?php echo esc_attr($image[1]); ?>" height="<?php echo esc_attr($image[2]); ?>" <?php echo kt_get_srcset_output($image[1], $image[2], $image[0], $image_id);?> itemprop="image" alt="<?php the_title(); ?>" />
                                </a>
                            </div>
                        <?php
                    } 
            }  ?>

                <?php
                  /**
                  * @hooked virtue_single_post_meta_date - 20
                  */
                  do_action( 'kadence_single_post_before_header' );
                  ?>
                <header>
                    <?php 
                    /**
                    * @hooked virtue_post_header_title - 20
                    * @hooked virtue_post_header_meta - 30
                    */
                    do_action( 'kadence_single_post_header' );
                    ?>
                </header>

                <div class="entry-content" itemprop="description articleBody">
                    <?php
                    do_action( 'kadence_single_post_content_before' );
                        
                        the_content(); 
                      
                    do_action( 'kadence_single_post_content_after' );
                    ?>
                </div>

                <footer class="single-footer">
                <?php 
                  /**
                  * @hooked virtue_post_footer_pagination - 10
                  * @hooked virtue_post_footer_tags - 20
                  * @hooked virtue_post_footer_meta - 30
                  * @hooked virtue_post_nav - 40
                  */
                  do_action( 'kadence_single_post_footer' );
                  ?>
                </footer>
            </article>
            <?php
            /**
            * @hooked virtue_post_authorbox - 20
            * @hooked virtue_post_bottom_carousel - 30
            * @hooked virtue_post_comments - 40
            */
            do_action( 'kadence_single_post_after' );
            
            endwhile; ?>
        </div>
        <?php 
        do_action( 'kadence_single_post_end' ); 
?>

/* add */      

<div class="home-portfolio home-margin carousel_outerrim home-padding">

   
            
    </div> <!--featclass -->