<?php

class Scrape
{
  protected function scrapRequest($parUrl)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $parUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($ch);
    return $html;
  }
  
  protected function dom($parUrl)
  {
    $dom = new DOMDocument();    
    @$dom->loadHTML(file_get_contents($parUrl));
    return $dom;
  }
}
