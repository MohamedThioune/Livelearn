<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
include "custom-endpoints.php";
function enqueue_parent_styles() {
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style-main.css' );
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
    //wp_enqueue_style( 'inl-style', get_stylesheet_directory_uri().'/inl.css' );
    wp_enqueue_style( 'slick-style', get_stylesheet_directory_uri().'/assets/js/libs/slick/slick.css' );
    wp_enqueue_style( 'slick-theme-style', get_stylesheet_directory_uri().'/assets/js/libs/slick/slick-theme.css' );
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array(), '3.0.0', true );
    wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/assets/js/libs/slick/slick.min.js');
    wp_enqueue_script( 'script', get_stylesheet_directory_uri().'/main.js' );
    if(is_user_logged_in()){
        wp_enqueue_script( 'script-user', get_stylesheet_directory_uri().'/main-user.js' );
    }
    wp_enqueue_script('jquery-ui-widget');
}

function cpt_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Categorie�n', 'course_categories', 'textdomain' ),
        'singular_name'     => _x( 'Categorie', 'Categorie', 'textdomain' ),
        'search_items'      => __( 'Zoek categori�n', 'textdomain' ),
        'all_items'         => __( 'All Cats', 'textdomain' ),
        'parent_item'       => __( 'Parent category', 'textdomain' ),
        'parent_item_colon' => __( 'Parent category:', 'textdomain' ),
        'edit_item'         => __( 'Edit category', 'textdomain' ),
        'update_item'       => __( 'Update category', 'textdomain' ),
        'add_new_item'      => __( 'Add New category', 'textdomain' ),
        'new_item_name'     => __( 'New category Name', 'textdomain' ),
        'menu_name'         => __( 'Category', 'textdomain' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'course_category' ),
    );

    register_taxonomy( 'course_category', array( 'course' ), $args );
}
add_action( 'init', 'cpt_taxonomies', 0 );

function custom_post_type() {

    $course = array(
        'name'                => _x( 'Courses', 'Courses', 'course' ),
        'singular_name'       => _x( 'Course', 'Course', 'course' ),
        'menu_name'           => __( 'Courses', 'course' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All courses', 'course' ),
        'view_item'           => __( 'View course', 'view_course' ),
        'add_new_item'        => __( 'New course', 'add_new_course' ),
        'add_new'             => __( 'New course', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $course_args = array(
        'label'               => __( 'course', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $course,
        'supports'            => array('title', 'editor', 'author', 'custom-fields', 'excerpt', 'thumbnail' ),
        'taxonomies'          => array('course_category'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => '',
        'can_export'          => true,
        'rewrite'             => array('slug' => 'course'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',

    );

    register_post_type( 'course', $course_args );

    $learnpath = array(
        'name'                => _x( 'Leerpaden', 'Leerpaden', 'learnpath' ),
        'singular_name'       => _x( 'Leerpad', 'Leerpad', 'learnpath' ),
        'menu_name'           => __( 'Leerpaden', 'learnpath' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All learning paths', 'learnpath' ),
        'view_item'           => __( 'View learn path', 'view_learnpaths' ),
        'add_new_item'        => __( 'New path', 'add_new_learnpath' ),
        'add_new'             => __( 'New path', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $learnpath_args = array(
        'label'               => __( 'learnpath', 'text_domain' ),
        'description'         => __( 'Post type for learn path', 'text_domain' ),
        'labels'              => $learnpath,
        'supports'            => array('title', 'editor', 'author', 'custom-fields', 'excerpt', 'thumbnail' ),
        //'taxonomies'          => array('category', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => '',
        'can_export'          => true,
        'rewrite'             => array('slug' => 'learnpath'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'learnpath', $learnpath_args );

    //M.A.X B.I.R.D WAS THERE - POST TYPE ~ FEEDBACK ~

    $feedback = array(
        'name'                => _x( 'Feedbacks', 'Feedback', 'feedback' ),
        'singular_name'       => _x( 'Feedback', 'Feedback', 'feedback' ),
        'menu_name'           => __( 'Feedbacks', 'feedback' ),
        'all_items'           => __( 'All feedbacks', 'feedback' ),
        'view_item'           => __( 'View feedback', 'view_feedback' ),
        'add_new_item'        => __( 'New feedback', 'add_new_feedback' ),
        'add_new'             => __( 'New feedback', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $feedback_args = array(
        'label'               => __( 'feedback', 'text_domain' ),
        'description'         => __( 'Post type for feedback', 'text_domain' ),
        'labels'              => $feedback,
        'supports'            => array('title', 'author', 'custom-fields', 'excerpt', 'thumbnail' ),
        //'taxonomies'          => array('category', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => '',
        'can_export'          => true,
        'rewrite'             => array('slug' => 'feedback'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'feedback', $feedback_args );


    $assessment = array(
        'name'                => _x( 'Assessments', 'Assessment', 'assessment' ),
        'singular_name'       => _x( 'Assessment', 'Assessment', 'assessment' ),
        'menu_name'           => __( 'Assessments', 'assessment' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All assessments', 'assessment' ),
        'view_item'           => __( 'View assessment', 'view_assessment' ),
        'add_new_item'        => __( 'New assessment', 'add_new_assessment' ),
        'add_new'             => __( 'New assessment', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $assessment_args = array(
        'label'               => __( 'assessment', 'text_domain' ),
        'description'         => __( 'Post type for assessment', 'text_domain' ),
        'labels'              => $assessment,
        'supports'            => array('title', 'author', 'custom-fields', 'excerpt', 'thumbnail' ),
        //'taxonomies'          => array('category', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => '',
        'can_export'          => true,
        'rewrite'             => array('slug' => 'assessment'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'assessment', $assessment_args );

    // - -- -

    $response_assessment = array(
        'name'                => _x( 'Responses', 'Response', 'response_assessment' ),
        'singular_name'       => _x( 'Response', 'Response', 'response_assessment' ),
        'menu_name'           => __( 'Responses', 'response_assessment' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All responses', 'response' ),
        'view_item'           => __( 'View response', 'view_response' ),
        'add_new_item'        => __( 'New response', 'add_new_response' ),
        'add_new'             => __( 'New response', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $response_args = array(
        'label'               => __( 'response', 'text_domain' ),
        'description'         => __( 'Post type for response', 'text_domain' ),
        'labels'              => $response_assessment,
        'supports'            => array('title', 'author', 'custom-fields', 'excerpt', 'thumbnail' ),
        //'taxonomies'          => array('category', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => '',
        'can_export'          => true,
        'rewrite'             => array('slug' => 'response_assessment'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'response_assessment', $response_args );

    $assign = array(
        'name'                => _x( 'Assigns', 'Assigns', 'assign' ),
        'singular_name'       => _x( 'Assign', 'Assign', 'assign' ),
        'menu_name'           => __( 'Assigns', 'assign' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All assigns', 'assign' ),
        'view_item'           => __( 'View assign', 'view_assign' ),
        'add_new_item'        => __( 'New assign', 'add_new_assign' ),
        'add_new'             => __( 'New assign', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $assign_args = array(
        'label'               => __( 'assign', 'text_domain' ),
        'description'         => __( 'Post type for assign payments', 'text_domain' ),
        'labels'              => $assign,
        'supports'            => array('title', 'editor', 'author', 'custom-fields'),
        //'taxonomies'          => array('category', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 99,
        'menu_icon'           => '',
        'can_export'          => true,
        'rewrite'             => array('slug' => 'assign'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'assign', $assign_args );

    //Views

    $view = array(
        'name'                => _x( 'Views', 'Views', 'view' ),
        'singular_name'       => _x( 'View', 'View', 'view' ),
        'menu_name'           => __( 'Views', 'view' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All views', 'view' ),
        'view_item'           => __( 'Check a view', 'view_view' ),
        'add_new_item'        => __( 'New view', 'add_new_view' ),
        'add_new'             => __( 'New view', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $view_args = array(
        'label'               => __( 'view', 'text_domain' ),
        'description'         => __( 'Post type for view payments', 'text_domain' ),
        'labels'              => $view,
        'supports'            => array('title', 'editor', 'author', 'custom-fields'),
        //'taxonomies'          => array('category', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 99,
        'menu_icon'           => '',
        'can_export'          => true,
        'rewrite'             => array('slug' => 'view'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'view', $view_args );

    //Companies

    $company = array(
        'name'                => _x( 'Companies', 'Companies', 'company' ),
        'singular_name'       => _x( 'Companies', 'Company', 'company' ),
        'menu_name'           => __( 'Companies', 'company' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All companies', 'company' ),
        'view_item'           => __( 'View company', 'view_company' ),
        'add_new_item'        => __( 'New company', 'add_new_company' ),
        'add_new'             => __( 'New company', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $company_args = array(
        'label'               => __( 'company', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $company,
        'supports'            => array('title', 'editor', 'author', 'custom-fields', 'excerpt' ),
        //'taxonomies'          => array('sales-person', 'sales-margin', 'location' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => '',
        'can_export'          => true,
        'rewrite'             => array('slug' => 'company'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'company', $company_args );

    //Communities

    $community = array(
        'name'                => _x( 'Communities', 'Communities', 'community' ),
        'singular_name'       => _x( 'Communities', 'Community', 'community' ),
        'menu_name'           => __( 'Communities', 'community' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All companies', 'community' ),
        'view_item'           => __( 'View community', 'view_community' ),
        'add_new_item'        => __( 'New community', 'add_new_community' ),
        'add_new'             => __( 'New community', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $community_args = array(
        'label'               => __( 'community', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $community,
        'supports'            => array('title', 'editor', 'author', 'custom-fields', 'excerpt'),
        //'taxonomies'          => array('sales-person', 'sales-margin', 'location' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_rest'        => false,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => '',
        'can_export'          => true,
        'rewrite'             => array('slug' => 'community'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );


    register_post_type( 'community', $community_args );

}
add_action( 'init', 'custom_post_type', 0 );


function add_custom_roles(){
    add_role( 'teacher', 'Teacher', get_role( 'subscriber' )->capabilities );
    add_role( 'manager', 'Manager', get_role( 'subscriber' )->capabilities );
    add_role( 'hr', 'HR', get_role( 'subscriber' )->capabilities );
}
add_action('init', 'add_custom_roles');


//redirect 'return to shop'
add_filter( 'woocommerce_return_to_shop_redirect', 'bbloomer_change_return_shop_url' );

function bbloomer_change_return_shop_url() {
    return home_url();
}


add_filter('woocommerce_get_price','reigel_woocommerce_get_price',20,2);
function reigel_woocommerce_get_price($price,$post){
    if ($post->post->post_type === 'course') // change this to your post type
        $price = get_the_field($post->id, 'mush', true); // your price meta key is price
    return $price;
}


add_filter('acf/save_post', 'create_product_for_course', 20);
function create_product_for_course($post_id){
    $product_registrated_id = get_field('connected_product',$post_id);


    $product = wc_get_product( $product_registrated_id );

    if($product){
        //product exist, only update price if nesseccary

        if($product->get_price() != get_field('price', $post_id)){
            //price is different, update
            update_post_meta( $product_registrated_id, '_price', get_field('price', $post_id));
        }
        update_post_meta( $product_registrated_id, '_thumbnail_id', get_field('preview',$post_id)['id'] );


    }else{
        //product does not exist yet, create one
        $post = array(
            'post_author' => get_current_user_id(),
            'post_content' => '',
            'post_status' => 'publish',
            'post_title' => get_the_title($post_id),
            'post_parent' => '',
            'post_type' => 'product',
        );

        $product_id = wp_insert_post( $post );

        //update course data as well
        update_post_meta( $post_id, 'connected_product', $product_id);
        wp_set_object_terms( $product_id, 'simple', 'product_type');
        update_post_meta( $product_id, '_visibility', 'visible' );
        update_post_meta( $product_id, '_thumbnail_id', get_field('preview',$post_id)['id'] );
        //update_post_meta( $product_id, '_stock_status', 'instock');
        //update_post_meta( $product_id, 'total_sales', '0');
        //update_post_meta( $product_id, '_downloadable', 'yes');
        update_post_meta( $product_id, '_virtual', 'yes');
        update_post_meta( $product_id, '_regular_price', get_field('price', $post_id));
        //update_post_meta( $product_id, '_sale_price', "1" );
        //update_post_meta( $product_id, '_purchase_note', "" );
        //update_post_meta( $product_id, '_featured', "no" );
        //update_post_meta( $product_id, '_weight', "" );
        //update_post_meta( $product_id, '_length', "" );
        //update_post_meta( $product_id, '_width', "" );
        //update_post_meta( $product_id, '_height', "" );
        //update_post_meta( $product_id, '_sku', "");
        //update_post_meta( $product_id, '_product_attributes', array());
        //update_post_meta( $product_id, '_sale_price_dates_from', "" );
        //update_post_meta( $product_id, '_sale_price_dates_to', "" );
        update_post_meta( $product_id, '_price', get_field('price',$post_id) );
        //update_post_meta( $product_id, '_sold_individually', "" );
        update_post_meta( $product_id, '_manage_stock', "no" );
        //update_post_meta( $product_id, '_backorders', "no" );
        //update_post_meta( $product_id, '_stock', "" );

    }

}

//no redirect to wp admin
add_filter( 'authenticate', function( $user, $username, $password ) {
    // forcefully capture login failed to forcefully open wp_login_failed action,
    // so that this event can be captured
    if ( empty( $username ) || empty( $password ) ) {
        do_action( 'wp_login_failed', $user );
    }
    return $user;
}, 10, 3 );
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login
function my_front_end_login_fail( $username ) {
    $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
    // if there's a valid referrer, and it's not the default log-in screen
    if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
        wp_redirect( $referrer . '?popup=1&login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
        exit;
    }
}


//change labels/placeholders on woo
function override_default_address_checkout_fields( $fields ) {
    $fields['first_name']['placeholder'] = 'Voornaam';
    $fields['last_name']['placeholder'] = 'Achternaam';
    $fields['company']['placeholder'] = 'Bedrijfsnaam';
    $fields['address_1']['placeholder'] = 'Straatnaam + huisnummer';
    $fields['address_2']['placeholder'] = 'Appartement / kamernummer (optioneel)';
    $fields['city']['placeholder'] = 'Plaats';
    $fields['postcode']['placeholder'] = 'Postcode';
    $fields['country']['placeholder'] = 'Land';
    return $fields;
}
add_filter('woocommerce_default_address_fields', 'override_default_address_checkout_fields');

function override_billing_checkout_fields( $fields ) {
    $fields['billing']['billing_phone']['placeholder'] = 'Telefoonnummer';
    $fields['billing']['billing_email']['placeholder'] = 'E-mailadres';
    return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );


add_action( 'gform_after_submission_1', 'set_assign_data', 10, 2 );
function set_assign_data( $entry, $form ) {

    //getting post
    $post = get_post( $entry['post_id'] );
    $course_id = rgar($entry, '9');
    $payment_id = rgar($entry, '10');
    $datenr = rgar($entry, '11');

    $userdata = array(
        'firstname' => rgar($entry, '2'),
        'insertion' => rgar($entry, '4'),
        'lastname' => rgar($entry, '3'),
        'email' => rgar($entry, '5'),
        'phone' => rgar($entry, '6'),
    );

    $postargs = array(
        'post_title' => 'Assignment for course '. $course_id .' on payment '. $payment_id .' on starting date '. $datenr,
        'post_status' => 'publish',
        'post_type' => 'assign',
        'meta_input' => array(
            'course_id' => $course_id,
            'payment_id' => $payment_id,
            'datenr' => $datenr,
            'userdata' => json_encode($userdata),
        ),
    );

    if(!wp_insert_post($postargs)){
        var_dump('Fatal error. Neem graag contact op met support en meld de volgende code: func.340');
        die();
    }

}

// add_filter( 'rest_authentication_errors', function( $result ) {
//     if ( true === $result || is_wp_error( $result ) ) {
//         return $result;
//     }

//     if ( ! is_user_logged_in() ) {
//         return new WP_Error(
//             'rest_not_logged_in',
//             __( 'You are not currently logged in.' ),
//             array( 'status' => 401 )
//         );
//     }

//     return $result;
// });

function filter_woocommerce_api_product_response( $product_data, $product, $fields, $this_server ) { 
    $product_data['vendor_id'] = get_post_field( 'post_author', $product->id);
    $product_data['vendor_name'] = get_the_author_meta( 'display_name', $product_data['vendor_id']);
        return $product_data; 


};      
add_filter( 'woocommerce_api_product_response', 'filter_woocommerce_api_product_response', 10, 4 ); 

/*
** Endpoints - API
*/
function seperate_tags(){

    $categories = array();
    $datum = array();
    $main = array();
    $topics = array();
    $topics_sub = array();

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    foreach($cats as $category){
        $category->image = get_field('image', 'category_'. $category->cat_ID);
        array_push($main, $category);
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

    $datum['categories'] = $main;

    //Categories
    $bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[1],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $functies = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[0],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[3],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $interesses = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[2],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $topics = array_merge($bangerichts, $functies, $skills, $interesses);

    $datum['topics'] = $topics;

    foreach($topics as $tag){
        $tag->image = get_field('image', 'category_'. $tag->cat_ID);
        //Topics
        $cats = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (!empty($cats))
            foreach($cats as $key => $value){
                $value->image = get_field('image', 'category_'. $value->cat_ID);
                array_push($topics_sub, $value);
            }
    }

    $datum['sub'] = $topics_sub;

    return $datum;

}

function follow_meta( WP_REST_Request $request){
    $user_id = get_current_user_id();
    $informations = array();

    if($request['meta_value'] == null || $request['meta_key'] == null){
        $informations['error'] = 'Please fill the value of the metadata !';
        return $informations;
    }

    $category = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'include' => $request['meta_value'],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    if(!isset($category[0]) && !get_user_by('ID', $request['meta_value'])){
        $informations['error'] = 'Please fill correctly the value of the metadata !';
        return $informations;
    }

    $meta_data = get_user_meta($user_id, $request['meta_key']);
    if(!in_array($request['meta_value'], $meta_data)){
        add_user_meta($user_id, $request['meta_key'], $request['meta_value']);
        $informations['success'] = 'Subscribed successfully !';
    }else{
        delete_user_meta($user_id, $request['meta_key'], $request['meta_value']);
        $informations['success'] = 'Unsubscribed successfully !';
    }

    return $informations;
}

function tracker_course(WP_REST_Request $request){
    $user_visibility = wp_get_current_user();
    $informations = array();

    $course = get_post($request['course_id']);

    if(empty($course))
        return ['error' => 'Please fill the ID correctly !'];

    $user_id = (isset($user_visibility->ID)) ? $user_visibility->ID : 0;
    if(!$user_id)
        return false;

    $args = array(
        'post_type' => 'view', 
        'post_status' => 'publish',
        'author' => $user_id,
    );

    $views_stat_user = get_posts($args);

    if(!empty($views_stat_user))
        $stat_id = $views_stat_user[0]->ID;
    else{
        $data = array(
            'post_type' => 'view',
            'post_author' => $user_id,
            'post_status' => 'publish',
            'post_title' => $user_visibility->display_name . ' - View',
            );
        
        $stat_id = wp_insert_post($data);
    }

    $view = get_field('views', $stat_id);
    
    $one_view = array();
    $one_view['course'] = $course;
    $one_view['date'] = date('d/m/Y H:i:s');

    if(!empty($view))
        array_push($view, $one_view);
    else 
        $view = array($one_view); 
    
    update_field('views', $view, $stat_id);

    return ['success' => 'Tracker course executed successfully !'];

}

function store_comments(WP_REST_Request $request){
    $id = $request['course_id'];
    $stars = $request['stars'];
    $feedback_content =  $request['feedback_content'];

    if(!$id || !$stars || !$feedback_content)
        return ['error' => 'Please fill all data required !'];

    $valuable = [1,2,3,4,5];
    if(!in_array($stars, $valuable))
        return ['error' => 'The stars must be between 1 till 5!'];

    $reviews = get_field('reviews', $id);
    $informations = array();
    $current_user  = get_current_user_id();
    $my_review_bool = false;
    foreach ($reviews as $review)
        if($review['user']->ID == $current_user){
            $my_review_bool = true;
            return ['error' => 'You already comment this course !'];
        }

    $review = array();
    $review['user'] = $current_user;
    $review['user_image'] = get_field('profile_img', 'user_' . $review['user']);
    $review['rating'] = $stars;
    $review['feedback'] = $feedback_content;
    if(!$reviews)
        $reviews = array();
    array_push($reviews,$review);
    update_field('reviews',$reviews, $id);

    $informations['success'] = "Comment sent successfully !";
    $informations['data'] = $review;

    return $informations;
}

function comments_course($data){
    $reviews = get_field('reviews', $data['id']);
    $bunch = array();
    
    foreach($reviews as $review){

        $image = get_field('profile_img',  'user_' .  $review['user']->ID);
        $review['image'] = $image;
        array_push($bunch, $review);
    }

    if(!empty($bunch))
        return $bunch;
    else
        return ['error' => 'No reviews for this course !'];
}

function delete_comments(WP_REST_Request $request){
    $id = $request['course_id'];
    $user_id = $request['user_id'];

    if(!$id || !$user_id)
        return ['error' => 'Please fill all data required !'];

    $course = get_post($id);
    if(empty($course))
        return ['error' => 'No course found !'];
    
    $reviews = get_field('reviews', $id);
    if(empty($reviews))
        return ['error' => 'No reviews for this course !'];

    $deleted = false;
    $bunch = array();
    foreach($reviews as $review){
        if($review['user']->ID == $user_id){
            $deleted = true;
            continue;
        }else
            array_push($bunch,$review);
    }

    update_field('reviews', $bunch, $id);

    if($deleted)
        return ['success' => 'Comment deleted succesfully!'];
    else
        return ['error' => 'Something went wrong !'];

}

function notification_display(){
    $user = wp_get_current_user();

    /*
    * * Feedbacks
    */

    $args = array(
        'post_type' => 'feedback', 
        'author' => $user->ID,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'posts_per_page' => -1,
    );

    $notifications = get_posts($args);
    $todos = array();

    if(!empty($notifications))
        foreach($notifications as $todo){
            $read = get_field('read_feedback', $todo->ID);
            if($read)
                continue;
            array_push($todos,$todo);
        }

    if(!empty($todos))
        return $todos;
    else
        return ['error' => 'No notification you didn\'t see yet !'];
}

function notification($data){

    $feedback = array();

    $value = get_post($data['id']);   
    if(!empty($value)){
        $feedback['type'] = get_field('type_feedback', $value->ID);
        $manager_id = get_field('manager_feedback', $value->ID);
        $feedback['image'] = get_field('profile_img',  'user_' . $manager_id);
        if(!$feedback['image'] )
            $feedback['image']  = get_stylesheet_directory_uri() . '/img/Group216.png';

        $feedback['manager'] = get_user_by('ID', $manager_id);
    
        if($feedback['type'] == "Feedback" || $feedback['type'] == "Compliment" || $feedback['type'] == "Gedeelde cursus")
            $feedback['beschrijving_feedback'] = get_field('beschrijving_feedback', $value->ID);
        else if($feedback['type'] == "Persoonlijk ontwikkelplan")
            $feedback['beschrijving_feedback'] = get_field('opmerkingen', $value->ID);
        else if($feedback['type'] == "Beoordeling Gesprek")
            $feedback['beschrijving_feedback'] = get_field('algemene_beoordeling', $value->ID);

    } 

    return $feedback;
}

function agreement(WP_REST_Request $request){
    global $wpdb;

    $table = $wpdb->prefix . 'agreement_content_artikel'; 

    $website = $request['website'];
    $url = $request['url'];
    $response = $request['response'];

    if(!$website || !$url || empty($response))
        return ['error' => 'Please fill all data required !'];

    //Get agreement
    $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}agreement_content_artikel WHERE url = %s", $url);
    $agreement = $wpdb->get_results( $sql )[0];
    $updated = ['response' => $response];
    $where = [ 'url' => $url ]; // NULL value in WHERE clause.
    $inserted = ['website' => $website, 'url' => $url, 'response' => $response];

    if(!empty($agreement))
        $activated = $wpdb->update( $table, $updated, $where);
    else
        $activated = $wpdb->insert( $table, $inserted);

    if($activated)
        return ['success' => 'Agreement sent successfully !'];
    else
        return ['error' => 'Something went wrong !'];
}

function following(){
    $value = wp_get_current_user();   

    $infos = array();

    //Get Topics
    $topics_external = get_user_meta($value->data->ID, 'topic');
    $topics_internal = get_user_meta($value->data->ID, 'topic_affiliate');
    $topics = array();
    if(!empty($topics_external))
        $topics = $topics_external;

    if(!empty($topics_internal))
        foreach($topics_internal as $item)
            array_push($topics, $item);
          
    if(!empty($topics)){
        $args = array( 
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'include'  => $topics,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            'include' => $topics
        );
        $infos['following_topics'] = get_categories($args);
    }
    
    //Get users
    $users = get_user_meta($value->data->ID, 'expert');

    if(!empty($users)){
        $args = array( 
            'include' => $users,
        );
        $infos['following_users'] = get_users($args);
    }

    if(empty($infos))
        return ['error' => 'Something went wrong !'];
    else
        return $infos;
}

//Callbacks 
add_action( 'rest_api_init', function () {
  register_rest_route( 'custom/v1', '/tags', array(
    'methods' => 'GET',
    'callback' => 'seperate_tags',
  ) );

  register_rest_route( 'custom/v1', '/follow', array(
    'methods' => 'POST',
    'callback' => 'follow_meta',
  ) );

  register_rest_route( 'custom/v1', '/tracker/course', array(
    'methods' => 'POST',
    'callback' => 'tracker_course',
  ) );

  register_rest_route( 'custom/v1', '/recommended/course', array(
    'methods' => 'GET',
    'callback' => 'recommended_course',
  ) );

  register_rest_route( 'custom/v1', '/comment', array(
    'methods' => 'POST',
    'callback' => 'store_comments',
  ) );

  register_rest_route( 'custom/v1', '/comment/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'comments_course',
  ) );

  register_rest_route( 'custom/v1', '/notification', array(
    'methods' => 'GET',
    'callback' => 'notification_display',
  ) );

  register_rest_route( 'custom/v1', '/notification/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'notification',
  ) );

  register_rest_route( 'custom/v1', '/agreement/artikel', array(
    'methods' => 'POST',
    'callback' => 'agreement',
  ) );

  register_rest_route( 'custom/v1', '/comment/delete', array(
    'methods' => 'POST',
    'callback' => 'delete_comments',
  ) );

  register_rest_route( 'custom/v1', '/following', array(
    'methods' => 'GET',
    'callback' => 'following',
  ) );

  register_rest_route('custom/v1', '/all_courses', array(
    'methods' => 'GET',
    'callback' => 'allCourses',
  ));

  register_rest_route('custom/v1', '/authors', array(
    'methods' => 'GET',
    'callback' => 'allAuthors',
  ));

  register_rest_route( 'custom/v1', '/topics/subtopics', array(
    'methods' => 'POST',
    'callback' => 'related_topics_subtopics',
  ));

  register_rest_route( 'custom/v1', '/follow_multiple', array(
    'methods' => 'POST',
    'callback' => 'follow_multiple_meta',
  ));

  register_rest_route('custom/v1', '/expert/(?P<id>\d+)/courses', array(
    'methods' => 'GET',
    'callback' => 'get_expert_courses',
  ));

  register_rest_route('custom/v1', '/expert/(?P<id>\d+)/followers/count', array(
    'methods' => 'GET',
    'callback' => 'get_total_followers',
  ));

  register_rest_route('custom/v1', '/followed/experts', array(
    'methods' => 'GET',
    'callback' => 'get_total_followed_experts',
  ));

  register_rest_route('custom/v1', '/courses/saved', array(
    'methods' => 'GET',
    'callback' => 'get_saved_course',
  ));

  register_rest_route('custom/v1', '/save/course/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'save_course',
  ));

  register_rest_route('custom/v1', '/course/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_course_by_id',
  ));

  register_rest_route('custom/v1', '/liked/courses', array(
    'methods' => 'GET',
    'callback' => 'get_liked_courses',
  ));

  register_rest_route('custom/v1', '/course/(?P<id>\d+)/likes/count', array(
    'methods' => 'GET',
    'callback' => 'get_count_courses_likes',
  ));

  register_rest_route('custom/v1', '/like/course/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'like_course',
  ));

  register_rest_route('custom/v1', '/subtopic/(?P<id>\d+)/courses/', array(
    'methods' => 'GET',
    'callback' => 'get_courses_of_subtopics',
  ));

  register_rest_route('custom/v1', '/filter/courses', array(
    'methods' => 'POST',
    'callback' => 'filter_course',
  ));


  register_rest_route('custom/v1', '/filter/courses/saved', array(
    'methods' => 'GET',
    'callback' => 'filter_saved_courses',
  ));

  register_rest_route('custom/v1', '/company/(?P<community>[-\w]+)', array(
    'methods' => 'GET',
    'callback' => 'community_share',
  ));


});