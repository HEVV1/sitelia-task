<?php
include './src/dbc.php';
include './src/data.php';
include './src/scrape.php';
include './src/extract.php';
include './src/vacancyObject.php';
header("Content-Type: text/plain");

class Main
{
  public array $eachVacancyLinksArray;
  public array $vacObj;
  public function __construct($pageIndex)
  {
    if ($pageIndex <= 1) {
      $scrap = new Extract('https://jobs.communitycare.co.uk/jobs/');
    } else {
      $scrap = new Extract('https://jobs.communitycare.co.uk/jobs/' . $pageIndex . '/');
    }
    $this->eachVacancyLinksArray = $scrap->extractLink('js-clickable-area-link');
  }

  public function startScript()
  {
    for ($i = 0; $i < count($this->eachVacancyLinksArray); $i++) {
      $this->vacObj[$i] = new vacancyObject($this->eachVacancyLinksArray[$i]);
      $this->vacObj[$i]->settitle();
      $this->vacObj[$i]->setLocation();
      $this->vacObj[$i]->setCountry();
      $this->vacObj[$i]->setSalary();
      $this->vacObj[$i]->setSalaryMin();
      $this->vacObj[$i]->setSalaryMax();
      $this->vacObj[$i]->setSalaryCurrency();
      $this->vacObj[$i]->setCompanyName();
      $this->vacObj[$i]->setCompanyLink();
      $this->vacObj[$i]->setImportDate();
      $this->vacObj[$i]->setEmail();
      $this->vacObj[$i]->setLogoLink();
      $this->vacObj[$i]->setSourceLink();
      $this->vacObj[$i]->setClosingDate();
      $this->vacObj[$i]->setDescription();
      $this->vacObj[$i]->setJobSource();
      $this->insertVacancies($i);
    }
  }

  public function insertVacancies($index)
  {
    $data = new Data();
    $data->insertData($this->vacObj[$index]->title, $this->vacObj[$index]->location, $this->vacObj[$index]->country,  $this->vacObj[$index]->salary, $this->vacObj[$index]->salary_min, $this->vacObj[$index]->salary_max, $this->vacObj[$index]->salary_currency, $this->vacObj[$index]->company_name, $this->vacObj[$index]->company_link, $this->vacObj[$index]->import_date, $this->vacObj[$index]->contact_email, $this->vacObj[$index]->logo_link, $this->vacObj[$index]->source_link, $this->vacObj[$index]->closing_date, $this->vacObj[$index]->description, $this->vacObj[$index]->job_source);
  }

  public function showDataProperties()
  {
    print_r($this->vacObj);
  }
}