<?php





 // detectLanguage("Hallo vrienden");

 function generatorAuthor($key){
    $login = 'user' . random_int(0, 100000);
        $password = "pass" . random_int(0, 100000);
        $email = random_int(0, 100) . $key . "@" . 'livelearn' . ".nl";
        $first_name = explode(' ', $key)[0];
        $last_name = isset(explode(' ', $key)[1]) ? explode(' ', $key)[1] : '';
        $userdata = array(
            'user_pass' => $password,
            'user_login' => $login,
            'user_email' => $email,
            'user_url' => 'https://livelearn.nl/inloggen/',
            'display_name' => $first_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => 'author'
        );
         return  wp_insert_user(wp_slash($userdata));

  }

function addAuthor($users, $key){
    //Artikel + "Opleidingen" + "Masterclass"...XMl 

    //Initialize key by title an slug 
    $key_title = $key;
    $key_slug = $key;
    $company = get_page_by_path($key, OBJECT, 'company');

   
    
  

    //Companny do not exists
    $author_id = 0;
    if(!$company):
        // Creating new company
        $argv = array(
            "post_type" => "company",
            "post_title" => $key,
            "post_status"=> "publish"
        );
        $company_id = wp_insert_post($argv);
        $company = get_post($company_id);
       
        // $company_users = get_field('company', 'user_' . $user->ID);
        $author_id = generatorAuthor($key);
    
        // Associate user with company
        if(!is_wp_error($author_id)) 
           update_field('company', $company, 'user_' . $author_id);
    endif;

    //Companny do exists
    if($company):
      
      
        foreach ($users as $user) :
            $key_title = $company->post_title;
            $key_slug = $company->post_name;    
            $company_users = get_field('company', 'user_' . $user->ID);
            if(isset($company_users)):             
                $company_user = $company_users[0];
                $company_title = strtolower($company_user->post_title);
                if($company_title == strtolower($key_title) || $company_title == strtolower($key_slug)):
                    
                    $author_id = $user->ID;
                    break;
                endif;
            endif;
        endforeach;

        //No author match to this company
        if(!$author_id):
            //[Function] Create new author 
          
            //[End Function]
              $author_id = generatorAuthor($key);
            // Associate user with company
            if (!is_wp_error($author_id)) {
                update_field('company', $company, 'user_' . $author_id);
            }
        endif;
    endif;
  
    //Return
    return ['author' => $author_id, 'company' => $company->ID];
  
  }
  function usersWithCompany($users){
    $usersWithCompany= array();
     foreach ($users as $user) :
            $company_users = get_field('company', 'user_' . $user->ID);
            if(isset($company_users))            
              array_push($usersWithCompany, $user);
        
               
     endforeach;
    return $usersWithCompany;
   
  }

  
  ?>
