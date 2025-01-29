<?php

$GLOBALS['id_user'] = get_current_user_id();

require_once __DIR__ . '/liggeey-endpoints.php';
require_once __DIR__ . '/templates/check_visibility.php';
require_once __DIR__ . '/custom-endpoints.php';
require_once __DIR__ . '/article-endpoints.php';
require_once __DIR__ . '/podcast-endpoints.php';
require_once __DIR__ . '/video-endpoints.php';
require_once __DIR__ . '/script-endpoints.php';
require_once __DIR__ . '/dashbord-endpoints.php';
require_once __DIR__ . '/templates/recommendation-module.php';
require_once __DIR__ . '/templates/search-module.php';
require_once __DIR__ . '/templates/new-module-subscribe.php';
// require_once __DIR__ . '/templates/checkout.php';

/** Stripe function */
function create_session_stripe($data){
    $endpoint = "https://api.stripe.com/v1/checkout/sessions";
    $information = makecall($endpoint, 'POST', $data);

    return $information;
}

function session_stripe($price_id, $mode, $post_id = null, $user_id = null, $offline = null, $ui_mode = null){
    $SITE_URL = "https://livelearn.nl";
    $YOUR_DOMAIN = (!$user_id || $user_id == 'null') ? $SITE_URL . '/login' : $SITE_URL . '/user/my-activities';
    $PRICE_ID = ($price_id) ?: null;
    $offline = ($offline) ?: null;
    $ui_mode = ($ui_mode) ? 'hosted': 'embedded';
    $key_return = ($ui_mode == 'hosted') ? 'success_url': 'return_url';

    //Get post information
    $sample = array(
        'ID' => null,
        'name' => null,
        'description' => null,
        'prijs' => null,
        'permalink' => null,
        'image' => null
    );
    $post_data = ($post_id) ? get_post($post_id) : array();
    $standard_text = 'Your adventure begins now with Livelearn !';
    if(!empty($post_data)):
        $course_type = get_field('course_type', $post_data->ID);
        $sample['ID'] = $post_data->ID;
        $sample['name'] = $post_data->post_title;
        $sample['description'] = get_field('short_description', $post_data->ID) ?: $standard_text;
        $sample['prijs'] = get_field('price', $post_data->ID) ?: 0;
        $sample['permalink'] = get_permalink($post_data->ID);
        $thumbnail = "";
        if(!$thumbnail):
            $thumbnail = get_field('url_image_xml', $post_data->ID);
            if(!$thumbnail)
                $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
        endif;
        $sample['image'] = $thumbnail;
    endif;
    $post = (Object)$sample;

    //Except course type [Artikel]

    //Get User information
    $user = get_user_by('ID', $user_id);

    if($mode == 'setup')
        $data = [
            'ui_mode' => $ui_mode,
            'currency' => 'eur',
            'mode' => $mode,
            // 'return_url' => $YOUR_DOMAIN,
            $key_return => $YOUR_DOMAIN . '/?session_id={CHECKOUT_SESSION_ID}',
        ];
    else
        $data = [
            'ui_mode' => $ui_mode,
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => $price_id,
                'quantity' => 1,
            ]],
            'mode' => $mode,
            $key_return => $YOUR_DOMAIN . '/?session_id={CHECKOUT_SESSION_ID}',
            'automatic_tax' => [
                'enabled' => "true",
            ],
            'customer_creation' => 'if_required',
            'metadata' => [
                'userID'  => $user->ID,
                'postID'  => $post->ID,
                'offline' => $offline
            ],
            'shipping_address_collection' => [
                'allowed_countries' => ['US', 'FR', 'NL', 'SN']
            ],
            'custom_fields' => [
                [
                    'key' => 'company_name',
                    'label' => [
                        'type' => 'custom',
                        'custom' => 'Company',
                    ],
                    'optional' => 'true',
                    'type' => 'text',
                ],
                [
                    'key' => 'phone_number',
                    'label' => [
                        'type' => 'custom',
                        'custom' => 'Phone',
                    ],
                    'type' => 'numeric',
                ],
                [
                    'key' => 'additional_information',
                    'label' => [
                        'type' => 'custom',
                        'custom' => 'Additional information',
                    ],
                    'optional' => 'true',
                    'type' => 'text',
                ],
            ],
            'invoice_creation' => [
                'enabled' => "true",
                'invoice_data' => [
                    // 'custom_fields' => [
                    //     'name' => $user->display_name,
                    //     'email' => $user->user_email,
                    // ],
                    'description' => $post->name,
                    'metadata' => [
                        'userID' => $user->ID,
                        'postID' => $post->ID,
                    ],
                ],
            ],
        ];

    //Create session object
    $information = create_session_stripe($data);
    // var_dump($information);

    //case : error primary
    if(isset($information['error']))
        return $information['error'];

    //case : error internal
    if(isset($information['data']->error))
        return $information['data'];

    //case : success - hosted 
    if($ui_mode == 'hosted')
        if($information['data'])
            if($information['data']->url):
                $url = $information['data']->url;
                return array('message' => 'Session successfully created !', 'url' => $url);
            endif;

    $client_secret = null;
    //case : success - embedded
    if($information['data'])
        if($information['data']->client_secret)
            $client_secret = $information['data']->client_secret;

    return json_encode(array('clientSecret' => $client_secret));
}

function retrieve_session($session_id){
    //case : session_id null
    if(!$session_id)
        return 0;

    $endpoint = "https://api.stripe.com/v1/checkout/sessions/" . $session_id;
    $information = makecall($endpoint, 'GET', null);

    return $information;
}

function stripe_status($data){
    //Call retrieve_session
    $session = null;
    $return_session = null;
    $information = retrieve_session($data);

    //case : error primary
    if(isset($information['error']))
        return 0;

    //case : error internal
    if(isset($information['data']->error))
        return 0;

    if($information['data'])
        $session = $information['data'];

    $register_message = '';
    if(!isset($session->metadata['userID']) || $session->metadata['userID'] == "null"):
        //Check if email match record on our database 
        $args = array(
            'search'  => $session->customer_details['email'],
            'search_columns' => array( 'user_login', 'user_email' ),
        );
        $users_search = get_users($args);
        $userSearch = isset($users_search[0]) ? $users_search[0] : null;
        $userID = isset($userSearch->ID) ? $userSearch->ID : null;

        //Use existing email
        if($userID) :
            $session->metadata['userID'] = $userID;
            $register_message = "We find on our records a email already corresponding to email : " . $session->customer_details['email'] . "<br>We have therefore taken the liberty of assigning this command to this user.";
        else :
            //Register this user
            $password = 'L1vele@rn2024';
            $userdata = array(
                'user_pass' => $password,
                'user_login' => $session->customer_details['email'],
                'user_email' => $session->customer_details['email'],
                'user_url' => 'http://livelearn.nl/',
                'display_name' => $session->customer_details['name'],
                'first_name' => $session->customer_details['name'],
                'last_name' => "",
                'role' => 'subscriber'
            );
            $userID = wp_insert_user($userdata);
            if (is_wp_error($userID)):
                $register_message = $userID->get_error_message();
            else:
                $session->metadata['userID'] = $userID;
                $register_message = "Your account has been registered successfully with : <br> email : " . $session->customer_details['email'] . " temporary password : " . $password;
            endif;
        endif;
    endif;

    //case : session status
    try {
        $success = "complete";
        $somethin_wrong = "<small>The payment was applied but communication with Stripe was suddenly interrupted.<br>
        Please contact us at <a href='mailto:contact@livelearn.nl'>contact@livelearn.nl</a></small>";
        $data_order = array(
            'session_id' => $session->id,
            'course_id' => $session->metadata['postID'],
            'status' => $success,
            'prijs' => 'true',
            'auth_id' => $session->metadata['userID'],
            'owner_id' => $session->metadata['userID'],
            'metadata' =>  $session->metadata['offline'],
        );

        //create a order information
        $order_stripe = create_order($data_order);

        if(!$order_stripe)
            echo $somethin_wrong;

        $return_session = ['status' => $session->status, 'customer_email' => $session->customer_details['email'], 'register_message' => $register_message];
        return $return_session;
    } catch (Error $e) {
        $return_session = ['error' => $e->getMessage()];
        return $return_session;
    }
}
//End stripe

function enqueue_parent_styles() {
    wp_enqueue_style( 'bootstrap-s', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' );
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
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

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

    // //Views
    // $view = array(
    //     'name'                => _x( 'Views', 'Views', 'view' ),
    //     'singular_name'       => _x( 'View', 'View', 'view' ),
    //     'menu_name'           => __( 'Views', 'view' ),
    //     //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
    //     'all_items'           => __( 'All views', 'view' ),
    //     'view_item'           => __( 'Check a view', 'view_view' ),
    //     'add_new_item'        => __( 'New view', 'add_new_view' ),
    //     'add_new'             => __( 'New view', 'text_domain' ),
    //     'edit_item'           => __( 'Edit Item', 'text_domain' ),
    //     'update_item'         => __( 'Update Item', 'text_domain' ),
    //     'search_items'        => __( 'Search Item', 'text_domain' ),
    //     'not_found'           => __( 'Not found', 'text_domain' ),
    //     'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    // );

    // $view_args = array(
    //     'label'               => __( 'view', 'text_domain' ),
    //     'description'         => __( 'Post type for view payments', 'text_domain' ),
    //     'labels'              => $view,
    //     'supports'            => array('title', 'editor', 'author', 'custom-fields'),
    //     //'taxonomies'          => array('category', 'post_tag'),
    //     'hierarchical'        => false,
    //     'public'              => true,
    //     'show_ui'             => true,
    //     'show_in_menu'        => true,
    //     'show_in_nav_menus'   => true,
    //     'show_in_admin_bar'   => true,
    //     'menu_position'       => 99,
    //     'menu_icon'           => '',
    //     'can_export'          => true,
    //     'rewrite'             => array('slug' => 'view'),
    //     'has_archive'         => true,
    //     'exclude_from_search' => false,
    //     'publicly_queryable'  => true,
    //     'capability_type'     => 'page',

    // );

    // register_post_type( 'view', $view_args );

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
        'show_in_rest'        => true,
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

    //Progression
    $progression = array(
        'name'                => _x( 'Progressions', 'Progressions', 'progression' ),
        'singular_name'       => _x( 'Progressions', 'Progression', 'progression' ),
        'menu_name'           => __( 'Progressions', 'progression' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All progressions', 'progression' ),
        'view_item'           => __( 'View progression', 'view_progression' ),
        'add_new_item'        => __( 'New progression', 'add_new_progression' ),
        'add_new'             => __( 'New progression', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $progression_args = array(
        'label'               => __( 'progression', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $progression,
        'supports'            => array('title', 'editor', 'author', 'custom-fields', 'excerpt'),
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
        'rewrite'             => array('slug' => 'progression'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'progression', $progression_args );

    //Mandatory
    $mandatory = array(
        'name'                => _x( 'Mandatories', 'Mandatories', 'mandatory' ),
        'singular_name'       => _x( 'Mandatories', 'Mandatory', 'mandatory' ),
        'menu_name'           => __( 'Mandatories', 'mandatory' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All mandatories', 'mandatory' ),
        'view_item'           => __( 'View mandatory', 'view_mandatory' ),
        'add_new_item'        => __( 'New mandatory', 'add_new_mandatory' ),
        'add_new'             => __( 'New mandatory', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $mandatory_args = array(
        'label'               => __( 'mandatory', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $mandatory,
        'supports'            => array('title', 'editor', 'author', 'custom-fields', 'excerpt'),
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
        'rewrite'             => array('slug' => 'mandatory'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'mandatory', $mandatory_args );

    //Badge
    $badge = array(
        'name'                => _x( 'Badges', 'Badges', 'badge' ),
        'singular_name'       => _x( 'Badges', 'Badge', 'badge' ),
        'menu_name'           => __( 'Badges', 'badge' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All badges', 'badge' ),
        'view_item'           => __( 'View badge', 'view_badge' ),
        'add_new_item'        => __( 'New badge', 'add_new_badge' ),
        'add_new'             => __( 'New badge', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $badge_args = array(
        'label'               => __( 'badge', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $badge,
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
        'rewrite'             => array('slug' => 'badge'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'badge', $badge_args );

    //To Do's with
    $todo = array(
        'name'                => _x( 'Todos', 'Todos', 'todo' ),
        'singular_name'       => _x( 'Todos', 'Todo', 'todo' ),
        'menu_name'           => __( 'Todos', 'todo' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All todos', 'todo' ),
        'view_item'           => __( 'View todo', 'view_todo' ),
        'add_new_item'        => __( 'New todo', 'add_new_todo' ),
        'add_new'             => __( 'New todo', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $todo_args = array(
        'label'               => __( 'todo', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $todo,
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
        'rewrite'             => array('slug' => 'todo'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'todo', $todo_args );

    //Jobs with
    $job = array(
        'name'                => _x( 'Jobs', 'Jobs', 'job' ),
        'singular_name'       => _x( 'Jobs', 'Job', 'job' ),
        'menu_name'           => __( 'Jobs', 'job' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All jobs', 'job' ),
        'view_item'           => __( 'View job', 'view_job' ),
        'add_new_item'        => __( 'New job', 'add_new_job' ),
        'add_new'             => __( 'New job', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $job_args = array(
        'label'               => __( 'job', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $job,
        'supports'            => array('title', 'editor', 'author', 'custom-fields', 'excerpt'),
        'taxonomies'          => array('course_category'),
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
        'rewrite'             => array('slug' => 'job'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );

    register_post_type( 'job', $job_args );

    /** Liggeey notifications cpt By Fadel **/
    $notifications = array(
        'name'                => _x( 'Notifications', 'Notifications', 'notification' ),
        'singular_name'       => _x( 'Notifications', 'Notification', 'notification' ),
        'menu_name'           => __( 'Notifications', 'notification' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All notifications', 'notification' ),
        'view_item'           => __( 'View notification', 'view_notification' ),
        'add_new_item'        => __( 'New notification', 'add_new_notification' ),
        'add_new'             => __( 'New notification', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $notification_args = array(
        'label'               => __( 'notification', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $notifications,
        'supports'            => array('title', 'editor', 'author', 'custom-fields', 'excerpt'),
        //'taxonomies'          => array('course_category'),
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
        'rewrite'             => array('slug' => 'notification'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',

    );
    register_post_type( 'notification', $notification_args );

    $challenge = array(
        'name'                => _x( 'Challenges', 'Challenges', 'challenge' ),
        'singular_name'       => _x( 'Challenge', 'Challenge', 'challenge' ),
        'menu_name'           => __( 'Challenges', 'challenge' ),
        //'parent_item_colon'   => __( 'Parent Item:', 'fdfd_issue' ),
        'all_items'           => __( 'All challenges', 'challenge' ),
        'view_item'           => __( 'View challenge', 'view_challenge' ),
        'add_new_item'        => __( 'New challenge', 'add_new_challenge' ),
        'add_new'             => __( 'New challenge', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $challenge_args = array(
        'label'               => __( 'challenge', 'text_domain' ),
        'description'         => __( 'Post type for fdfd issue', 'text_domain' ),
        'labels'              => $challenge,
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
        'rewrite'             => array('slug' => 'challenge'),
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'challenge', $challenge_args );

}
add_action( 'init', 'custom_post_type', 0 );

function add_custom_roles(){
    // add_role( 'teacher', 'Teacher', get_role( 'subscriber' )->capabilities );
    add_role( 'manager', 'Manager', get_role( 'subscriber' )->capabilities );
    add_role( 'hr', 'HR', get_role( 'author' )->capabilities );
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


    //$product = wc_get_product( $product_registrated_id );
    $product = array();

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

add_filter( 'rest_authentication_errors', function( $result ) {
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }

    //    if ( ! is_user_logged_in() ) {
    //        return new WP_Error(
    //            'rest_not_logged_in',
    //            __( 'You are not currently logged in.' ),
    //            array( 'status' => 401 )
    //        );
    //    }
    return $result;
});

function filter_woocommerce_api_product_response( $product_data, $product, $fields, $this_server ) {
    $product_data['vendor_id'] = get_post_field( 'post_author', $product->id);
    $product_data['vendor_name'] = get_the_author_meta( 'display_name', $product_data['vendor_id']);
    return $product_data;
};
add_filter( 'woocommerce_api_product_response', 'filter_woocommerce_api_product_response', 10, 4 );

//Hide product page 
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
//Remove links
add_filter( 'woocommerce_product_is_visible','product_invisible');
function product_invisible(){
    return false;
}

//Remove single page
add_filter( 'woocommerce_register_post_type_product','hide_product_page',12,1);
function hide_product_page($args){
    $args["publicly_queryable"]=false;
    $args["public"]=false;
    return $args;
}

/*
** Endpoints - API
*/
function recommended_course($data)
{
    //The user
    $user = $data['id'];

    $company_visibility = get_field('company',  'user_' . $user);

    if(!empty($company_visibility))
        $visibility_company = $company_visibility[0]->post_title;

    //Recommendation courses
    $infos = recommendation($user, null, 100);   
    $recommended_courses = $infos['recommended'];
    //$teachers = $infos['teachers'];

    $course_id = array();
    $random_id = array();
    if (!empty($recommended_courses)) {
        $current_user_id = $user;
        $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
        //Fix fadel
        //$outcomes_recommended_courses = $recommended_courses;
        $outcomes_recommended_courses = array();
        foreach ($recommended_courses as $key => $course) {
            $course->visibility = get_field('visibility', $course->ID) ?? [];
            $author = get_user_by('ID', $course->post_author);
            $author_company = get_field('company', 'user_' . (int) $author->ID)[0];
            if ($course->visibility != [])
                if ($author_company != $current_user_company)
                    continue;

            $author_img = get_field('profile_img',  'user_' . $author->ID);
            $author_img = $author_img ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
            $course->experts = array();
            $experts = get_field('experts', $course->ID);
            if (!empty($experts))
                foreach ($experts as $key => $expert) {
                    $expert = get_user_by('ID', $expert);
                    $experts_img = get_field('profile_img', 'user_' . $expert->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                    array_push($course->experts, new Expert($expert, $experts_img));
                }
            $course->author = new Expert($author, $author_img);
            $course->longDescription = get_field('long_description', $course->ID);
            $course->shortDescription = get_field('short_description', $course->ID);
            $course->courseType = get_field('course_type', $course->ID);
            $course->pathImage = get_field('url_image_xml', $course->ID);
            $course->price = get_field('price', $course->ID) ?? 0;
            $course->youtubeVideos = get_field('youtube_videos', $course->ID) ? get_field('youtube_videos', $course->ID) : [];

            if (strtolower($course->courseType) == 'podcast')
            {
                $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
                if (!empty($podcasts))
                    $course->podcasts = $podcasts;
                else {
                    $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
                    if (!empty($podcasts))
                    {
                        $course->podcasts = array();
                        foreach ($podcasts as $key => $podcast)
                        {
                            $item= array(
                                "course_podcast_title"=>$podcast['podcast_title'],
                                "course_podcast_intro"=>$podcast['podcast_description'],
                                "course_podcast_url" => $podcast['podcast_url'],
                                "course_podcast_image" => $podcast['podcast_image'],
                            );
                            array_push ($course->podcasts,($item));
                        }
                    }
                }
            }
            $course->podcasts = $course->podcasts ?? [];
            $course->connectedProduct = get_field('connected_product', $course->ID);
            $tags = get_field('categories', $course->ID) ?? [];
            $course->tags = array();
            if ($tags)
                if (!empty($tags))
                    foreach ($tags as $key => $category)
                        if (isset($category['value'])) {
                            $tag = new Tags($category['value'], get_the_category_by_ID($category['value']));
                            array_push($course->tags, $tag);
                        }
            /**
             * Handle Image exception
             */
            $handle = curl_init($course->pathImage);
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

            /* Get the HTML or whatever is linked in $url. */
            $response = curl_exec($handle);

            /* Check for 404 (file not found). */
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            if($httpCode != 200) {
                /* Handle 404 here. */
                $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
            }
            curl_close($handle);


            $new_course = new Course($course);
            if(!in_array($course->ID, $random_id)) {
                array_push($random_id, $course->ID);
                array_push($outcomes_recommended_courses, $new_course);
            }
        }
        return $outcomes_recommended_courses;
    }
    else
        return ["error" => "Nothing to show, don't ask me why 😅 !"];
}

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
    ));

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
    $user_id = $request['id'];
    $id = $request['course_id'];
    $stars = $request['stars'];
    $feedback_content = $request['feedback_content'];

    if(!$id || !$stars || !$feedback_content)
        return ['error' => 'Please fill all data required !'];

    $valuable = [1,2,3,4,5];
    if(!in_array($stars, $valuable))
        return ['error' => 'The stars must be between 1 till 5!'];

    $current_user = ($user_id) ?: get_current_user_id();
    $reviews = get_field('reviews', $id);
    $informations = array();
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

    $review['author'] = get_user_by('ID', $current_user)->display_name;

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

    register_rest_route( 'custom/v1', '/recommended/course/(?P<id>\d+)', array(
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

    register_rest_route('custom/v1', '/articles', array(
        'methods' => 'GET',
        'callback' => 'allArticles',
    ));

    register_rest_route('custom/v2', '/similar/article/category/(?P<category_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_related_articles_by_category',
    ));

    register_rest_route('custom/v2', '/articles', array(
        'methods' => 'GET',
        'callback' => 'allArticlesOptimized',
    ));

    register_rest_route('custom/v1', '/offline/courses', array(
        'methods' => 'GET',
        'callback' => 'getOfflineCourse',
    ));

    register_rest_route('custom/v2', '/offline/courses', array(
        'methods' => 'GET',
        'callback' => 'allOfflineCoursesOptimized',
    ));

    register_rest_route('custom/v1', '/authors', array(
        'methods' => 'GET',
        'callback' => 'allAuthors',
    ));

    register_rest_route('custom/v2', '/authors', array(
        'methods' => 'GET',
        'callback' => 'allAuthorsOptimized',
    ));

    //First apply !
    register_rest_route('custom/v1', '/fill-company', array(
        'methods' => 'GET',
        'callback' => 'fillUpCompany',
    ));

    //Second apply !
    register_rest_route('custom/v1', '/refresh-author', array(
        'methods' => 'GET',
        'callback' => 'refreshAuthor',
    ));

    //Third apply !
    register_rest_route('custom/v1', '/fill-author', array(
        'methods' => 'GET',
        'callback' => 'fillUpAuthor',
    ));

    register_rest_route('custom/v1', '/delete-old-course-databank', array(
        'methods' => 'GET',
        'callback' => 'delete_odl_courses_databank',
    ));

    register_rest_route( 'custom/v1', '/topics/subtopics', array(
        'methods' => 'POST',
        'callback' => 'related_topics_subtopics',
    ));

    register_rest_route( 'custom/v1', '/category/(?P<category_id>\d+)/courses', array(
        'methods' => 'GET',
        'callback' => 'get_related_course_by_category',
    ));

    register_rest_route( 'custom/v1', 'user/recommended/courses', array(
        'methods' => 'GET',
        'callback' => 'course_recommendation_by_follow',
    ));

    register_rest_route ('custom/v1', '/update-image-course/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'update_image_course'
    ));
    register_rest_route ('custom/v1', '/expert/detail/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'detail_expert'
    ));
    register_rest_route ('custom/v1', '/review/user/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'addReveiewUser'
    ));
    register_rest_route ('custom/v1', '/course/(?P<course_id>\d+)/image', array(
        'methods' => 'GET',
        'callback' => 'get_course_image',
    ));

    register_rest_route( 'custom/v1', '/follow_multiple', array(
        'methods' => 'POST',
        'callback' => 'follow_multiple_meta',
    ));

    register_rest_route('custom/v1', '/expert/(?P<id>\d+)/courses', array(
        'methods' => 'GET',
        'callback' => 'get_expert_courses',
    ));

    register_rest_route('custom/v2', '/expert/(?P<id>\d+)/courses', array(
        'methods' => 'GET',
        'callback' => 'getExpertCourseOptimized',
    ));

    register_rest_route('custom/v2', '/topic/(?P<id>\d+)/courses', array(
        'methods' => 'GET',
        'callback' => 'getTopicCoursesOptimized',
    ));

    register_rest_route('custom/v2', '/topic/v2/(?P<id>\d+)/courses', array(
        'methods' => 'GET',
        'callback' => 'getTopicCoursesROptimized',
    ));

    register_rest_route('custom/v2', '/topic/v2/(?P<id>\d+)/(?P<userID>\d+)/courses', array(
        'methods' => 'GET',
        'callback' => 'getTopicCoursesROptimized',
    ));

    register_rest_route('custom/v2', '/user/(?P<user_id>\d+)/statistics', array(
        'methods' => 'GET',
        'callback' => 'timeSpentOnAllCourseType',
    ));

    register_rest_route('custom/v2', '/user/statistics', array(
        'methods' => 'PUT',
        'callback' => 'updateTimeSpentOnCourseType',
    ));

    register_rest_route('custom/v2', '/user/subtopic/statistics', array(
        'methods' => 'GET',
        'callback' => 'getUserSubtopicsStatistics',
    ));

    //(Bis) Statistics topics
    register_rest_route('custom/v1', '/user/subtopic/statistics/(?P<userID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getUserSubtopicsStatistics',
    ));
    //(Bis) Internal
    register_rest_route('custom/v2', '/user/internal/courses/(?P<userID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getUserInternalCourses',
    ));

    register_rest_route('custom/v2', '/user/internal/courses', array(
        'methods' => 'GET',
        'callback' => 'getUserInternalCourses',
    ));

    register_rest_route('custom/v2', '/user/intern/courses', array(
        'methods' => 'GET',
        'callback' => 'optimizeFetchInternalCourses',
    ));

    register_rest_route('custom/v2', '/user/intern/courses', array(
        'methods' => 'POST',
        'callback' => 'createInternalCourses',
    ));



    register_rest_route('custom/v2', '/user/statistics/subtopic/update', array(
        'methods' => 'POST',
        'callback' => 'updateUserSubtopicsStatistics',
    ));

    register_rest_route('custom/v2', '/user/courses/statistics', array(
        'methods' => 'GET',
        'callback' => 'getUserCourseStastics',
    ));

    register_rest_route('custom/v2', '/user/courses/progression/statistics', array(
        'methods' => 'GET',
        'callback' => 'getProgressionStatistics',
    ));

    register_rest_route('custom/v2', '/user/assessments/statistics', array(
        'methods' => 'GET',
        'callback' => 'getUserAttempts',
    ));

    /* Assessment endpoints V3 */

    register_rest_route('custom/v3', '/assessments/add', array(
        'methods' => 'POST',
        'callback' => 'add_assessment_with_questions',
    ));

    register_rest_route('custom/v3', '/assessments/update', array(
        'methods' => 'PUT',
        'callback' => 'update_assessment_with_questions',
    ));


    register_rest_route('custom/v3', '/assessments/archived', array(
        'methods' => 'GET',
        'callback' => 'list_archived_assessments',
    ));

    register_rest_route('custom/v3', '/assessments/(?P<id>\d+)/attempt', array(
        'methods' => 'POST',
        'callback' => 'attempt_assessment',
    ));

    register_rest_route('custom/v3', '/assessment/(?P<assessment_id>\d+)/questions', array(
        'methods' => 'GET',
        'callback' => 'get_assessment_questions',
    ));

    register_rest_route('custom/v3', '/user/(?P<user_id>\d+)/assessments/statistics', array(
        'methods' => 'GET',
        'callback' => 'get_assessment_statistics',
    ));

    register_rest_route('custom/v3', '/user/(?P<user_id>\d+)/successful/assessments', array(
        'methods' => 'GET',
        'callback' => 'get_successful_assessments',
    ));


    register_rest_route('custom/v3', '/assessment/all', array(
        'methods' => 'GET',
        'callback' => 'get_all_assessments_with_question_count',
    ));

    register_rest_route('custom/v3', '/assessment/(?P<assessment_slug>[-\w]+)', array(
        'methods' => 'GET',
        'callback' => 'get_assessment_details',
    ));

    register_rest_route('custom/v3', '/assessments/slug/add', array(
        'methods' => 'GET',
        'callback' => 'add_slug_to_all_assessments',
    ));

    register_rest_route('custom/v3', '/assessment/archive', array(
        'methods' => 'PUT',
        'callback' => 'archive_assessment',
        'permission_callback' => function () {
            return current_user_can('delete_posts'); // Vérifie les permissions pour supprimer
        },
    ));

    register_rest_route('custom/v3', '/assessment/delete', array(
        'methods' => 'DELETE',
        'callback' => 'delete_assessment',
        'permission_callback' => function () {
            return current_user_can('delete_posts'); // Vérifie les permissions pour supprimer
        },
    ));

    /* Assessment endpoints V3 */

    /* Likes endpoints V3 */

    register_rest_route('custom/v3', 'course/(?P<course_id>\d+)/likes/stats/', array(
        'methods' => 'GET',
        'callback' => 'get_course_feedback',
    ));

    register_rest_route('custom/v3', 'user/course/(?P<course_id>\d+)/likes/stats/', array(
        'methods' => 'GET',
        'callback' => 'get_user_course_feedback',
    ));

    register_rest_route('custom/v3', 'course/likes/stats/add', array(
        'methods' => 'POST',
        'callback' => 'create_or_update_like',
    ));

    /* Likes endpoints V3 */

    /* Highlights courses endpoints V3 */

    register_rest_route('custom/v3', '/courses/highlighted', array(
        'methods' => 'GET',
        'callback' => 'get_highlighted_courses',
    ));

    /* Highlights courses endpoints V3 */

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

    register_rest_route('custom/v1', '/sort/courses', array(
        'methods' => 'POST',
        'callback' => 'custom_filter_course',
    ));

    register_rest_route('custom/v1', '/company/(?P<community>[-\w]+)', array(
        'methods' => 'GET',
        'callback' => 'community_share',
    ));

    //(Bis) Assessments
    register_rest_route ('custom/v1', '/assessments/(?P<userID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getAssessments',
    ));

    register_rest_route ('custom/v1', '/assessments', array(
        'methods' => 'GET',
        'callback' => 'getAssessments',
    ));

    register_rest_route ('custom/v1', '/assessment/answer', array(
        'methods' => 'POST',
        'callback' => 'answerAssessment',
    ));

    register_rest_route ('custom/v1', 'user/assessment/(?P<id>\d+)/validate/score', array(
        'methods' => 'GET',
        'callback' => 'getAssessmentValidateScore',
    ));

    register_rest_route ('custom/v1', '/community/add', array(
        'methods' => 'POST',
        'callback' => 'addCommunity',
    ));

    register_rest_route ('custom/v1', '/community/edit', array(
        'methods' => 'POST',
        'callback' => 'editCommunity',
    ));

    register_rest_route ('custom/v1', '/community/personal/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getCommunitiesPersonal',
    ));

    register_rest_route ('custom/v1', '/community/author/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getCommunitiesAuthor',
    ));

    register_rest_route ('custom/v1', '/community/add/courses', array(
        'methods' => 'POST',
        'callback' => 'addCourseCommunity',
    ));

    register_rest_route ('custom/v1', '/community/delete/courses', array(
        'methods' => 'POST',
        'callback' => 'deleteCourseCommunity',
    ));

    //(Bis) Community
    register_rest_route ('custom/v2', '/communities/(?P<userID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getCommunitiesOptimized',
    ));

    register_rest_route ('custom/v2', '/communities', array(
        'methods' => 'GET',
        'callback' => 'getCommunitiesOptimized',
    ));

    register_rest_route ('custom/v1', '/community/detail/(?P<slug>[-\w]+)', array(
        'methods' => 'GET',
        'callback' => 'getCommunityBy',
    ));

    register_rest_route ('custom/v1', '/community/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'getCommunityByID',
    ));

    register_rest_route ('custom/v1', '/join/community/', array(
        'methods' => 'PUT',
        'callback' => 'joinCommunity',
    ));

    register_rest_route ('custom/v1', '/ask/community/', array(
        'methods' => 'PUT',
        'callback' => 'askQuestion',
    ));

    register_rest_route ('custom/v1', '/reply/community/', array(
        'methods' => 'PUT',
        'callback' => 'replyQuestion',
    ));

    register_rest_route ('custom/v1', '/user/view/courses', array(
        'methods' => 'PUT',
        'callback' => 'update_view_course',
    ));

    register_rest_route ('custom/v1', '/user/view/topics', array(
        'methods' => 'GET',
        'callback' => 'update_view_topic',
    ));

    register_rest_route ('custom/v1', '/user/view/save', array(
        'methods' => 'POST',
        'callback' => 'save_user_views',
    ));

    register_rest_route ('custom/v1', '/user/badges', array(
        'methods' => 'GET',
        'callback' => 'get_user_badges',
    ));

    register_rest_route ('custom/v1', '/user/smartphone_token/', array(
        'methods' => 'PUT',
        'callback' => 'update_user_smartphone_token',
    ));

    register_rest_route ('custom/v1', '/user/progression/(?P<course_title>[-\w]+)', array(
        'methods' => 'POST',
        'callback' => 'get_user_course_progression',
    ));

    register_rest_route ('custom/v1', '/user/progression/(?P<course_title>[-\w]+)', array(
        'methods' => 'PUT',
        'callback' => 'update_user_progression_course',
    ));

    register_rest_route ('custom/v2', '/user/progression/', array(
        'methods' => 'POST',
        'callback' => 'getUserProgressionWithLastPosition',
    ));

    register_rest_route ('custom/v2', '/user/progression/', array(
        'methods' => 'PUT',
        'callback' => 'updateUserProgressionWithLastPosition',
    ));

    register_rest_route ('custom/v3', '/user/course/progression', array(
        'methods' => 'GET',
        'callback' => 'get_all_user_progress',
    ));
    register_rest_route ('custom/v3', '/user/course/progression/update', array(
        'methods' => 'PUT',
        'callback' => 'update_user_progress',
    ));

    register_rest_route ('custom/v1', '/user/cart/signups', array(
        'methods' => 'GET',
        'callback' => 'get_user_signups',
    ));
    register_rest_route ('custom/v1', '/user/signup', array(
        'methods' => 'POST',
        'callback' => 'reserve_course',
    ));

    /** Endpoint - Databank */
    register_rest_route ('custom/v1', '/databank/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'Artikel_From_Company'
    ));

    register_rest_route ('custom/v1', '/xml/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'xmlParse'
    ));

    register_rest_route ('custom/v1', '/podcast', array(
        'methods' => 'GET',
        'callback' => 'crontab_podcast'
    ));

    register_rest_route ('custom/v1', '/youtube', array(
        'methods' => 'GET',
        'callback' => 'youtubeEndpoint'
    ));

    register_rest_route ('custom/v1', '/update-youtube', array(
        'methods' => 'GET',
        'callback' => 'updateYoutube'
    ));
    /** Endpoint */

    register_rest_route ('custom/v1', '/matching-topic-course', array(
        'methods' => 'GET',
        'callback' => 'matchin_topics'
    ));

    register_rest_route ('custom/v1', '/matching-child-course', array(
        'methods' => 'GET',
        'callback' => 'matchin_child_topics'
    ));

    register_rest_route ('custom/v1', '/register/company', array(
        'methods' => 'POST',
        'callback' => 'register_company'
    ));

    register_rest_route ('custom/v1', '/clean-video', array(
        'methods' => 'GET',
        'callback' => 'cleanVideoCourse'
    ));

    register_rest_route('custom/v2', '/course/filtered', array(
        'methods' => 'GET',
        'callback' => 'allCoursesOptimizedWithFilter',
    ));

    

    register_rest_route('custom/v3', '/course/filtered', array(
        'methods' => 'GET',
        'callback' => 'allCoursesOptimizedWithJustPreviewAndFilter',
    ));

    

    register_rest_route('custom/v2', '/article/filtered', array(
        'methods' => 'GET',
        'callback' => 'filterArticlesByUserLanguagePreferences',
    ));

    register_rest_route('custom/v3', '/article/filtered', array(
        'methods' => 'GET',
        'callback' => 'filterArticlesByUserLanguagePreferencesWithLikes',
    ));

    register_rest_route('custom/v3', '/last/views', array(
        'methods' => 'GET',
        'callback' => 'getLastViewedPodcastOrVideoListfunction',
    ));

    register_rest_route('custom/v3', '/last/views', array(
        'methods' => 'POST',
        'callback' => 'updateLastViewdPodcastorVideoListfunction',
    ));

    //Weekly mail livelearn
    register_rest_route ('custom/v1', '/weekly-recommendation', array(
        'methods' => 'GET',
        'callback' => 'recommendedWeekly'
    ));

    register_rest_route ('custom/v1', '/update-language-courses', array(
        'methods' => 'GET',
        'callback' => 'updateLangaugeCourses'
    ));

    /** Endpoint - Liggeey */
    register_rest_route ('custom/v1', '/homepage', array(
        'methods' => 'GET',
        'callback' => 'homepage'
    ));

    register_rest_route ('custom/v1', '/category/detail', array(
        'methods' => 'POST',
        'callback' => 'categoryDetail'
    ));

    register_rest_route ('custom/v1', '/candidate/detail', array(
        'methods' => 'POST',
        'callback' => 'candidateDetail',
    ));

    register_rest_route ('custom/v1', '/candidate/IsManagedOrNot', array(
        'methods' => 'POST',
        'callback' => 'IsManagedOrNot',
    ));

    register_rest_route ('custom/v1', '/candidates', array(
        'methods' => 'GET',
        'callback' => 'allCandidates',
    ));

    register_rest_route ('custom/v1', '/artikel/detail', array(
        'methods' => 'POST',
        'callback' => 'artikelDetail'
    ));

    // register_rest_route ('custom/v1', '/post/detail/', array(
    //     'methods' => 'POST',
    //     'callback' => 'postDetail'
    // ));

    register_rest_route ('custom/v1', '/artikel/comment/', array(
        'methods' => 'POST',
        'callback' => 'store_comments'
    ));

    register_rest_route ('custom/v1', '/artikels', array(
        'methods' => 'POST',
        'callback' => 'allArtikels'
    ));

    register_rest_route ('custom/v1', '/company/detail', array(
        'methods' => 'POST',
        'callback' => 'companyDetail'
    ));

    register_rest_route ('custom/v1', '/companies', array(
        'methods' => 'GET',
        'callback' => 'allCompanies'
    ));

    register_rest_route ('custom/v1', '/companies/advanced', array(
        'methods' => 'GET',
        'callback' => 'allCompaniesAdvanced'
    ));

    register_rest_route ('custom/v1', '/jobs', array(
        'methods' => 'GET',
        'callback' => 'allJobs'
    ));

    register_rest_route ('custom/v1', '/job', array(
        'methods' => 'POST',
        'callback' => 'jobDetail'
    ));

    register_rest_route('custom/v2', '/courses', array(
        'methods' => 'GET',
        'callback' => 'allCoursesOptimized',
    ));

    register_rest_route('custom/v2', '/course/search/(?P<keywords>[-\w]+)', array(
        'methods' => 'GET',
        'callback' => 'searchCoursesViaKeyWords',
    ));

    register_rest_route ('custom/v1', '/apply', array(
        'methods' => 'POST',
        'callback' => 'jobUser'
    ));

    register_rest_route ('custom/v1', '/favorites', array(
        'methods' => 'POST',
        'callback' => 'liggeeySave'
    ));

    register_rest_route ('custom/v1', '/user/home', array(
        'methods' => 'POST',
        'callback' => 'HomeUser'
    ));

    register_rest_route ('custom/v1', '/user/jobs', array(
        'methods' => 'POST',
        'callback' => 'JobsUser'
    ));

    register_rest_route ('custom/v1', '/user/applicants', array(
        'methods' => 'POST',
        'callback' => 'ApplicantsUser'
    ));

    register_rest_route ('custom/v1', '/user/favorites', array(
        'methods' => 'POST',
        'callback' => 'FavoritesUser'
    ));

    register_rest_route ('custom/v1', '/user/postJob', array(
        'methods' => 'POST',
        'callback' => 'PostJobUser'
    ));

    register_rest_route ('custom/v1', '/user/editJob', array(
        'methods' => 'POST',
        'callback' => 'EditJobUser'
    ));

    register_rest_route ('custom/v1', '/user/deleteJob', array(
        'methods' => 'POST',
        'callback' => 'DeleteJobUser'
    ));

    register_rest_route ('custom/v1', '/user/comment', array(
        'methods' => 'POST',
        'callback' => 'addComment'
    ));

    register_rest_route ('custom/v1', '/user/profil', array(
        'methods' => 'POST',
        'callback' => 'companyProfil'
    ));

    register_rest_route ('custom/v1', '/user/application', array(
        'methods' => 'POST',
        'callback' => 'jobUserApproval'
    ));

    register_rest_route ('custom/v1', '/user/trash/favourite', array(
        'methods' => 'POST',
        'callback' => 'trashFavouriteCandidate'
    ));

    register_rest_route ('custom/v1', '/user/trash/job', array(
        'methods' => 'POST',
        'callback' => 'trashFavouriteJob'
    ));

    register_rest_route ('custom/v1', '/candidate/home', array(
        'methods' => 'POST',
        'callback' => 'HomeCandidate'
    ));

    register_rest_route ('custom/v1', '/candidate/profil/update', array(
        'methods' => 'POST',
        'callback' => 'updatecandidateProfil'
    ));

    register_rest_route ('custom/v1', '/candidate/applieds', array(
        'methods' => 'POST',
        'callback' => 'candidateAppliedJobs'
    ));

    register_rest_route ('custom/v1', '/candidate/favorites', array(
        'methods' => 'POST',
        'callback' => 'candidateShorlistedJobs'
    ));

    register_rest_route ('custom/v1', '/candidate/skillsPassport', array(
        'methods' => 'POST',
        'callback' => 'candidateSkillsPassport'
    ));

    register_rest_route ('custom/v1', '/candidate/skillsPassport/advanced', array(
        'methods' => 'POST',
        'callback' => 'candidateSkillsPassportAdvanced'
    ));

    register_rest_route ('custom/v1', '/candidate/skillsPassport/statistique/(?P<userID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'detailsPeopleSkillsPassport'
    ));

    register_rest_route ('custom/v1', '/user/profil/update', array(
        'methods' => 'POST',
        'callback' => 'updateCompanyProfil'
    ));

    register_rest_route ('custom/v1', '/company/updateProfil', array(
        'methods' => 'POST',
        'callback' => 'updateCompanyProfil'
    ));

    register_rest_route ('custom/v1', '/candidate/countUserAppliedJobs', array(
        'methods' => 'POST',
        'callback' => 'countUserAppliedJobsAndFavorites'
    ));

    register_rest_route ('custom/v1', '/user/skills', array(
        'methods' => 'POST',
        'callback' => 'add_topics_to_user'
    ));

    register_rest_route ('custom/v1', '/user/skills/internal', array(
        'methods' => 'POST',
        'callback' => 'add_topics_internal_to_user'
    ));

    register_rest_route ('custom/v1', '/candidate/myResume/update', array(
        'methods' => 'POST',
        'callback' => 'candidateMyResumeEdit'
    ));

    register_rest_route ('custom/v1', '/candidate/myResume/add', array(
        'methods' => 'POST',
        'callback' => 'candidateMyResumeAdd'
    ));

    register_rest_route ('custom/v1', '/candidate/myResume/delete', array(
        'methods' => 'POST',
        'callback' => 'candidateMyResumeDelete'
    ));

    register_rest_route ('custom/v1', '/candidate/skills', array(
        'methods' => 'POST',
        'callback' => 'editSkills'
    ));

    //Sub topics all
    register_rest_route ('custom/v1', '/skills/all', array(
        'methods' => 'GET',
        'callback' => 'skillsAll'
    ));
    /** Endpoint */

    // Made By Fadel
    register_rest_route ('custom/v1', '/notification/create', array(
        'methods' => 'POST',
        'callback' => 'sendNotificationBetweenLiggeyActors'
    ));

    register_rest_route ('custom/v1', '/notification/list', array(
        'methods' => 'POST',
        'callback' => 'notifications'
    ));

    //Made by Mohamed | 'Subscription' Payment link
    register_rest_route ('custom/v1', '/payment/link', array(
        'methods' => 'POST',
        'callback' => 'stripe'
    ));

    register_rest_route ('custom/v1', '/search/stripe/(?P<companyID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'search'
    ));

    register_rest_route ('custom/v1', '/search/stripe/invoices/(?P<companyID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'search_invoices'
    ));

    register_rest_route ('custom/v1', '/update/stripe', array(
        'methods' => 'POST',
        'callback' => 'update'
    ));
    //End ...

    //Made by MaxBird
    register_rest_route ('custom/v1', '/user/activity/(?P<ID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'activityUser'
    ));

    //Made by MaxBird | Checkout
    register_rest_route ('custom/v1', '/checkout/stripe/hosted', array(
        'methods' => 'POST',
        'callback' => 'checkoutAPI'
    ));
    register_rest_route ('custom/v1', '/checkout/hosted', array(
        'methods' => 'POST',
        'callback' => 'checkoutFreeAPI'
    ));
    register_rest_route ('custom/v1', '/checkout/orders', array(
        'methods' => 'POST',
        'callback' => 'get_post_orders'
    ));
    register_rest_route ('custom/v1', '/checkout/orders/customers', array(
        'methods' => 'POST',
        'callback' => 'get_customers_by_course'
    ));    

    register_rest_route ('custom/v2', '/checkout/orders', array(
        'methods' => 'POST',
        'callback' => 'get_user_orders'
    ));
    //End ...

    register_rest_route ('custom/v1', '/tofollow/experts', array(
        'methods' => 'GET',
        'callback' => 'expertsToFollow'
    ));

    register_rest_route ('custom/v1', '/upcoming/schedule', array(
        'methods' => 'GET',
        'callback' => 'upcoming_schedule_for_the_user'
    ));

    register_rest_route ('custom/v1', '/teacher/save', array(
        //teacher/save ; /save/manager
        'methods' => 'POST',
        'callback' => 'saveManager'
    ));

    register_rest_route ('custom/v1', '/notifications/(?P<ID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_notifications'
    ));

    register_rest_route ('custom/v1', '/company/people/(?P<ID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'companyPeople'
    ));
    register_rest_route ('custom/v1', '/company/people/managers/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'peopleYouManage'
    ));
    register_rest_route ('custom/v1', '/company/people/update/(?P<ID>\d+)', array(
        'methods' => 'POST',
        'callback' => 'editPeopleCompany'
    ));
    register_rest_route ('custom/v1', '/company/people/remove/(?P<ID>\d+)', array(
        'methods' => 'POST',
        'callback' => 'removePeopleCompany'
    ));

    register_rest_route ('custom/v1', '/learnModules/(?P<ID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'learn_modules'
    ));

    register_rest_route ('custom/v1', '/learnDatabase/(?P<ID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'learnning_database'
    ));

    register_rest_route ('custom/v1', '/details-notification/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_detail_notification'
    ));

    register_rest_route ('custom/v1', '/statistic/company/(?P<ID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'statistic_company'
    ));
    register_rest_route ('custom/v1', '/statistic/individual/(?P<ID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'statistic_individual'
    ));
    register_rest_route ('custom/v1', '/statistic/team/(?P<ID>\d+)', array(
        'methods' => 'GET',
        'callback' => 'statistic_team'
    ));
    register_rest_route ('custom/v1', '/employes/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_emploees'
    ));
    register_rest_route ('custom/v1', '/departements/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_departements'
    ));
    register_rest_route ('custom/v1', '/addDepartement/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'add_departement'
    ));
    register_rest_route ('custom/v1', '/removeDepartement/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'remove_departement'
    ));
    register_rest_route ('custom/v1', '/SelecteerExperts/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'Selecteer_experts'
    ));
    register_rest_route ('custom/v1', '/granted/role/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'grantPushRole'
    ));
    register_rest_route ('custom/v1', '/peopleManaged/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'people_managed'
    ));
    register_rest_route ('custom/v1', '/addPeopleToManaged/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'add_people_to_manage'
    ));
    register_rest_route ('custom/v1', '/unManagedPerson/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'unManagePeople'
    ));

    register_rest_route ('custom/v1', '/addOnePersone/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'addOnePeople'
    ));
    register_rest_route ('custom/v1', '/addManyPersone/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'addManyPeople'
    ));
    register_rest_route ('custom/v1', '/teacher/new-course/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'newCoursesByTeacher'
    ));
    register_rest_route ('custom/v1', '/teacher/update-course/(?P<id_course>\d+)', array(
        'methods' => 'POST',
        'callback' => 'updateCoursesByTeacher'
    ));
    register_rest_route ('custom/v1', '/delete-course/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'deleteCourse'
    ));
    register_rest_route ('custom/v1', '/search-course', array(
        'methods' => 'GET',
        'callback' => 'search_courses'
    ));
    register_rest_route ('custom/v1', '/courses/recommended/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'coursesRecommendedUpcomming'
    ));
    register_rest_route ('custom/v1', '/posts/(?P<company>[-\w]+)', array(
        'methods' => 'GET',
        'callback' => 'artikelDezzp'
    ));
    register_rest_route ('custom/v1', '/posts/category/(?P<category>\d+)', array(
        'methods' => 'GET',
        'callback' => 'artikelByCategory'
    ));
    register_rest_route ('custom/v1', 'subscription/organisation', array(
        'methods' => 'POST',
        'callback' => 'subscription_organisation'
    ));
    register_rest_route ('custom/v1', '/achievement/add/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'addAchievement'
    ));
    register_rest_route ('custom/v1', '/feedback/add/(?P<id>\d+)', array( //need to be connected
        'methods' => 'POST',
        'callback' => 'addFeedback'
    ));
    register_rest_route ('custom/v1', '/external-internal-courses/(?P<id>\d+)', array( //need to be connected
        'methods' => 'GET',
        'callback' => 'getExterInterCourses'
    ));
    register_rest_route ('custom/v1', '/todo/add/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'addTodo'
    ));
    register_rest_route ('custom/v1', '/homepage/angular', array(
        'methods' => 'GET',
        'callback' => 'HomepageAngular'
    ));
    register_rest_route ('custom/v1', '/courses/all', array(
        'methods' => 'GET',
        'callback' => 'all_courses_in_plateform'
    ));
    register_rest_route ('custom/v1', '/courses/content', array(
        'methods' => 'GET',
        'callback' => 'all_courses_content'
    ));
    register_rest_route ('custom/v1', '/courses/data', array(
        'methods' => 'GET',
        'callback' => 'all_courses_data'
    ));
    register_rest_route ('custom/v1', '/companies/all', array(
        'methods' => 'GET',
        'callback' => 'all_company_in_plateform'
    ));

    register_rest_route ('custom/v1', '/company-detail/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'detail_company'
    ));

    register_rest_route ('custom/v1', '/challenges', array(
        'methods' => 'GET',
        'callback' => 'challenges'
    ));

    register_rest_route ('custom/v1', '/challenge', array(
        'methods' => 'POST',
        'callback' => 'challengeDetail'
    ));

    register_rest_route ('custom/v1', '/challenge/start', array(
        'methods' => 'POST',
        'callback' => 'startChallenge'
    ));
    register_rest_route ('custom/v1', '/migration-episodes-video-on-json', array(
        'methods' => 'GET',
        'callback' => 'migration_episodes_video'
    ));
     register_rest_route ('custom/v1', '/migration-episodes-podcast-on-json', array(
        'methods' => 'GET',
        'callback' => 'migration_episodes_podcast'
    ));
    register_rest_route ('custom/v1', '/update-on-podcastindex', array(
        'methods' => 'GET',
        'callback' => 'update_podcast_on_podcastindex'
    ));
    register_rest_route ('custom/v1', 'loket/code', array(
        'methods' => 'POST',
        'callback' => 'get_code_loket'
    ));
    register_rest_route ('custom/v1', 'polaris/employees', array(
        'methods' => 'POST',
        'callback' => 'get_employees_polaris'
    ));
   register_rest_route ('custom/v1', 'episodes/video', array(
        'methods' => 'GET',
        'callback' => 'get_video_episode'
    ));
    register_rest_route ('custom/v1', 'episodes/podcast', array(
        'methods' => 'GET',
        'callback' => 'get_podcast_episode'
    ));
    register_rest_route ('custom/v1', 'course/link/categories', array(
        'methods' => 'GET',
        'callback' => 'link_the_categories_courses'
    ));

    register_rest_route ('custom/v1', 'push/notifications/send', array(
        'methods' => 'POST',
        'callback' => 'sendPushNotificationFirebase'
    ));

    /**
     * User orders
     */

     register_rest_route ('custom/v3', 'user/orders/', array(
        'methods' => 'GET',
        'callback' => 'get_user_orders_list'
    ));

    register_rest_route ('custom/v3', 'user/order/check', array(
        'methods' => 'POST',
        'callback' => 'is_course_purchased_by_user'
    ));

    /**
     * User orders
     */

     

});
