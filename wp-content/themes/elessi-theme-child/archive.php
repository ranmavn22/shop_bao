<?php
/**
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package nasatheme
 */

$nasa_sidebar = isset($nasa_opt['blog_layout']) ? $nasa_opt['blog_layout'] : 'left';
$hasSidebar = true;
$left = true;
switch ($nasa_sidebar):
    case 'right':
        $left = false;
        $attr = 'large-8 medium-12 tablet-padding-right-10 desktop-padding-right-30 left columns';
        break;
    
    case 'no':
        $hasSidebar = false;
        $left = false;
        $attr = 'large-12 columns';
        break;
    
    case 'left':
    default:
        $attr = 'large-8 medium-12 tablet-padding-left-10 desktop-padding-left-30 right columns';
        break;
endswitch;

$class_wrap = 'container-wrap mobile-padding-top-10';
$class_wrap .= $nasa_sidebar ? ' page-' . $nasa_sidebar . '-sidebar' : ' page-left-sidebar';

if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) :
    $attr .= ' nasa-blog-in-mobile';
endif;

$headling = !isset($nasa_opt['blog_heading']) || $nasa_opt['blog_heading'] ? true : false;

$category = get_category( get_query_var( 'cat' ) );
$cat_id = $category->cat_ID;

get_header();

/**
 * Hook: nasa_before_archive_blog.
 */
do_action('nasa_before_archive_blogs');
?>

<div class="<?php echo esc_attr($class_wrap); ?>">

    <?php include_once 'includes/search_docs.php' ?>

    <div class="row categories-docs-content">
        <div id="content" class="<?php echo esc_attr($attr); ?>">
            <?php if (have_posts()) : ?>
                <?php if ($headling) : ?>
                    <header class="page-header">
                        <h1 class="page-title">
                            <?php
                            if (is_category()) :
                                printf(esc_html__('%s', 'elessi-theme'), '<span>' . single_cat_title('', false) . '</span>');

                            elseif (is_tag()) :
                                printf(esc_html__('%s', 'elessi-theme'), '<span>' . single_tag_title('', false) . '</span>');

                            elseif (is_author()) : the_post();
                                printf(esc_html__('%s', 'elessi-theme'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>');
                                rewind_posts();

                            elseif (is_day()) :
                                printf(esc_html__('%s', 'elessi-theme'), '<span>' . get_the_date() . '</span>');

                            elseif (is_month()) :
                                printf(esc_html__('%s', 'elessi-theme'), '<span>' . get_the_date('F Y') . '</span>');

                            elseif (is_year()) :
                                printf(esc_html__('%s', 'elessi-theme'), '<span>' . get_the_date('Y') . '</span>');

                            elseif (is_tax('post_format', 'post-format-aside')) :
                                esc_html_e('Asides', 'elessi-theme');

                            elseif (is_tax('post_format', 'post-format-image')) :
                                esc_html_e('Images', 'elessi-theme');

                            elseif (is_tax('post_format', 'post-format-video')) :
                                esc_html_e('Videos', 'elessi-theme');

                            elseif (is_tax('post_format', 'post-format-quote')) :
                                esc_html_e('Quotes', 'elessi-theme');

                            elseif (is_tax('post_format', 'post-format-link')) :
                                esc_html_e('Links', 'elessi-theme');

                            else :
                                esc_html_e('', 'elessi-theme');

                            endif;
                            ?>
                        </h1>
                        <?php
                        if (is_category()) :
                            $category_description = category_description();
                            if (!empty($category_description)) :
                                echo apply_filters('category_archive_meta', '<div class="taxonomy-description margin-bottom-30">' . $category_description . '</div>');
                            endif;

                        elseif (is_tag()) :
                            $tag_description = tag_description();
                            if (!empty($tag_description)) :
                                echo apply_filters('tag_archive_meta', '<div class="taxonomy-description margin-bottom-30">' . $tag_description . '</div>');
                            endif;

                        endif;
                        ?>
                    </header>
                <?php endif; ?>

                <div class="page-inner">
                    <?php get_template_part('content', get_post_format()); ?>
                </div>
            <?php else : ?>
                <?php get_template_part('no-results', 'archive'); ?>
            <?php endif; ?>
        </div>

        <?php if ($nasa_sidebar != 'no') : ?>
            <div class="large-4 columns <?php echo $left ? 'left desktop-padding-right-20' : 'right desktop-padding-left-20'; ?>  desktop-padding-bottom-50 col-sidebar">
                <?php include_once 'includes/sidebar_docs.php' ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
