<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

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

    // - -- -

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

    $company = array(
        'name'                => _x( 'Companies', 'Companies', 'company' ),
        'singular_name'       => _x( 'Companies', 'Company', 'company' ),
        'menu_name'           => __( 'Companies', 'company' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All companies', 'course' ),
        'view_item'           => __( 'View company', 'view_course' ),
        'add_new_item'        => __( 'New company', 'add_new_course' ),
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
}
add_action( 'init', 'custom_post_type', 0 );


function add_custom_roles(){
    add_role( 'teacher', 'Teacher', get_role( 'subscriber' )->capabilities );
    add_role( 'manager', 'Manager', get_role( 'subscriber' )->capabilities );
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

