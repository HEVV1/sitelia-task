<?php

class Extract extends Scrape
{
  private string $url;
  public function __construct($parUrl)
  {
    $this->url = $parUrl;
  }

  //Find vacancy links
  public function extractLink($elementClassName)
  {
    $elements_array = array();
    $xpath = new DOMXPath($this->dom($this->url));
    $elements = $xpath->query("//*[contains(@class,'$elementClassName')]");

    foreach ($elements as $value) {
      $links = $value->getAttribute('href');
      array_push($elements_array, 'https://jobs.communitycare.co.uk' . preg_replace('/\s+/', '', $links));
    }

    return $elements_array;
  }
}
