<?php

class Data extends DBConnection
{
  public function insertData($title, $location, $country, $salary, $salary_min, $salary_max, $salary_currency, $company_name, $company_link, $import_date, $contact_email, $logo_link, $source_link, $closing_date, $description, $job_source)
  {
    $sql = "INSERT INTO site_import (id, title, location, country, salary, salary_min, salary_max, salary_currency, company_name, company_link, import_date, contact_email, logo_link, source_link, closing_date, description, job_source) VALUES (NULL, '$title', '$location', '$country', '$salary', '$salary_min', '$salary_max', '$salary_currency', '$company_name', '$company_link', '$import_date', '$contact_email', '$logo_link', '$source_link', '$closing_date', '$description', '$job_source')";
    return $this->connect()->query($sql);
  }
}
