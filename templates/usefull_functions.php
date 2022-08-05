<?php


include_once 'simple_html_dom.php';
//header('Content-type: text/plain');

class Article
{
    public $title;
    public $short_description;
    public $image;
    public $link;
    public $date;
    public $type;
    public $content;
    public $createdAt; 

    public function __construct($title, $short_description, $image, $link, $date, $content)
    {
        $this->title = $title;
        $this->short_description = $short_description;
        $this->image = $image;
        $this->link = $link;
        $this->date = $date;
        $this->type = 'Artikel';
        $this->content = $content;
        $this->createdAt = new DateTime();
    }

    public function getTitle(){return $this->title;}
    public function getShortDescription(){return $this->short_description;}
    public function getImage(){return $this->image;}
    public function getLink(){return $this->link;}
    public function getDate(){return $this->date;}
    public function getType(){return $this->type;}
    public function getContent(){return $this->content;}
    public function getCreatedAt(){return $this->createdAt;}

}

function scrapeFrom($website): array
{
    switch ($website){
        case 'smartwp': return scrapeSmartWP(); break;
        case 'DeZZP' : return scrapeDeZZP(); break;
        case 'fmn'   : return scrapeFmn(); break;
        case 'duurzaamgebouwd' : return scrapeDuurzaamGebouwd(); break;
        case 'adformatie': return scrapeAdformatie(); break;
        case 'morethandrinks': return scrapeMorethandrinks(); break;
        case 'sportnext' : return scrapeSportnext(); break;
        case 'nbvt' : return scrapeNbvt(); break;
        case 'vsbnetwerk' : return scrapeVsbnetwerk(); break;
        case 'tvvl' : return scrapeTvvl(); break;
        case 'nedverbak': return scrapeNedverbak(); break;
        case 'tnw' : return scrapeTnw(); break;
        case 'changeINC' : return scrapeChangeINC(); break;
    }
}

function scrapper($url,$html_tag,$class_selector){
    $html_code = file_get_contents($url);
    $dom = new DomDocument();
    libxml_use_internal_errors(true);
    $datas = array();
    if (!empty($html_code))
    {
        $dom->loadHTML($html_code);
        $dom_path =new DOMXPath($dom);
        $query = '//'.$html_tag.'[@class='.$class_selector.']';
        $result = $dom_path->query($query);
        if (!is_null($result))
            return $result;
    }
    return null;
}

function scrapeSmartWP()
{
  $url = 'https://www.smartwp.nl';
  $selector_class='"blog-item"';
  $tag='div';
  $selector_class_content='"text"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
    $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    
    if ($image!='/images/icons/facebook.svg')
    {
        var_dump($image);
        $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
        $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
        $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
        $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
        $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
        $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
        $result_content = scrapper($link,$tag,$selector_class_content);
        if (!is_null($result_content))
        {

        var_dump($result_content[0]->getElementsByTagName('p') ->item(1)->nodeValue);
            $content = $result_content->item(0)->nodeValue;
            $article = new Article($title,$short_description,$image,$link,$date,$content);
            $datas[]=$article;
            // var_dump($article ->getTitle());
        }
    }
  }
    //var_dump($datas);
    return $datas;
}

function scrapeDeZZP(): array{
  $url = 'https://www.dezzp.nl';
  $tag='div';
  $selector_class='"tg-item-inner"';
  $selector_class_content='"x-row-inner"';
  $node_articles=scrapper($url."/zzp-nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
    //$image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
    $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
    $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
    $result_content=scrapper($link,$tag,$selector_class_content);
     if (!is_null($result_content))
     {
      foreach ($result_content as $key => $node) 
      {
        $content=$node->nodeValue;
      }
      // $content="";
      // foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
      //   $content.=$node->nodeValue;
      
      }
        
         
     
     $article=new Article($title,$short_description,null,$link,$date,$content);
    $datas[]=$article;
  }
  var_dump($datas);
  return $datas;
}

function scrapeFmn(): array{
  $url = 'https://www.fmn.nl';
  $tag='div';
  $selector_class='"fmn-news-item-teaser fmn-news-item-teaser--with-image"';
  $selector_class_content='"common-text content rich-text"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
    $image=$node->getElementsByTagName('img')->item(1)->getAttribute('src') ?? '';
    $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
    $short_description=scrapper($url,$tag,'"fmn-news-item-teaser__teaser common-text rich-text"') ->item($key)->nodeValue;
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
    $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    
     $result_content=scrapper($link,$tag,$selector_class_content);
      if (!is_null($result_content))
      {
        $content=$result_content->item(0)->nodeValue;
        var_dump($content);
      }
     $article=new Article($title,$short_description,$image,$link,$date,$content);
    $datas[]=$article;
  }
  //var_dump($datas);
  return $datas;
}

function scrapeDuurzaamGebouwd(): array {
  $url = 'https://www.duurzaamgebouwd.nl';
  $tag='div';
  $selector_class='"body"';
  $selector_class_content='"text mb20"';
  $node_articles=scrapper($url."/artikel",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
    $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
    $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
    //$date=$node->getElementsByTagName('time')->item(0)->nodeValue;
    $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    
     $result_content=scrapper($link,$tag,$selector_class_content);
 
     if (!is_null($result_content))
      {
       $image=$result_content->item(0)->getElementsByTagName('a')->item(0)->getAttribute('href');
       var_dump($image);
       $content="";
       foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node){
        $content.=$node->nodeValue;
       }
      }
     $article=new Article($title,$short_description,$image,$link,null,$content);
    $datas[]=$article;
  }
  var_dump($datas);
  return $datas;
}

// function scrapeMkbServiceDesk(){
//   $url = 'https://www.mkbservicedesk.nl/';
//   $tag='a';
//   $selector_class='"article-card-module--wrapper--2486c"';
//   $selector_class_content='"article-module--article--xM1Vx clearfix"';
//   $node_articles=scrapper($url,$tag,$selector_class);
//   foreach ($node_articles as $key => $node) 
//   {
//     var_dump($image=$node->getElementsByTagName('source'));
//     // $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
//     // $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
//     // $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
//     // //$link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
//     // $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
//     // $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
//     // $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    
//      $result_content=scrapper($link,$tag,$selector_class_content);
//       if (!is_null($result_content))
//       {
//        $content="";
//        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node){
//         $content.=$node->nodeValue;
//        }
//       }
//     // $article=new Article($title,$short_description,$image,$link,$date,$content);
//     //$datas[]=$article;
//   }
//   //var_dump($datas);
// }

function scrapeAdformatie()  {
  $url = 'https://www.adformatie.nl';
  $url_content=
  $tag='li';
  $selector_class='"c-teaser-list__item"';
  $selector_class_content='"c-article-content l-container"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node) {
    $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
    $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
    $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    
     $result_content=scrapper($link,'div',$selector_class_content);
      if (!is_null($result_content))
      {
        $content=$result_content->item(0)->nodeValue;
      }
     $article=new Article($title,$short_description,$image,$link,$date,$content);
    $datas[]=$article;
  }
  var_dump($datas);
  return $datas;
}


function persistArticle($article)
{
  global $wpdb;
  $table = $wpdb->prefix . 'databank'; 
   $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml=".$article->getImage()." AND type= Artikel");
   $result = $wpdb->get_results($sql);
    var_dump($result);    
       if(!empty($result))
       {
          $status = 'extern';
          //Data to create the course
          $data = array(
            'titel' => $article->getTitle(),
            'type' => 'Artikel',
            'videos' => NULL, 
            'short_description' => $article->getShortDescription(),
            'long_description' => $article->getcontent(),
            'duration' => NULL, 
            'prijs' => 0, 
            'prijs_vat' => 0,
            'image_xml' => $article->getImage(), 
            'onderwerpen' => '', 
            'date_multiple' => $article->getDate() ?? NULL, 
            'course_id' => null,
            'author_id' => 0,
            'status' => $status
          );
           $wpdb->insert($table,$data);
           $id_post = $wpdb->insert_id;
           echo $wpdb->last_error;
     }
   }

   function scrapeBouwendNederland(){
    $url = 'https://www.bouwendnederland.nl/actueel/nieuws';
    $tag='div';
    $selector_class='"c-search--result hasExtendedLink"';
    $selector_class_content='"grid-x"';
    $node_articles=scrapper($url,$tag,$selector_class);
    var_dump($node_articles);
    foreach ($node_articles as $key => $node) 
    {
      // $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
       $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
       $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
       $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
       $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      
       $result_content=scrapper($link,$tag,$selector_class_content);
        if (!is_null($result_content))
        {
         $content="";
         foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node){
          $content.=$node->nodeValue;
         }
        }
      // $article=new Article($title,$short_description,$image,$link,$date,$content);
      //$datas[]=$article;
    }
    var_dump($datas);
    return $datas;
   }
 function scrapeMorethandrinks(){
  $url = 'https://www.morethandrinks.nl';
  $tag='div';
  $selector_class='"clearfix gray-bg"';
  $selector_class_content='"article-holder"';
  $node_articles=scrapper($url."/nieuws",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
     $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
     $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
     $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
     $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
     $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
     
    
     $result_content=scrapper($link,$tag,$selector_class_content);
      if (!is_null($result_content))
      {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node){
         $content.=$node->nodeValue;
        }
      }
     $article=new Article($title,$short_description,$image,$link,$date=null,$content);
    $datas[]=$article;
  }
  var_dump($datas);
  return $datas;
 }

 function scrapeSportnext() {
  $url = 'https://www.sportnext.nl';
  $tag='a';
  $selector_class='"article article__card article--related"';
  $selector_class_content='"article__entry"';
  $node_articles=scrapper($url."/artikelen/",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
     $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
     $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
     $short_description=$node->getElementsByTagName('div')->item(2)->nodeValue;
     $link=$node->attributes[1]->value;
    // $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
     $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
     $result_content=scrapper($node->attributes[1]->value,'section',$selector_class_content);
      if (!is_null($result_content))
      {
        $content=$result_content->item(0)->nodeValue;
      }
     $article=new Article($title,$short_description,$image,$link,$date=null,$content);  
     $datas[]=$article;
  }
  var_dump($datas);
  return $datas;
 }

 function scrapeNbvt(){
  $url = 'https://www.nbvt.nl';
  $tag='div';
  $selector_class='"ds-1col node node-nbvt-news view-mode-overview clearfix"';
  $selector_class_content='"field-item even"';
  $node_articles=scrapper($url."/nieuws",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
     //$image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
     $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
     $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
     $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
     $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
     $result_content=scrapper($link,$tag,$selector_class_content);
      if (!is_null($result_content))
      {
        $content=$result_content->item(0)->nodeValue;
      }
     $article=new Article($title,$short_description,$image=null,$link,$date=null,$content);  
     $datas[]=$article;
  }
  var_dump($datas);
  return $datas;
 }
 function scrapeVsbnetwerk(){
  $url = 'https://www.vsbnetwerk.nl';
  $tag='div';
  $selector_class='"loop-item"';
  $selector_class_content='"wysiwyg-content"';
  $node_articles=scrapper($url."/nieuws",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
     $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
     $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
     $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
     $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
     $title=$node->getElementsByTagName('a')->item(1)->nodeValue;
     $result_content=scrapper($link,$tag,$selector_class_content);
      if (!is_null($result_content))
      {
        $content=$result_content->item(0)->nodeValue;
      }
     $article=new Article($title,$short_description,$image,$link,$date=null,$content);  
     $datas[]=$article;
  }
  var_dump($datas);
  return $datas;
 };

 function scrapeComputable(){
  $url = 'https://www.computable.nl';
  $tag='a';
  $selector_class='"articlerow sc-follow"';
  $selector_class_content='"article-main-content"';
  $node_articles=scrapper($url."/artikelen/artikelen/250449/nieuws.html",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
     $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
     $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
     $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
     $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
     $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
     $result_content=scrapper($link,'div',$selector_class_content);
      if (!is_null($result_content))
      {
        $content=$result_content->item(0)->nodeValue;
      }
     $article=new Article($title,$short_description,$image,$link,$date=null,$content);  
     $datas[]=$article;
  }
  var_dump($datas);
  return $datas;
 }

 function scrapeTvvl(){
  $url = 'https://www.tvvl.nl';
  $tag='div';
  $selector_class=['"newslistitem odd first"','"newslistitem even"','"newslistitem odd"','"newslistitem even last"'];
  $selector_class_content='"fullstory"';
  foreach ($selector_class as $key => $class) 
  {
    $node_articles=scrapper($url."/nieuws",$tag,$class);
    if (!is_null($node_articles))
      foreach ($node_articles as $key => $node) 
      {
        //handle the case of image not found in the article 
          //$image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
          $title=$node->getElementsByTagName('a')->item(0)->textContent;
          $short_description=$node->getElementsByTagName('div')->item(1)->nodeValue;
          $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
          $result_content=scrapper($link,$tag,$selector_class_content);
            if (!is_null($result_content))
            {
              $content=$result_content->item(0)->nodeValue;
            }
          $article=new Article($title,$short_description,$image=null,$link,$date=null,$content);  
          $datas[]=$article;
        }
      }
      var_dump($datas);
      return $datas;
    }
  
   function scrapeNedverbak(){
    $url = 'https://www.nedverbak.nl';
    $tag='div';
    $selector_class='"elementor-post__card"';
    $selector_class_content='"fullstory"';
    $node_articles=scrapper($url."/nieuws",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
       $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
       $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
       $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
       $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
       $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
       $result_content=scrapper($link,$tag,$selector_class_content);
        if (!is_null($result_content))
        {
          $content=$result_content->item(0)->nodeValue;
        }
       $article=new Article($title,$short_description,$image,$link,$date=null,$content);  
       $datas[]=$article;
     }
     var_dump($datas);
     return $datas;
   }

   function scrapeTnw(){
    $url = 'https://thenextweb.com';
    $tag='article';
    $selector_class='"c-listArticle"';
    $selector_class_content='"c-richText c-richText--large"';
    $node_articles=scrapper($url."/latest",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
       $image=$node->getElementsByTagName('img')->item(1)->getAttribute('src') ?? '';
       $title=$node->getElementsByTagName('a')->item(2)->getAttribute('data-event-label') ?? '';
       $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
       $result_content=scrapper($link,'div',$selector_class_content);
        if (!is_null($result_content))
        {
          $content=$result_content->item(0)->nodeValue;
        }
        $short_description= mb_substr($content, 0, 100)."...";
       $article=new Article($title,$short_description,$image,$link,$date=null,$content);  
       $datas[]=$article;
     }
     var_dump($datas);
     return $datas;
   }
   
   function scrapeChangeINC() {
    $url = 'https://www.change.inc';
    $tag='div';
    $selector_class='"ArticleCardHorizontalstyles__Wrapper-sc-1n328ji-0 dQYatt"';
    $selector_class_content='"BlockWrapper-sc-5wet9e-0 ddlPhf"';
    $node_articles=scrapper($url."/duurzaam-nieuws",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
       $image=$node->getElementsByTagName('img')->item(0)->getAttribute('data-src') ?? '';
       $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
       $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
       $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
       $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
       $result_content=scrapper($link,'section',$selector_class_content);
        if (!is_null($result_content))
        {
          $content=$result_content->item(0)->nodeValue;
        }
       $article=new Article($title,$short_description,$image,$link,$date=null,$content);  
       $datas[]=$article;
     }
     var_dump($datas);
     return $datas;
   }

   scrapeDeZZP();
   // Can't get image for nedverbak