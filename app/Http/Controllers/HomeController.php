<?php


namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        // connect to the rss
        $c = curl_init();
        // load the xml data into an array
        curl_setopt_array($c, array(CURLOPT_URL => 'https://www.commitstrip.com/en/feed/', CURLOPT_RETURNTRANSFER => TRUE));
        // perform cURL session
        $d = curl_exec($c);
        // close cURL session
        curl_close($c);
        // store the xml data into a variable
        $data = simplexml_load_string($d, 'SimpleXMLElement', LIBXML_NOCDATA);
        $channels = $data->channel;
        $numberOfChannels = count($data->channel->item);

        $imagePageLinks = array();
        for ($I = 1; $I < $numberOfChannels; $I++) {
            $fopen = $channels->item[$I]->link;;
            ${"imagePageLinks"}[$I] = (string)$fopen[0];
        }

        $types = array('jpg', 'JPG', 'GIF', 'gif', 'PNG', '.png');

        foreach ($types as $type) {
            for ($I = 1; $I < count($data->channel->item); $I++) {
                if (!!substr_count((string)$channels->item[$I]->children("content", true), $type) < 0) {
                    ${"imagePageLinks"}[$I] = "";
                }
            }
        }
        // for($I=1; $I<count($x->channel->item);$I++){
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'jpg')<0){${"imageLinks"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'JPG')<0){${"imageLinks"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'GIF')<0){${"imageLinks"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'gif')<0){${"imageLinks"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), 'PNG')<0){${"imageLinks"}[$I] = "";}
        //     if(!!substr_count((string)$c->item[$I]->children("content", true), '.png')<0){${"imageLinks"}[$I] = "";}
        // }



        $j = "";
        $fopen = @fopen("https://newsapi.org/v2/top-headlines?country=ma&apiKey=7b8966140fe9405bad22f7072d507072", "r");

        // read data from the site "https://newsapi.org/v2/top-headlines?country=ma&apiKey=7b8966140fe9405bad22f7072d507072"
        // $h = @fopen("https://newsapi.org/v2/top-headlines?country=ma&apiKey=7b8966140fe9405bad22f7072d507072", "r");

        dd($fopen);
        $b = fgets($fopen, 4096);

        dd($b);

        while ($b = fgets($fopen, 4096)) {
            $j .= $b;
        }
        $jsonArticles = json_decode($j);

        for ($II = $I + 1; $II < count($jsonArticles->articles); $II++) {
            if ($jsonArticles->articles[$II]->urlToImage == "" || empty($jsonArticles->articles[$II]->urlToImage) || strlen($jsonArticles->articles[$II]->urlToImage) == 0) {
                continue;
            }
            $fopen = $jsonArticles->articles[$II]->url;
            ${"ls2"}[$II] = $fopen;
        }

        foreach ($ls as $k => $v) {
            if (empty($f)) $f = array();
            if ($this->duplicate($ls, $ls2) == false) $f[$k] = $v;
        }
        foreach ($ls2 as $k2 => $v2) {
            if (empty($f)) $f = array();
            if ($this->duplicate($ls2, $ls) == false) $f[$k2] = $v2;
        }



        $j = 0;
        $images = array();
        while ($j < count($f)) {
            if (isset($f[$j])) {
                try {
                    $images[] = $this->getimageinpage($f[$j]);
                } catch (\Exception $e) { /* error */
                }
            }
            $j++;
        }

        return view('index', [
            'images' => $images
        ]);
    }

    private function getimageinpage($l)
    {
        if (strstr($l, "commitstrip.com")) {
            $doc = new \DomDocument();
            @$doc->loadHTMLFile($l);
            $xpath = new \DomXpath($doc);
            $xq = $xpath->query('//img[contains(@class,"size-full")]/@src');
            $src = $xq[0]->value;

            return $src;
        } else {
            $doc = new \DomDocument();
            @$doc->loadHTMLFile($l);
            $xpath = new \DomXpath($doc);
            $xq = $xpath->query('//img/@src');
            $src = $xq[0]->value;

            return $src;
        }
    }

    private function duplicate($t1, $t2)
    {
        foreach ($t1 as $k1 => $v1) {
            $duplicate = 0;
            foreach ($t2 as $v2) {
                if ($v2 == $v1) {
                    $duplicate = 1;
                }
            }
        }
        return $duplicate;
    }
}