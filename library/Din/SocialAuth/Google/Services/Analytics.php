<?php

namespace Din\SocialAuth\Google\Services;

use Din\SocialAuth\Google\Auth;
use Google_Service_Analytics;

class Analytics {

  private $_analytics;
  private $_property;
  private $_uri;
  private $_start_date;
  private $_end_date;

  public function __construct(Auth $auth)
  {
    $this->_analytics = new Google_Service_Analytics($auth->getClient());

  }

  /**
   * [Identifies the account on google analytcs]
   * @param [String] $property [Google Analytics -> Domain -> Views -> Views Config]
   */
  public function setProperty($property)
  {
    $this->_property = $property;

  }

  /**
   * [URI that will be searched]
   * @param [String] $uri [/content/name-of-page/]
   */
  public function setUri($uri)
  {
    $this->_uri = $uri;

  }

  /**
   * [Start date of the survey]
   * @param [String] $date [YYYY-MM-DD]
   */
  public function setStartDate($date)
  {
    $this->_start_date = $date;

  }

  /**
   * [End date of the survey]
   * @param [String] $date [YYYY-MM-DD]
   */
  public function setEndDate($date)
  {
    $this->end_date = $date;

  }

  /**
   * [Returns the number of visits in a URI based 
   * on the start date and end date]
   * @return [int] [Number of visits to the URI]
   */
  public function getVisits()
  {

    $OBJresult = $this->_analytics->data_ga->get(
      'ga:'.$this->_property,
      $this->_start_date,
      $this->end_date,
      'ga:visits',
      array(
        'filters' => 'ga:pagePath=~'. $this->_uri . '*',
        'dimensions' => 'ga:pagePath',
        'metrics' => 'ga:pageviews',
        'sort' => '-ga:pageviews',
      )
    );

    $rows = $OBJresult->getRows();

    $vitits = 0;
    if (count($rows)) {
      foreach($rows as $ga_row) {
        $vitits += $ga_row[1];
      }
    }

    return $vitits;

  }

}