<?php
$categories = get_categories( array(
    'orderby' => 'name',
    'order'   => 'ASC'
));

if (!empty($categories)) {
    echo "<div class='category-docs'>";
    foreach ($categories as $category) {
        $posts = get_posts(['category' => $category->term_id]);
        wp_reset_query();
        $isActive = (!empty($cat_id) && $cat_id == $category->term_id);
        ?>
        <div id="" class="widget widget_categories nasa-inited <?php echo $isActive ? 'category-active' : '' ?>">
            <span class="widget-title">
                <img src="<?php echo get_site_url() . '/wp-content/themes/elessi-theme-child/assets/images/cat-icon.svg' ?>" alt="">
                <?php echo $category->name; ?>
                <span class="docs-count"><?php echo count($posts); ?></span>
            </span>
            <a href="javascript:void(0);" class="nasa-toggle-widget <?php echo $isActive ? '' : 'nasa-hide' ?>"></a>
            <div class="nasa-open-toggle <?php echo $isActive ? '' : 'display-none' ?>">
                <ul>
                    <?php foreach ($posts as $post) {?>
                        <li class="cat-item <?php echo (!empty($postId) && $postId == $post->ID) ? 'active' : ''?>">
                            <a href="<?php echo get_permalink($post->ID)?>">
                                <img src="<?php echo get_site_url() . '/wp-content/themes/elessi-theme-child/assets/images/docs.svg' ?>" alt="">
                                <?php echo $post->post_title ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php
    }
    echo "</div>";
}
?>