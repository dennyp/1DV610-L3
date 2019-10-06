<?php

namespace Model;

class Date
{

    private $dayOfWeek;
    private $dayOfMonth;
    private $month;
    private $year;
    private $timeOfDay;

    public function __construct($dayOfWeek, $dayOfMonth, $month, $year, $timeOfDay)
    {
        $this->dayOfWeek = $dayOfWeek;
        $this->dayOfMonth = $dayOfMonth;
        $this->month = $month;
        $this->year = $year;
        $this->timeOfDay = $timeOfDay;
    }

    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }

    public function getDayOfMonth()
    {
        return $this->dayOfMonth;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getTimeOfDay()
    {
        return $this->timeOfDay;
    }
}
