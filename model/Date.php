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

    public function getDayOfWeek(): string
    {
        return $this->dayOfWeek;
    }

    public function getDayOfMonth(): string
    {
        return $this->dayOfMonth;
    }

    public function getMonth(): string
    {
        return $this->month;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getTimeOfDay(): string
    {
        return $this->timeOfDay;
    }
}
