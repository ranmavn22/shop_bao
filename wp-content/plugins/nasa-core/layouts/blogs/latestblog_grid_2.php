<?php
$_delay = 0;
$_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
?>
<div class="nasa-blog-sc blog-grid blog-grid-style nasa-after-clear">
    <ul class="small-block-grid-<?php echo esc_attr($columns_number_small); ?> medium-block-grid-<?php echo esc_attr($columns_number_tablet); ?> large-block-grid-<?php echo esc_attr($columns_number); ?> grid desktop-margin-left-0 desktop-margin-right-0" data-product-per-row="<?php echo esc_attr($columns_number); ?>">
        <?php
        $k = 0;
        $count = wp_count_posts()->publish;
        if ($count > 0) :
            while ($recentPosts->have_posts()) :
                $recentPosts->the_post();
                $title = get_the_title();
                $link = get_the_permalink();
                $postId = get_the_ID();
                $categories = ($cats_enable == 'yes') ? get_the_category_list(esc_html__(', ', 'nasa-core')) : '';

                if ($author_enable == 'yes') :
                    $author = get_the_author();
                    $author_id = get_the_author_meta('ID');
                    $link_author = get_author_posts_url($author_id);
                endif;

                if ($date_enable == 'yes') :
                    $day = get_the_date('d', $postId);
                    $month = get_the_date('m', $postId);
                    $year = get_the_date('Y', $postId);
                    $link_date = get_day_link($year, $month, $day);
                    $date_post = get_the_date('d F', $postId);
                endif;

                $classLi = 'wow fadeInUp padding-top-0 padding-right-0 padding-bottom-0 padding-left-0';
                $classLi .= $columns_number_small == 1 ? ' mobile-margin-bottom-10 mobile-padding-left-10 mobile-padding-right-10' : '';

                echo '<li class="' . $classLi . '" data-wow-duration="1s" data-wow-delay="' . esc_attr($_delay) . 'ms"><div class="nasa-item-blog-grid nasa-item-blog-grid-2">';
                ?>
                    <div class="entry-blog">
                        <div class="entry-blog-title">
                            <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>"><?php echo $title; ?></a>
                        </div>

                        <div class="blog-image-fullwidth">
                            <?php
                            if (has_post_thumbnail()):
                                the_post_thumbnail('590x320', array(
                                    'alt' => esc_attr($title)
                                ));
                            else:
                                echo '<img src="' . NASA_CORE_PLUGIN_URL . 'assets/images/placeholder.png" alt="' . esc_attr($title) . '" />';
                            endif;
                            ?>
                        </div>
                    </div>

                    <div class="nasa-blog-info info-wrap nasa-blog-img-top">
                        <div class="nasa-blog-info-wrap margin-top-20 margin-left-30 margin-right-30">
                            <?php echo ($cats_enable == 'yes') ? '<div class="nasa-post-cats-wrap">' . $categories . '</div>' : ''; ?>
                            <a class="nasa-blog-title nasa-bold-700" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>"><?php echo $title; ?></a>

                            <div class="nasa-info-short"><?php the_excerpt(); ?></div>

                            <div class="nasa-date-author-wrap nasa-post-date-author-wrap">
                                <?php if ($date_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_date); ?>" title="<?php echo esc_html__('Posts at ', 'nasa-core') . esc_attr($date_post); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-date"></i>
                                            <?php echo $date_post; ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($author_enable == 'yes') : ?>
                                    <a href="<?php echo esc_url($link_author); ?>" title="<?php echo esc_html__('Posted By ', 'nasa-core') . esc_attr($author); ?>" class="nasa-post-date-author-link">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-user"></i>
                                            <?php echo $author; ?>
                                        </span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($readmore == 'yes') : ?>
                                    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_html__('Read more', 'nasa-core'); ?>" class="nasa-post-date-author-link hide-for-mobile nasa-post-read-more">
                                        <span class="nasa-post-date-author">
                                            <i class="pe-7s-news-paper"></i>
                                            <?php echo esc_html__('Read more', 'nasa-core'); ?>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php
                echo '</div></li>';
                $k++;
                $_delay += $_delay_item;
            endwhile;

            wp_reset_postdata();
        endif;
        ?>
    </ul>
</div>

<?php
if ($page_blogs == 'yes') : ?>
    <div class="text-center margin-top-40 margin-bottom-40">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" title="<?php echo esc_html__('All Blogs', 'nasa-core'); ?>" class="nasa-view-more button">
            <?php echo esc_html__('All Blogs', 'nasa-core'); ?>
        </a>
    </div>
<?php
endif;
