<?php
include_once 'simple_html_dom.php';
class Article
{
    public  $title;
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

function scrapeFrom($website){
    switch ($website){
        case 'smartwp': scrapeSmartWP(); break;
    }
}

function scrapper($url,$class_selector){
    $html_code=file_get_contents($url);
    $dom= new DomDocument();
    libxml_use_internal_errors(true);
    $datas=array();
    if (!empty($html_code))
    {
        $dom->loadHTML($html_code);
        $dom_path=new DOMXPath($dom);
        $query= '//div[@class='.$class_selector.']';
        $result=$dom_path->query($query);
        //var_dump($result);
        if (!is_null($result))
            return $result;
    }
    return null;
}

function scrapeSmartWP()
{
  $url = 'https://www.smartwp.nl/nieuws/';
  $selector_class='"blog-item"';
  $selector_class_content='"text"';
  $node_articles=scrapper($url,$selector_class);
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
        $link='https://www.smartwp.nl'.$node->getElementsByTagName('a')->item(0)->getAttribute('href');
        $result_content=scrapper($link,$selector_class_content);
        if (!is_null($result_content))
        {
            $content=$result_content->item(0)->nodeValue;
            $article=new Article($title,$short_description,$image,$link,$date,$content);
            $datas[]=$article;
            // var_dump($article ->getTitle());
        }
    }
  }
    var_dump(   $datas);
    return $datas;
}
  scrapeSmartWP();

