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
    public $author; 
    public $company; 
    public $createdAt; 

    public function __construct($title, $short_description, $image, $link, $date, $content, $author = null, $company = null)
    {
        $this->title = $title;
        $this->short_description = $short_description;
        $this->image = $image;
        $this->link = $link;
        $this->date = $date;
        $this->type = 'Artikel';
        $this->content = $content;
        $this->author = $author;
        $this->company = $company;
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

function getAuthor($company){
  $users = get_users();

  foreach ($users as $key => $value) {
    $company_user = get_field('company',  'user_' . $value->ID );
    if($company_user[0]->post_title == $company)
      return $value->ID;
  }

  return null;
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
        case 'nvab': return scrapeNvab(); break;
        case 'vbw': return scrapevbw(); break;
        case 'kndb': return scrapekndb(); break;
        case 'fgz': return scrapefgz(); break;
        case 'cvah': return scrapecvah(); break;
        case 'nbov': return scrapeNbov(); break;
        case 'nuvo': return scrapeNuvo(); break;
        case 'CBD': return scrapeCbd(); break;
        case 'Hoorzaken': return scrapeHoorzaken(); break;
        case 'knvvn': return scrapeHoorzaken(); break;
        case 'Nvtl': return scrapeNvtl(); break;
        case 'Stiba': return scrapeStiba(); break;
        case 'Nfofruit': return scrapeNfofruit(); break;
        case 'Iro': return scrapeIro(); break;
        case 'Lto': return scrapeLto(); break;
        case 'CBM': return scrapeCbm(); break;
        case 'Tuinbranche': return scrapeTuinbranche(); break;
        case 'jagersvereniging': return scrapeJager();break;
        case 'Wapned': return scrapeJager();break;
        case 'Dansbelang': return scrapeDansbelang();break;
        case 'Pictoright': return scrapePictoright();break;
        case 'Ngb': return scrapeNgb();break;
        case 'Griffiers': return scrapeGriffiers();break;
        case 'Nob': return scrapenob();break;
        case 'Bijenhouders': return scrapeBijenhouders();break;
        case 'BBKnet': return scrapeBbknet();break;
        case 'AuteursBond': return scrapeAuteursbond();break;
        case 'ovfd': return scrapeOvfd();break;
        case 'Adfiz': return scrapeAdfiz();break;
        case 'nvvr': return scrapenvvr();break;
        case 'Veneca': return scrapeVeneca();break;
        case 'Sloopaannemers': return scrapeSloopaannemers();break;
        case 'Noa': return scrapeNoa();break;
    }
}

function scrapper($url,$html_tag,$class_selector){
  $html_code='';
    $html_code=file_get_contents($url);
    $dom = new DomDocument();
    libxml_use_internal_errors(true);
    $datas=array();
    if (!empty($html_code))
    {
        $dom->loadHTML($html_code);
        $dom_path=new DOMXPath($dom);
        $query= '//'.$html_tag.'[@class='.$class_selector.']';
        $result=$dom_path->query($query);
        //var_dump($result);
        if (!is_null($result))
            return $result;
    }
    return null;
}

/*
 *@author Bouddha
 *@since 22/08/2022
 **/

function scrapeNvab(){
    $url = 'https://www.nvab.nl';
    $tag='div';
    $selector_class='"newsitem graybg"';
    $selector_class_content='"news-link"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      //$image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"title"')->item(0)->nodeValue;
      $short_description=$node->getElementsByTagName('p')->item(2)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $date=$node->getElementsByTagName('"date"')->item(0)->nodeValue;
      $title=$node->getElementsByTagName('p')->item(0)->nodeValue;
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      
      $result_content=scrapper($link,$tag,$selector_class_content);
      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            if ($key==0)
              continue;
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,null,$link,$date,$content);
      $datas[]=$article;
    }
    var_dump($datas);
    return $datas;
  }

//  scrapeNvab();

function scrapevbw(){
    $url = 'https://vbw.nu';
    $datas=array();
    $tag='div';
    $selector_class='"item agenda-item item-highlighted-slider"';
    $selector_class_content='"news-wrapper"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      //$image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"agenda-title title h4"')->item(0)->nodeValue;
      $short_description=$node->getElementsByTagName('"agenda-description description"')->item(2)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=$node->getElementsByTagName('h4')->item(0)->nodeValue;
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      
      $result_content=scrapper($link,$tag,$selector_class_content);
      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            if ($key==0)
              continue;
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
    }
    if($datas!=null)
      var_dump($datas);
    else
      echo "nothing to see here";
    return $datas;
  }
// scrapevbw();

function scrapefgz(){
  $url = 'https://fgz.nl';
  $tag='div';
  $selector_class='"collection-item-4 w-dyn-item"';
  $selector_class_content='"staticpage__richtext w-richtext"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
    $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=$node->getElementsByTagName('"news_heading-def"')->item(0)->nodeValue;
    $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h4')->item(0)->nodeValue;
    $title=$node->getElementsByTagName('h3')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    
    $result_content=scrapper($url.$link,$tag,$selector_class_content);
    // var_dump($result_content);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
        // var_dump($content);
    }
    $article=new Article($title,$short_description,$image,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
 }
//  scrapefgz(); //too heavy-->Add a filter on date (3 months)

 function scrapekndb(){
  $url = 'https://kndb.org';
    $tag='div';
    $selector_class='"blog-standard clearfix"';
    $selector_class_content='"entry-content"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"entry-title"')->item(0)->nodeValue;
      $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('"byline post-info"')->item(0)->nodeValue;
      $title=$node->getElementsByTagName('h1')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      
      $result_content=scrapper($link,$tag,$selector_class_content);
      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,$image,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }
// scrapekndb();

function scrapecvah(){
  $url = 'https://cvah.nl/over-cvah/werkgeverschap';
    $tag='div';
    $selector_class='"item agenda-item item-highlighted-slider"';
    $selector_class_content='"news-wrapper"';
    $node_articles=scrapper($url."/nieuwsberichten/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"agenda-title title h4"')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=$node->getElementsByTagName('h4')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=$node->getElementsByTagName('h4')->item(0)->nodeValue;
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,$image,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }
// scrapecvah();

function scrapeNbov(){
  $url = 'https://www.nbov.nl';
    $tag='div';
    $selector_class='"row bg-white article"';
    $selector_class_content='"blockitem seq_1 blockItemType-1"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"article-title"')->item(0)->nodeValue;
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('"article-date light-grey"')->item(0)->nodeValue;
      // $title=$node->getElementsByTagName('h1')->item(0)->nodeValue;
      //$link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      
      $result_content=scrapper($link,$tag,$selector_class_content);
      $title = trim(scrapper($link,'h1','"article-responsive-title text-center spacer-bottom-15"')->item(0)->nodeValue);
        if (!is_null($result_content))
        {
          $content=$result_content->item(0)->nodeValue;
          $short_description = trim(substr($content,0,100));
          // var_dump($content);
        }
      $article=new Article($title,$short_description,$image,$link,null,$content);
      $datas[]=$article;
    }
    var_dump($datas);
    return $datas;
  }
// scrapeNbov();

function scrapeNuvo(){
    $url = 'https://www.nuvo.nl/';
    $tag='div';
    $selector_class='"widget-post"';
    $selector_class_content='"l-col-7"';
    $node_articles=scrapper($url."/actueel/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"post-title"')->item(0)->nodeValue;
      $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('"post-meta-entry"')->item(0)->nodeValue;
      $title=$node->getElementsByTagName('h5')->item(0)->nodeValue;
      
      $result_content=scrapper($link,"main",$selector_class_content);
      // var_dump($result_content);
      if (!is_null($result_content))
      {
        // echo "ici";  
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
          $content.="<br>";
        }
        $contenu= explode("<br>",$content);
        $temp= array_shift($contenu);
        $content= implode(" ",$contenu);
      }
      $article=new Article($title,$short_description,$image,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }
// scrapeNuvo();

function scrapeCbd(){
  $url = 'https://drogistensite.nl';
    $tag='div';
    $selector_class='"card-body"';
    $selector_class_content='"col-12 col-lg-8"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      // $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"small"')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=$node->getElementsByTagName('h3')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=$node->getElementsByTagName('"excerpt"')->item(0)->nodeValue;
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeCbd();

function scrapeHoorzaken(){
  $url = 'https://www.hoorzaken.nl';
    $tag='div';
    $selector_class='"block post"';
    $selector_class_content='"entry-content"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      // $title=$node->getElementsByTagName('"small"')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=trim($node->getElementsByTagName('h3')->item(0)->nodeValue);
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,$image,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeHoorzaken();

function scrapeKnvvn(){
  $url = 'https://www.knvvn.nl';
    $tag='div';
    $selector_class='"inside-article"';
    $selector_class_content='"entry-content"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"entry-title"')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,$image,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeKnvvn();

function scrapeNvtl(){
  $url = 'https://nvtl.nl';
    $tag='div';
    $selector_class='"agenda-item"';
    $selector_class_content='"row"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      // $image=$url.scrapper($url."/nieuws",$tag,'"img-responsive"')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"title"')->item(0)->nodeValue;
      $link=scrapper($url."/nieuws/",$tag,'"agenda-item"')->item($key)->getAttribute('data-url') ?? '';
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=trim($node->getElementsByTagName('h3')->item(0)->nodeValue);
      // $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      
      for($i=1;$i<=2;$i++){
        $selector_class_content = '"col-md-6 kolom-'.$i.'"';
        $result_content= scrapper($link,$tag,$selector_class_content);
      
        // var_dump($title);
        if (!is_null($result_content))
        {
            $content="";
            foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
              $content.=$node->nodeValue;
            }
            $short_description = trim(substr($content,0,100));
        }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeNvtl();

function scrapeStiba(){
  $url = 'https://www.stiba.nl/';
    $tag='div';
    $selector_class='"blog-carousel"';
    $selector_class_content='"blog-carousel-desc"';
    $node_articles=scrapper($url."/category/berichten/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      // $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      // $title=$node->getElementsByTagName('"agenda-title title h4"')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=$node->getElementsByTagName('h3')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=$node->getElementsByTagName('"blog-carousel-desc"')->item(0)->nodeValue;
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            if ($key == 0){
              $short_description=$node->nodeValue;
            }else{
              $content.=$node->nodeValue;
            }
          }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }
// scrapeStiba();

function scrapeNfofruit(){
  $url = 'https://www.nfofruit.nl';
    $tag='div';
    $selector_class='"post-module-news"';
    $selector_class_content='"postcontent"';
    $node_articles=scrapper($url."/nieuwsoverzicht/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      // $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"news_title"')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=$node->getElementsByTagName('h3')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=$node->getElementsByTagName('"news_description"')->item(0)->nodeValue;
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            if ($key==0){
              $short_description=$node->nodeValue;
            }  
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }
// scrapeNfofruit();

function scrapeIro(){
  $url = 'https://iro.nl/nl';
    $tag='li';
    $selector_class='"tease tease--news col s12 m4"';
    $selector_class_content='"block--content"';
    $node_articles=scrapper($url."/nieuws-en-pers/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      // $image=$node->getElementsByTagName('" lazyloaded"')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"tease__title"')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=trim($node->getElementsByTagName('h3')->item(0)->nodeValue);
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);
      $result_content=scrapper($link,'section',$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeIro();

function scrapeLto(){
    $url = 'https://www.lto.nl';
    $tag='div';
    $selector_class='"content"';
    $selector_class_content='"WP_content wrap_more"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      // $image=$node->getElementsByTagName('" lazyloaded"')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"title"')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=trim($node->getElementsByTagName('h3')->item(0)->nodeValue);
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeLto();

function scrapeCbm(){
  $url = 'https://www.cbm.nl';
    $tag='div';
    $selector_class='"post-wrap col-xs-12"';
    $selector_class_content='"entry-content"';
    $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node) 
    {
      // $image=$node->getElementsByTagName('" lazyloaded"')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"entry-title h4"')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $title=trim($node->getElementsByTagName('h3')->item(0)->nodeValue);
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);//entry-summary
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeCbm();

function scrapeTuinbranche(){
  $url = 'https://www.tuinbranche.nl';
    $tag='div';
    $selector_class='"news-item col-12 col-md-6 col-lg-4"';
    $selector_class_content='"main-content-block col-12 col-md-8 col-xl-9"';
    $node_articles=scrapper($url."/actueel/alle-artikelen",$tag,$selector_class);
    foreach ($node_articles as $key => $node)
    {
      $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=$node->getElementsByTagName('"title"')->item(0)->nodeValue;
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $short_description=trim(scrapper($link,$tag,$selector_class_content)->item(0)->nodeValue);
      $title=trim($node->getElementsByTagName('h3')->item(0)->nodeValue);
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $short_description=trim(substr($short_description,0,200));
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,$image,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeTuinbranche();

function scrapeJager(){
  $url="https://www.jagersvereniging.nl";
  $tag='article';
  $selector_class='"m-subject-card m-subject-card--small-text"';
  $selector_class_content='"single-article__entry-content entry-content"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=trim(scrapper($url."/nieuws/",'div','"m-subject-card__text e-text"')->item($key)->nodeValue);
    $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,'div',$selector_class_content);
    //var_dump($result_content);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,$image,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapeJager();

function scrapeWapned(){
  $url = 'https://www.wapned.nl';
  $tag='div';
  $selector_class='"col-sm-6 col-xl-4"';
  $selector_class_content='"site-content"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
    // $image=$node->getElementsByTagName('img')->item(1)->getAttribute('src') ?? '';
    $title=$node->getElementsByTagName('"block-title"')->item(0)->nodeValue;
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $title=trim($node->getElementsByTagName('h3')->item(0)->nodeValue);
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);//entry-summary
    $result_content=scrapper($link,'section',$selector_class_content);
    //var_dump($result_content);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,null,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapeWapned();

function scrapeDansbelang(){
  $url = 'https://www.dansbelang.nl';
  $tag='div';
  $selector_class='"x-container max width"';
  $selector_class_content='"entry-content content"';
  $node_articles=scrapper($url."/laatste_nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
    // $image=scrapper($url."/laatste_nieuws/",$tag,'"attachment-entry-fullwidth size-entry-fullwidth wp-post-image"')->item($key)->getAttribute('src') ?? '';
    $title=scrapper($url."/laatste_nieuws/",'header','"entry-title"')->item($key)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);//entry-summary
    $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $result_content=scrapper($link,$tag,$selector_class_content);
    //var_dump($result_content);
    if(strcmp($title,'')!==0){
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      // if(strpos($content, 'Dansbelang')=== 0){
      //   continue;
      // }else{
        $article=new Article($title,$short_description,null,$link,null,$content);
        $datas[]=$article;
      // }
      // var_dump($title);
    }else{
      continue;
    }
  }
  var_dump($datas);
  return $datas;
  }

// scrapeDansbelang();

function scrapePictoright(){
  $url = 'https://pictoright.nl';
  $tag='div';
  $selector_class='"tease tease__news"';
  $selector_class_content='"article__text"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node) 
  {
    // $title=$node.getElementsByTagName('"tease__title"')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $title=trim($node->getElementsByTagName('h3')->item(1)->nodeValue);
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $image=scrapper($link,$tag,'"alignleft size-medium wp-image-4522"')->item(4)->getAttribute('src') ?? '';
    $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);//entry-summary
    $result_content=scrapper($link,$tag,$selector_class_content);
    // var_dump($result_content);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(1)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,null,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapePictoright();

function scrapeNgb(){
  $url="https://www.ngb.nl";
  $tag='article';
  $selector_class='"node node-type--article node-view-mode-teaser article_teaser"';
  $selector_class_content='"text"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=$node->getElementsByTagName('"article_teaser_title"')->item(0)->nodeValue;
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=trim(scrapper($url."/nieuws/",'div','"clearfix text-formatted field field-text-long-summary field-type--text-long field-label--hidden article-teaser__field-text-long-summary field__item"')->item($key)->nodeValue);
    $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,'div',$selector_class_content);
    //var_dump($result_content);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,$image,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapeNgb();

function scrapeGriffiers(){
  $url="https://griffiers.nl";
  $tag="div";
  $selector_class='"node node--type-nieuwsitem node--view-mode-teaser ds-1col clearfix"';
  $selector_class_content='"clearfix text-formatted field field--name-body field--type-text-with-summary field--label-hidden field__item"';
  $node_articles=scrapper($url."/actueel/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node)
    {
      // $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=trim($node->getElementsByTagName('"field field--name-node-title field--type-ds field--label-hidden field__item"')->item(0)->nodeValue);
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);
      $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $short_description=trim(substr($short_description,0,200));
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeGriffiers();

function scrapenob(){
  $url="https://nob.net";
  $tag="div";
  $selector_class='"views-field views-field-title"';
  $selector_class_content='"content"';
  $node_articles=scrapper($url."/actueel",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    // $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=trim($node->getElementsByTagName('span')->item(0)->nodeValue);
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    if(strcmp($link,'/bijeenkomst-nob-vrouwennetwerk-op-woensdag-23-november-2022-thema-leiderschap')!==0){
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $short_description=trim(scrapper($url.$link,$tag,$selector_class_content)->item($key)->nodeValue);
      // $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $short_description=trim(substr($short_description,0,200));
      if(!empty($short_description)){
        $result_content=scrapper($link,$tag,$selector_class_content);
        //var_dump($result_content);
        if (!is_null($result_content))
        {
            $content="";
            foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
              $content.=$node->nodeValue;
            }
        }
        $article=new Article($title,$short_description,null,$link,null,$content);
        $datas[]=$article;
      }else{
        continue;
      }
    }else{
      continue;
    }    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapenob();

function scrapeBijenhouders(){
  $url="https://bijenhouders.nl";
  $tag="div";
  $selector_class='"row news"';
  $selector_class_content='"col-md-9 page-content"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
    foreach ($node_articles as $key => $node)
    {
      // $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
      $title=trim($node->getElementsByTagName('"col-md-12"')->item(0)->nodeValue);
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
      $short_description=trim(scrapper($url."/nieuws/",$tag,'"col-md-9 content"')->item($key)->nodeValue);
      $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
      $link=$url."/".$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      // $image=$url.$node->getElementsByTagName('"col-md-3 news-image"')->item(0)->getAttribute('src') ?? '';
      // $short_description=trim(substr($short_description,0,200));
      $result_content=scrapper($link,$tag,$selector_class_content);

      //var_dump($result_content);
      if (!is_null($result_content))
      {
          $content="";
          foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
            $content.=$node->nodeValue;
          }
      }
      $article=new Article($title,$short_description,null,$link,null,$content);
      $datas[]=$article;
      // var_dump($title);
    }
    var_dump($datas);
    return $datas;
  }

// scrapeBijenhouders();

function scrapeBbknet(){
  $url="https://www.bbknet.nl";
  $tag='div';
  $selector_class='"newsitem"';
  $selector_class_content='"media-newscontent"';
  $node_articles=scrapper($url,$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    // $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=$node->getElementsByTagName('a')->item(0)->nodeValue;
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=trim(scrapper($link,$tag,$selector_class_content)->item(0)->nodeValue);
    // $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,$tag,$selector_class_content);
    //var_dump($result_content);
    // var_dump($link);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,null,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
 }

// scrapeBbknet();

function scrapeAuteursbond(){
  $url="https://auteursbond.nl";
  $tag='div';
  $selector_class='"cell"';
  $selector_class_content='"entry__content"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    if($key==0){continue;}
    // $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    // $title=$node->getElementsByTagName('"h3 card__title"')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
  // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
  $title=trim(scrapper($url."/nieuws/",$tag,'"h3 card__title"')->item($key)->nodeValue);
  $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
  $result_content=scrapper($link,$tag,$selector_class_content);
  //var_dump($result_content);
  // var_dump($link);
  if (!is_null($result_content))
  {
      $content="";
      foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
        $content.=$node->nodeValue;
        $short_description=substr($content,0,200);
      }
  }
  $article=new Article($title,$short_description,null,$link,null,$content);
  $datas[]=$article;
  // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapeAuteursbond();

function scrapeOvfd(){
  $url="https://www.ovfd.nl";
  $tag='article';
  $selector_class='"animated fadeInLeft"';
  $selector_class_content='"large-8 medium-8 columns article"';
  $node_articles=scrapper($url,$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    // $image=$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    // $title=$node->getElementsByTagName('"article_teaser_title"')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
    $title=trim($node->getElementsByTagName('h1')->item(0)->nodeValue);
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,$tag,$selector_class_content);
    //var_dump($result_content);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,null,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapeOvfd();

function scrapeAdfiz(){
  $url="https://www.adfiz.nl";
  $tag='div';
  $selector_class='"news-list-item row"';
  $selector_class_content='"news-single"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    // $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=scrapper($url."/nieuws/",$tag,'"news-title"')->item($key)->nodeValue;
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=trim(scrapper($url."/nieuws/",$tag,'"news-summary"')->item($key)->nodeValue);
    // $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,'article',$selector_class_content);
    //var_dump($result_content);
    // var_dump($link);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,null,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
 }

// scrapeAdfiz();

function scrapenvvr(){
  $url="https://www.nvvr.org";
  $tag='div';
  $selector_class='"wp-block-column"';
  $selector_class_content='"content-area primary"';
  $node_articles=scrapper($url."/actueel/",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    // $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=$node->getElementsByTagName('h3')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);
    // $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,$tag,$selector_class_content);
    //var_dump($result_content);
    // var_dump($link);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,null,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapenvvr();

function scrapeVeneca(){
  $url="https://www.veneca.nl";
  $tag='div';
  $selector_class='"news-item"';
  $selector_class_content='"entry-content"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    // $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=trim($node->getElementsByTagName('p')->item(1)->nodeValue);
    // $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,$tag,$selector_class_content);
    // var_dump($link);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,null,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
 }

// scrapeVeneca();

function scrapeSloopaannemers(){
  $url="https://www.sloopaannemers.nl";
  $tag='div';
  $selector_class='"article width-100 item-blog-list"';
  $selector_class_content='"width-100 article-info"';
  $node_articles=scrapper($url."/themas-actueel/alles/",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    // $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link="https:".$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=trim(scrapper($url."/themas-actueel/alles/",$tag,'"introduction-text"')->item($key)->nodeValue);
    // $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link="https:".$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,$tag,$selector_class_content);
    // var_dump($link);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,null,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapeSloopaannemers();

function scrapeNoa(){
  $url="https://www.noa.nl";
  $tag='div';
  $selector_class='"col-md-4"';
  $selector_class_content='"grid-section"';
  $node_articles=scrapper($url."/nl/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=trim($node->getElementsByTagName('h3')->item(0)->nodeValue);
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=trim(scrapper($link,$tag,$selector_class_content)->item(0)->nodeValue);
    // $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,$tag,$selector_class_content);
    // var_dump($link);
    if (!is_null($result_content))
    {
        $content="";
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,$image,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapeNoa();

function scrapeNvj(){
  $url="https://www.nvj.nl";
  $tag='article';
  $selector_class='"node node-nieuws node-promoted node-teaser viewmode-teaser clearfix"';
  $selector_class_content='"field field-body field-value"';
  $node_articles=scrapper($url."/nieuws/",$tag,$selector_class);
  foreach ($node_articles as $key => $node)
  {
    $image=$url.$node->getElementsByTagName('img')->item(0)->getAttribute('src') ?? '';
    $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    // $date=$node->getElementsByTagName('h6')->item(0)->nodeValue;
    $short_description=trim($node->getElementsByTagName('p')->item(0)->nodeValue);
    // $title=trim($node->getElementsByTagName('h2')->item(0)->nodeValue);
    $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
    $result_content=scrapper($link,'div',$selector_class_content);
    // var_dump($link);
    if (!is_null($result_content))
    {
        $content=""; 
        foreach ($result_content->item(0)->getElementsByTagName('p') as $key => $node) {
          $content.=$node->nodeValue;
        }
    }
    $article=new Article($title,$short_description,$image,$link,null,$content);
    $datas[]=$article;
    // var_dump($title);
  }
  var_dump($datas);
  return $datas;
  }

// scrapeNvj();

#------------------------------------------------------------------------------------------------

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
      //var_dump($image);
      $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
      $short_description=$node->getElementsByTagName('p')->item(0)->nodeValue;
      $link=$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $date=$node->getElementsByTagName('time')->item(0)->nodeValue;
      $title=$node->getElementsByTagName('h2')->item(0)->nodeValue;
      $link=$url.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
      $result_content=scrapper($link,$tag,$selector_class_content);
      if (!is_null($result_content))
      {
        //var_dump($result_content[0]->getElementsByTagName('p') ->item(1)->nodeValue);
        $content=$result_content->item(0)->nodeValue;
        $article = new Article($title,$short_description,$image,$link,$date,$content);
        $datas[]=$article;
        //var_dump($article ->getTitle());
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
  $title_company = 'DeZZP';

  $author = getAuthor($title_company);
  $company = get_field('company', 'user_' . $author)[0]->ID;

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
    foreach ($result_content as $key => $node) 
      $content=$node->nodeValue;
     
    $article = new Article($title,$short_description,null,$link,$date,$content,$author,$company);
    $datas[] = $article;
  }

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
    $datas[] = $article;
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
  $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($article->getImage(), 'Artikel'));
  $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s AND type = %s", array($article->getTitle(), 'Artikel'));

  $result_image = $wpdb->get_results($sql_image);
  $result_title = $wpdb->get_results($sql_title);

  if(!isset($result_image[0]) && !isset($result_title[0]))
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
      'author_id' => $article->author,
      'company_id' =>  $article->company,
      'contributors' => null,
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

