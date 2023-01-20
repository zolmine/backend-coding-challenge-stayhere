<?php


namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        $c = curl_init();
        curl_setopt_array($c, Array(CURLOPT_URL => 'https://www.commitstrip.com/en/feed/',CURLOPT_RETURNTRANSFER => TRUE));
        $d = curl_exec($c);curl_close($c);
        $x = simplexml_load_string($d, 'SimpleXMLElement', LIBXML_NOCDATA);
        $c=$x->channel;
        $n= count($x->channel->item);
        $ls = array();
        for($I=1; $I<$n;$I++){$h=$c->item[$I]->link;;${"ls"}[$I]=(string)$h[0];}

        $types = array('jpg', 'JPG', 'GIF', 'gif', 'PNG', '.png');

        foreach($types as $type){
            for($I=1; $I<count($x->channel->item);$I++){
                if(!!substr_count((string)$c->item[$I]->children("content", true), $type)<0){${"ls"}[$I] = "";}
            }
        }



        // for($I=1; $I<count($x->channel->item);$I++){
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'jpg')<0){${"ls"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'JPG')<0){${"ls"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'GIF')<0){${"ls"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'gif')<0){${"ls"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'PNG')<0){${"ls"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), '.png')<0){${"ls"}[$I] = "";}
        // }



        $j="";
        $h = @fopen("https://newsapi.org/v2/top-headlines?country=ma&apiKey=7b8966140fe9405bad22f7072d507072", "r");

        // read data from the site "https://newsapi.org/v2/top-headlines?country=ma&apiKey=7b8966140fe9405bad22f7072d507072"
        // $h = @fopen("https://newsapi.org/v2/top-headlines?country=ma&apiKey=7b8966140fe9405bad22f7072d507072", "r");


        while ($b = fgets($h, 4096)) {$j.=$b;}
        $j=json_decode($j);

        dd($j);




        for($II=$I+1; $II<count($j->articles);$II++){
            if($j->articles[$II]->urlToImage=="" || empty($j->articles[$II]->urlToImage) || strlen($j->articles[$II]->urlToImage)==0){continue;}
            $h=$j->articles[$II]->url;
            ${"ls2"}[$II]=$h;
        }

        foreach($ls as $k=>$v){
            if(empty($f))$f=array();
            if($this->duplicate($ls,$ls2)==false) $f[$k]=$v;
        }
        foreach($ls2 as $k2=>$v2){
            if(empty($f))$f=array();
            if($this->duplicate($ls2,$ls)==false) $f[$k2]=$v2;
        }



        $j=0;
        $images=array();
        while($j<count($f)){if(isset($f[$j])) {
            try {$images[] = $this->getimageinpage($f[$j]);} catch (\Exception $e) { /* error */ }
        } $j++;}

        return view('index', [
            'images' => $images
        ]);
    }

    private function getimageinpage($l){
        if(strstr($l, "commitstrip.com"))
        {
            $doc = new \DomDocument();
            @$doc->loadHTMLFile($l);
            $xpath = new \DomXpath($doc);
            $xq = $xpath->query('//img[contains(@class,"size-full")]/@src');
            $src=$xq[0]->value;

            return $src;
        }
        else
        {
            $doc = new \DomDocument();
            @$doc->loadHTMLFile($l);
            $xpath = new \DomXpath($doc);
            $xq = $xpath->query('//img/@src');
            $src=$xq[0]->value;

            return $src;
        }
    }

    private function duplicate($t1, $t2){
        foreach($t1 as $k1=>$v1){
            $duplicate=0;
            foreach($t2 as $v2){if($v2==$v1){$duplicate=1;}}
        }
        return $duplicate;
    }
}