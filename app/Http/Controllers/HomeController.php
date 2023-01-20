<?php


namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        // so lets start by giving theyse cursed variables a meaningfull names xd

        // connect to the rss
        $connect = curl_init();
        // load the xml data into an array
        curl_setopt_array($connect, array(CURLOPT_URL => 'https://www.commitstrip.com/en/feed/', CURLOPT_RETURNTRANSFER => TRUE));
        // perform cURL session
        $curlSesion = curl_exec($connect);
        // close cURL session
        curl_close($connect);
        // store the xml data into a variable
        $data = simplexml_load_string($curlSesion, 'SimpleXMLElement', LIBXML_NOCDATA);

        // Extract URLs of images from RSS feed
        $channels = $data->channel;
        $numberOfChannels = count($data->channel->item);
    
        $imagePageLinks = array();
        $imagePageLinks2 = array();

        for ($I = 1; $I < $numberOfChannels; $I++) {
            $fopen = $channels->item[$I]->link;;
            ${"imagePageLinks"}[$I] = (string)$fopen[0];
        }

        // dd($imagePageLinks);

        $types = array('jpg', 'JPG', 'GIF', 'gif', 'PNG', '.png');

        foreach ($types as $type) {
            for ($I = 1; $I < count($data->channel->item); $I++) {
                if (!!substr_count((string)$channels->item[$I]->children("content", true), $type) < 0) {
                    ${"imagePageLinks"}[$I] = "";
                }
            }
        }

        $j = "";
        $fopen = @fopen("https://newsapi.org/v2/top-headlines?country=ma&apiKey=7b8966140fe9405bad22f7072d507072", "r");
        // dd($fopen);

        // check if the file is opened
        if (!$fopen) {
            return view('error');
        }

        while ($b = fgets($fopen, 4096)) {
            $j .= $b;
        }

        $jsonArticles = json_decode($j);

        for ($II = $I + 1; $II < count($jsonArticles->articles); $II++) {
            if ($jsonArticles->articles[$II]->urlToImage == "" || empty($jsonArticles->articles[$II]->urlToImage) || strlen($jsonArticles->articles[$II]->urlToImage) == 0) {
                continue;
            }
            $fopen = $jsonArticles->articles[$II]->url;
            ${"imagePageLinks2"}[$II] = $fopen;
        }

        foreach ($imagePageLinks as $k => $v) {
            if (empty($f)) $f = array();
            if ($this->duplicate($imagePageLinks, $imagePageLinks2) == false) $f[$k] = $v;
        }
        foreach ($imagePageLinks2 as $k2 => $v2) {
            if (empty($f)) $f = array();
            if ($this->duplicate($imagePageLinks2, $imagePageLinks) == false) $f[$k2] = $v2;
        }

        $j = 0;
        $images = array();
        while ($j < count($f)) {
                if (isset($f[$j])) {
                    try {
                        $images[] = $this->getImageInPage($f[$j]);
                        // dd($images);
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