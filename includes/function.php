<?php
function faq_register_script() {
    
    wp_register_script('faq_jquery', PLUGIN_PATH.'/js/accordion.js', array('jquery'), '2.5.1' );
    wp_register_style( 'faq_style', PLUGIN_PATH.'/css/demo.css', false, '1.0.0', 'all');
    wp_register_style( 'faq_style', PLUGIN_PATH.'/css/defaults.css', false, '1.0.0', 'all');
}

function faq_ajax_load_scripts() {
    wp_enqueue_script( "ajax-faq", PLUGIN_PATH . '/js/function.js', array( 'jquery' ) );
    wp_localize_script( 'ajax-faq', 'faq_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );    
}

function faq_enqueue_style(){
   wp_enqueue_script('faq_jquery');
   wp_enqueue_style( 'faq_style' );
}
function faq() {
        $labels = array(
        'name'              => _x( 'Faq Category', 'Faq Category', 'textdomain' ),
        'singular_name'     => _x( 'Faq Category', 'Faq Category', 'textdomain' ),
        'search_items'      => __( 'Search Category', 'textdomain' ),
        'all_items'         => __( 'All Category', 'textdomain' ),
        'parent_item'       => __( 'Parent Category', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
        'edit_item'         => __( 'Edit Category', 'textdomain' ),
        'update_item'       => __( 'Update Category', 'textdomain' ),
        'add_new_item'      => __( 'Add New Category', 'textdomain' ),
        'new_item_name'     => __( 'New Category Name', 'textdomain' ),
        'menu_name'         => __( 'Faq Category', 'textdomain' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'faqcategory' ),
    );

    register_taxonomy( 'faqcategory', array( 'book' ), $args );
    $labels = array(
        'name'                  => _x( 'Faqs', 'Frequently Asked Questions', 'text_domain' ),
        'singular_name'         => _x( 'Faq', 'Frequently Asked Question', 'text_domain' ),
        'menu_name'             => __( 'Faqs', 'text_domain' ),
        'name_admin_bar'        => __( 'Faq', 'text_domain' ),
        'archives'              => __( 'Faq Archives', 'text_domain' ),
        'attributes'            => __( 'Faq Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Faq:', 'text_domain' ),
        'all_items'             => __( 'All Faqs', 'text_domain' ),
        'add_new_item'          => __( 'Add New Faq', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Faq', 'text_domain' ),
        'edit_item'             => __( 'Edit Faq', 'text_domain' ),
        'update_item'           => __( 'Update Faq', 'text_domain' ),
        'view_item'             => __( 'View Faq', 'text_domain' ),
        'view_items'            => __( 'View Faqs', 'text_domain' ),
        'search_items'          => __( 'Search Faq', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into faq', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Faqs list', 'text_domain' ),
        'items_list_navigation' => __( 'Faqs list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter faqs list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Faq', 'text_domain' ),
        'description'           => __( 'Create New FAQ List', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( ),
        'taxonomies'            => array( 'faqcategory', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,        
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'faq', $args );
}

function loadfaq() {
    $paged      = $_POST["paged"];
    $ppp        = $_POST["ppp"];
    $category   = $_POST["category"];
    $categoryFilter = array();
    
    if($ppp)
    {
        $postperPage = $ppp;
    }
    if($category)
    {
        $categoryFilter = array
        (
            array
            (
                'taxonomy'  => 'faqcategory',
                'field'     => 'term_id',       
                'terms'     => $category,               
            )
        );
    }
    $query = new WP_Query( array
    (
        'post_type'         => 'faq',          
        'tax_query'         => $categoryFilter,
        'posts_per_page'    => $postperPage,
        'paged'             => $paged,
        'orderby'           => 'ID',
        'order'             => 'DESC',
    ));
    if ( $query->have_posts() ) 
    {
        $content = '';
        while ( $query->have_posts() ) : $query->the_post();
            $content .= '<div class="accordion-section">';
                $content .= '<a class="accordion-section-title" href="#accordion-'.get_the_ID().'">'.get_the_title().'</a>';
                $content .= '<div id="accordion-'.get_the_ID().'" class="accordion-section-content">'.get_the_content().'</div>';
            $content .= '</div>';
        endwhile;
        echo $content;
        exit;
    }
    echo '0';
    exit;
}

function get_faq( $args )
{
    $categoryFilter = array();
    $postperPage = 1;
    if($args['count'])
    {
        $postperPage = $args['count'];
    }
    if($args['category'])
    {
        $categoryFilter = array
        (
            array
            (
                'taxonomy'  => 'faqcategory',
                'field'     => 'term_id',       
                'terms'     => $args['category'],               
            )
        );
    }
    $query = new WP_Query( array
    (
        'post_type'         => 'faq',          
        'tax_query'         => $categoryFilter,
        'posts_per_page'    => $postperPage,
        'paged'             => 1,
        'orderby'           => 'ID',
        'order'             => 'DESC',
    ));
    if ( $query->have_posts() ) 
    {
        $content = '';
        $content .= '<div class="accordion">';
            while ( $query->have_posts() ) : $query->the_post();
                $content .= '<div class="accordion-section">';
                    $content .= '<a class="accordion-section-title" href="#accordion-'.get_the_ID().'">'.get_the_title().'</a>';
                    $content .= '<div id="accordion-'.get_the_ID().'" class="accordion-section-content">'.get_the_content().'</div>';
                $content .= '</div>';
            endwhile;
        $content .= '</div>';
        $content .= '<a id="more_posts" paged=1 postperpage='.$postperPage.' category = '.$args['category'].'>Load More</a>';    
        echo $content;
    }
    else
    {
        echo 'No FAQ Found.';
    }
    wp_reset_query();
}