<?php

namespace Model;

require_once 'model/Date.php';

class DateTimeGenerator
{

    private $datetime;
    private $dayOfWeek;
    private $dayOfMonth;
    private $month;
    private $year;
    private $timeOfDay;

    public function __construct()
    {
        $timeZone = 'Europe/Stockholm';
        $timestamp = time();
        $this->datetime = new \DateTime('now', new \DateTimeZone($timeZone));
        $this->datetime->setTimestamp($timestamp);
    }

    public function getTime()
    {
        return $this->generateTime();
    }

    private function generateTime()
    {
        $this->formatDateFields();
        return new Date($this->dayOfWeek, $this->dayOfMonth, $this->month, $this->year, $this->timeOfDay);
    }

    private function formatDateFields()
    {
        $this->dayOfWeek = $this->datetime->format('l');
        $this->dayOfMonth = $this->datetime->format('j');
        $this->month = $this->datetime->format('F');
        $this->year = $this->datetime->format('Y');
        $this->timeOfDay = $this->datetime->format('H:i:s');
    }

}
