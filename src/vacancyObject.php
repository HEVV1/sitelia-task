<?php

class vacancyObject extends Scrape
{
  protected string $url;

  public string $title;
  public string $location;
  public string $country;
  public string $salary;
  public int $salary_min;
  public int $salary_max;
  public string $salary_currency;
  public string $company_name;
  public string $company_link;
  public string $import_date;
  public string $contact_email;
  public string $logo_link;
  public string $source_link;
  public string $closing_date;
  public string $description;
  public int $job_source;

  public function __construct($parUrl)
  {
    $this->url = $parUrl;
  }

  public function setTitle()
  {
    foreach ($this->dom($this->url)->getElementsByTagName('h1') as $value) {
      if ($value->getAttribute('class') == 'mds-font-trafalgar') {
        $this->title = $value->nodeValue;
      }
    }
  }

  public function setLocation()
  {
    $element = $this->dom($this->url)->getElementsByTagName('dd')[1];
    if ($element->getAttribute('class') == 'mds-list__value') {
      $this->location = $element->nodeValue;
    }
  }

  public function setCountry()
  {
    $this->country = 'Uknown Country';
    $element = $this->dom($this->url)->getElementsByTagName('dd')[1];
    if ($element->getAttribute('class') == 'mds-list__value') {
      $anotherArray =  preg_split('/[\s,]+/', $element->nodeValue);

      foreach ($anotherArray as $value) {
        if ($value == 'England' || $value == 'U.K.' || $value == 'United Kingdom') {
          $this->country = 'England';
        }
      }
    }
  }

  public function setSalary()
  {
    $element = $this->dom($this->url)->getElementsByTagName('dd')[2];
    if ($element->getAttribute('class') == 'mds-list__value') {
      $this->salary = $element->nodeValue;
    }
  }

  public function setSalaryMin()
  {
    $element = $this->dom($this->url)->getElementsByTagName('dd')[2];
    if ($element->getAttribute('class') == 'mds-list__value') {
      $textSalaryMin = $element->nodeValue;
      $textSalaryMin = str_replace([':', '-', ',', '.', '+'], '', $textSalaryMin);
      preg_match_all('/(\d+)/', $textSalaryMin, $matches);

      if (sizeof($matches[0]) == 0) {
        $this->salary_min = 0;
      } else {
        $this->salary_min = min($matches[0]);
      }
    }
  }

  public function setSalaryMax()
  {
    $element = $this->dom($this->url)->getElementsByTagName('dd')[2];
    if ($element->getAttribute('class') == 'mds-list__value') {
      $textSalaryMin = $element->nodeValue;
      $textSalaryMin = str_replace([':', '-', ',', '.', '+'], '', $textSalaryMin);
      preg_match_all('/(\d+)/', $textSalaryMin, $matches);

      if (sizeof($matches[0]) == 0) {
        $this->salary_max = 0;
      } else {
        $this->salary_max = max($matches[0]);
      }
    }
  }

  public function setSalaryCurrency()
  {
    $element = $this->dom($this->url)->getElementsByTagName('dd')[2];
    if ($element->getAttribute('class') == 'mds-list__value') {
      $textSalaryMin = $element->nodeValue;
      if (strpos($textSalaryMin, '£') != '') {
        $this->salary_currency = 'GBP';
      } else {
        $this->salary_currency = 'Unknown currency';
      }
    }
  }

  public function setCompanyName()
  {
    $element = $this->dom($this->url)->getElementsByTagName('dd')[0];
    if ($element->getAttribute('class') == 'mds-list__value') {
      foreach ($element->childNodes as $value) {
        if ($value->nodeName == 'a') {
          $this->company_name = $value->nodeValue;
        }
      }
    }
  }

  public function setCompanyLink()
  {
    $element = $this->dom($this->url)->getElementsByTagName('dd')[0];
    foreach ($element->childNodes as $value) {
      if ($value->nodeName == 'a') {
        if (strlen($value->nodeValue)) {
          $links = $value->getAttribute('href');
          $this->company_link = 'https://jobs.communitycare.co.uk' . preg_replace('/\s+/', '', $links);
        }
      }
    }
  }

  public function setImportDate()
  {
    $original_date = '';
    $timestamp = strtotime($original_date);
    $new_date = date('Y-m-d h:i:s', $timestamp);
    $this->import_date = $new_date;
  }

  public function setEmail()
  {
    $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
    foreach ($this->dom($this->url)->getElementsByTagName('div') as $value) {
      if ($value->getAttribute('class') == 'mds-tabs__panel__content') {
        $email = $value->nodeValue;
        preg_match_all($test_patt, $email, $valid);
        if (sizeof($valid[0]) == 0) {
          $this->contact_email = 'Email is not provided';
        } else {
          foreach ($valid[0] as $val) {
            $this->contact_email = $val;
          }
        }
      }
    }
  }

  public function setLogoLink()
  {
    foreach ($this->dom($this->url)->getElementsByTagName('img') as $value) {
      if ($value->getAttribute('class') == 'logo mds-border mds-width-full') {
        $link = $value->getAttribute('src');
        $this->logo_link = 'https://jobs.communitycare.co.uk' . preg_replace('/\s+/', '', $link);
      }
    }
  }

  public function setSourceLink()
  {
    $this->source_link = $this->url;
  }

  public function setClosingDate()
  {
    $element = $this->dom($this->url)->getElementsByTagName('dd')[3];
    if ($element->getAttribute('class') == 'mds-list__value') {
      $rawDate = $element->nodeValue;
      $original_date = date_parse($rawDate)['year'] . '-' . date_parse($rawDate)['month'] . '-' . date_parse($rawDate)['day'];
      $timestamp = strtotime($original_date);
      $new_date = date('Y-m-d h:i:s', $timestamp);
      $this->closing_date = $new_date;
    }
  }

  public function setDescription()
  {
    foreach ($this->dom($this->url)->getElementsByTagName('div') as $key => $value) {
      if ($value->getAttribute('class') == 'mds-edited-text mds-font-body-copy-bulk') {
        $element = str_replace("'", "\'", $value->nodeValue);
        $this->description = $element;
      }
    }
  }
  public function setJobSource()
  {
    $this->job_source = 17;
  }
}
