<?php
/**
 * The Template for displaying all single posts.
 *
 * @package nasatheme
 */
$nasa_sidebar = isset($nasa_opt['single_blog_layout']) ? $nasa_opt['single_blog_layout'] : 'left';
if (!is_active_sidebar('blog-sidebar')) :
    $nasa_sidebar = 'no';
endif;

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
        $attr = 'large-10 columns large-offset-1';
        break;
    
    case 'left':
    default:
        $attr = 'large-8 medium-12 tablet-padding-left-10 desktop-padding-left-30 right columns';
        break;
endswitch;

if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) :
    $attr .= ' nasa-blog-in-mobile';
endif;

$class_wrap = 'container-wrap mobile-padding-top-10 tablet-padding-top-10 nasa-single-blog page-' . $nasa_sidebar . '-sidebar';
$postId = get_the_id();
$terms = get_the_terms( $postId, 'category' );
$cat_id = $terms[0]->term_id;
$catName = $terms[0]->name;

get_header();
?>

<div class="<?php echo esc_attr($class_wrap); ?>">

    <?php include_once 'includes/search_docs.php' ?>

    <div class="row categories-docs-content">
        <div id="content" class="<?php echo esc_attr($attr); ?>">
            <div class="page-inner">
                <?php
                while (have_posts()) : the_post();
                    get_template_part('content', 'single');
                endwhile;
                ?>
            </div>
        </div>

        <?php if ($nasa_sidebar != 'no') : ?>
            <div class="large-4 columns desktop-padding-bottom-50 <?php echo ($left) ? 'left' : 'right'; ?> col-sidebar">
                <?php include_once 'includes/sidebar_docs.php' ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
