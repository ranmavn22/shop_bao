<?php
/**
 * The main template file.
 *
 * @package nasatheme
 */

$nasa_sidebar = isset($nasa_opt['blog_layout']) ? $nasa_opt['blog_layout'] : 'left';
if (!is_active_sidebar('blog-sidebar')) :
    $nasa_sidebar = 'no';
endif;

$hasSidebar = true;
$left = true;
switch ($nasa_sidebar):
    case 'right':
        $left = false;
        $attr = 'large-9 medium-12 tablet-padding-right-10 desktop-padding-right-30 left columns';
        break;
    
    case 'no':
        $hasSidebar = false;
        $left = false;
        $attr = 'large-12 columns';
        break;
    
    case 'left':
    default:
        $attr = 'large-9 medium-12 tablet-padding-left-10 desktop-padding-left-30 right columns';
        break;
endswitch;

if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) :
    $attr .= ' nasa-blog-in-mobile';
endif;

$class_wrap = 'container-wrap mobile-padding-top-10 page-' . $nasa_sidebar . '-sidebar';

$headling = isset($nasa_opt['posts_heading']) && $nasa_opt['posts_heading'] ? true : false;

get_header();

/**
 * Hook: nasa_before_archive_blog.
 */
do_action('nasa_before_archive_blogs');
?>

<div class="<?php echo esc_attr($class_wrap); ?>">
    <?php if ($hasSidebar):?>
        <div class="div-toggle-sidebar nasa-blog-sidebar center">
            <a class="toggle-sidebar" href="javascript:void(0);" rel="nofollow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="26px" height="24px" fill="currentColor"><path d="M 4 7 L 4 9 L 28 9 L 28 7 Z M 4 15 L 4 17 L 28 17 L 28 15 Z M 4 23 L 4 25 L 28 25 L 28 23 Z"></path></svg>
            </a>
        </div>
    <?php endif;?>
        
    <div class="row">
        <div id="content" class="<?php echo esc_attr($attr);?>">
            <?php if ($headling) : ?>
                <header class="page-header">
                    <h1 class="page-title text-center"><?php echo esc_html__('Blog', 'elessi-theme'); ?></h1>
                </header>
            <?php endif; ?>
            
            <div class="page-inner">
                <?php if (have_posts()) :
                    get_template_part('content', get_post_format());
                else :
                    get_template_part('no-results', 'index');
                endif; ?>
            </div>
        </div>

        <?php if ($nasa_sidebar != 'no'):?>
            <div class="large-3 columns  <?php echo ($left) ? 'left desktop-padding-right-20' : 'right desktop-padding-left-20'; ?> desktop-padding-bottom-50 col-sidebar">
                <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'elessi-theme'); ?>" class="hidden-tag nasa-close-sidebar" rel="nofollow">
                    <?php echo esc_html__('Close', 'elessi-theme'); ?>
                </a>
                <?php get_sidebar(); ?>
            </div>
        <?php endif;?>
    </div>
</div>

<?php
get_footer();
