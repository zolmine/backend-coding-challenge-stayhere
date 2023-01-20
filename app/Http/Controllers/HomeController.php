<?php


namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        // so lets start by giving theyse cursed variables a meaningfull names xd

        $curlInitialVar = curl_init();
        curl_setopt_array($curlInitialVar, Array(CURLOPT_URL => 'https://www.commitstrip.com/en/feed/',CURLOPT_RETURNTRANSFER => TRUE));
        $curlExecution = curl_exec($curlInitialVar);curl_close($curlInitialVar);
        $data = simplexml_load_string($curlExecution, 'SimpleXMLElement', LIBXML_NOCDATA);
        $channels = $data->channel;
        
        $numberOfChannels = count($data->channel->item);
        dd($numberOfChannels);
        $imagePageLinks = array();
        for($I=1; $I<$n;$I++){$h=$curlInitialVar->item[$I]->link;;${"ls"}[$I]=(string)$h[0];}
        for($I=1; $I<count($x->channel->item);$I++){
            if(!!substr_count((string)$curlInitialVar->item[$I]->children("content", true), 'jpg')<0){${"ls"}[$I] = "";}
            if(!!substr_count((string)$curlInitialVar->item[$I]->children("content", true), 'JPG')<0){${"ls"}[$I] = "";}
            if(!!substr_count((string)$curlInitialVar->item[$I]->children("content", true), 'GIF')<0){${"ls"}[$I] = "";}
            if(!!substr_count((string)$curlInitialVar->item[$I]->children("content", true), 'gif')<0){${"ls"}[$I] = "";}
            if(!!substr_count((string)$curlInitialVar->item[$I]->children("content", true), 'PNG')<0){${"ls"}[$I] = "";}
            if(!!substr_count((string)$curlInitialVar->item[$I]->children("content", true), '.png')<0){${"ls"}[$I] = "";}
        }

        $j="";
        $h = @fopen("https://newsapi.org/v2/top-headlines?country=ma&apiKey=7b8966140fe9405bad22f7072d507072", "r");
        while ($b = fgets($h, 4096)) {$j.=$b;}
        $j=json_decode($j);
        for($II=$I+1; $II<count($j->articles);$II++){
            if($j->articles[$II]->urlToImage=="" || empty($j->articles[$II]->urlToImage) || strlen($j->articles[$II]->urlToImage)==0){continue;}
            $h=$j->articles[$II]->url;
            ${"ls2"}[$II]=$h;
        }

        foreach($imagePageLinks as $k=>$v){
            if(empty($f))$f=array();
            if($this->duplicate($imagePageLinks,$ls2)==false) $f[$k]=$v;
        }
        foreach($ls2 as $k2=>$v2){
            if(empty($f))$f=array();
            if($this->duplicate($ls2,$imagePageLinks)==false) $f[$k2]=$v2;
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
