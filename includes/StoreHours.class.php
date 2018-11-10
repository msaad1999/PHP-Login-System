<?php

/**
 * ----------------------------------
 * PHP STORE HOURS
 * ----------------------------------
 * Version 3.1
 * Written by Cory Etzkorn
 * https://github.com/coryetzkorn/php-store-hours
 *
 * DO NOT MODIFY THIS CLASS FILE
 */
class StoreHours
{
  /**
   *
   * @var array
   */
  private $hours;
  
  /**
   *
   * @var array
   */
  private $exceptions;
  
  /**
   *
   * @var array
   */
  private $config;
  
  /**
   *
   * @var boolean
   */
  private $yesterdayFlag;
  
  /**
   *
   * @param array $hours
   * @param array $exceptions
   * @param array $config
   */
  public function __construct($hours = array(), $exceptions = array(), $config = array())
  {

    $this->exceptions    = $exceptions;
    $this->config        = $config;
    $this->yesterdayFlag = false;
    
    $weekdayToIndex = array(
      'mon' => 1,
      'tue' => 2,
      'wed' => 3,
      'thu' => 4,
      'fri' => 5,
      'sat' => 6,
      'sun' => 7
    );
    
    $this->hours = array();
    
    foreach ($hours as $key => $value) {
      $this->hours[$weekdayToIndex[$key]] = $value;
    }
    
    // Remove empty elements from values (backwards compatibility)
    foreach ($this->hours as $key => $value) {
      $this->hours[$key] = array_filter($value, function($element)
      {
        return (trim($element) !== '');
      });
    }
    
    // Remove empty elements from values (backwards compatibility)
    foreach ($this->exceptions as $key => $value) {
      $this->exceptions[$key] = array_filter($value, function($element)
      {
        return (trim($element) !== '');
      });
    }
    
    $defaultConfig = array(
      'separator' => ' - ',
      'join' => ' and ',
      'format' => 'g:ia',
      'overview_weekdays' => array(
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat',
        'Sun'
      )
    );
    
    $this->config += $defaultConfig;
    
  }
  
  /**
   *
   * @param string $timestamp
   * @return boolean
   */
  private function is_open_at($timestamp = null)
  {

    $timestamp = (null !== $timestamp) ? $timestamp : time();
    $is_open             = false;

    $this->yesterdayFlag = false;

    // Check whether shop's still open from day before
    $ts_yesterday    = strtotime(date('Y-m-d H:i:s', $timestamp) . ' -1 day');
    $yesterday       = date('Y-m-d', $ts_yesterday);
    $hours_yesterday = $this->hours_today_array($ts_yesterday);

    foreach ($hours_yesterday as $range) {
      $range = explode('-', $range);
      $start = strtotime($yesterday . ' ' . $range[0]);
      $end   = strtotime($yesterday . ' ' . $range[1]);
      if ($end <= $start) {
        $end = strtotime($yesterday . ' ' . $range[1] . ' +1 day');
      }
      if ($start <= $timestamp && $timestamp <= $end) {
        $is_open             = true;
        $this->yesterdayFlag = true;
        break;
      }
    }

    // Check today's hours
    if (!$is_open) {

      $day               = date('Y-m-d', $timestamp);
      $hours_today_array = $this->hours_today_array($timestamp);

      foreach ($hours_today_array as $range) {
        $range = explode('-', $range);
        $start = strtotime($day . ' ' . $range[0]);
        $end   = strtotime($day . ' ' . $range[1]);
        if ($end <= $start) {
          $end = strtotime($day . ' ' . $range[1] . ' +1 day');
        }
        if ($start <= $timestamp && $timestamp <= $end) {
          $is_open = true;
          break;
        }
      }

    }

    return $is_open;

  }
  
  /**
   *
   * @param array $ranges
   * @return string
   */
  private function format_hours(array $ranges)
  {

    $hoursparts = array();

    foreach ($ranges as $range) {
      $day = '2016-01-01';
      
      $range = explode('-', $range);
      $start = strtotime($day . ' ' . $range[0]);
      $end   = strtotime($day . ' ' . $range[1]);
      
      $hoursparts[] = date($this->config['format'], $start) . $this->config['separator'] . date($this->config['format'], $end);
    }

    return implode($this->config['join'], $hoursparts);

  }
  
  /**
   *
   * @param string $timestamp
   * @return array today's hours as array
   */
  private function hours_today_array($timestamp = null)
  {

    $timestamp     = (null !== $timestamp) ? $timestamp : time();
    $today         = strtotime(date('Y-m-d', $timestamp) . ' midnight');
    $weekday_short = date('N', $timestamp);
    $hours_today_array = array();

    if (isset($this->hours[$weekday_short])) {
      $hours_today_array = $this->hours[$weekday_short];
    }

    foreach ($this->exceptions as $ex_day => $ex_hours) {
      if (strtotime($ex_day) === $today) {
        // Today is an exception, use alternate hours instead
        $hours_today_array = $ex_hours;
      }
    }

    return $hours_today_array;

  }
  
  /**
   *
   * @return array
   */
  private function hours_this_week_simple()
  {

    $lookup = array_combine(range(1, 7), $this->config['overview_weekdays']);
    $ret = array();

    for ($i = 1; $i <= 7; $i++) {
      $hours_str = (isset($this->hours[$i]) && count($this->hours[$i]) > 0) ? $this->format_hours($this->hours[$i]) : '-';
      
      $ret[$lookup[$i]] = $hours_str;
    }

    return $ret;

  }
  
  /**
   *
   * @return array
   */
  private function hours_this_week_grouped()
  {
    $lookup = array_combine(range(1, 7), $this->config['overview_weekdays']);
    $blocks = array();

    // Remove empty elements ("closed all day")
    $hours = array_filter($this->hours, function($element)
    {
      return (count($element) > 0);
    });

    foreach ($hours as $weekday => $hours2) {
      foreach ($blocks as &$block) {
        if ($block['hours'] === $hours2) {
          $block['days'][] = $weekday;
          continue 2;
        }
      }
      unset($block);
      $blocks[] = array(
        'days' => array(
          $weekday
        ),
        'hours' => $hours2
      );
    }

    // Flatten
    $ret = array();
    foreach ($blocks as $block) {
      // Format days
      $keyparts     = array();
      $keys         = $block['days'];
      $buffer       = array();
      $lastIndex    = null;
      $minGroupSize = 3;
      
      foreach ($keys as $index) {
        if ($lastIndex !== null && $index - 1 !== $lastIndex) {
          if (count($buffer) >= $minGroupSize) {
            $keyparts[] = $lookup[$buffer[0]] . '-' . $lookup[$buffer[count($buffer) - 1]];
          } else {
            foreach ($buffer as $b) {
              $keyparts[] = $lookup[$b];
            }
          }
          $buffer = array();
        }
        $buffer[] = $index;
        $lastIndex = $index;
      }
      if (count($buffer) >= $minGroupSize) {
        $keyparts[] = $lookup[$buffer[0]] . '-' . $lookup[$buffer[count($buffer) - 1]];
      } else {
        foreach ($buffer as $b) {
          $keyparts[] = $lookup[$b];
        }
      }
      // Combine
      $ret[implode(', ', $keyparts)] = $this->format_hours($block['hours']);
    }

    return $ret;

  }

  /**
   *
   * @return string
   */
  public function is_open()
  {

    return $this->is_open_at();

  }
  
  /**
   *
   * @return string
   */
  public function hours_today()
  {

    $hours_today = $this->hours_today_array();
    return $this->format_hours($hours_today);

  }
  
  /**
   *
   * @return array
   */
  public function hours_this_week($groupSameDays = false)
  {

    return (true === $groupSameDays) ? $this->hours_this_week_grouped() : $this->hours_this_week_simple();
  
  }

}
