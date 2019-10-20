<?php

namespace View;

class DateTimeView
{

    private $date;

    public function __construct(\Model\Date $date)
    {
        $this->date = $date;
    }

    public function show()
    {
        return $this->generateTimeHTML();
    }

    private function generateTimeHTML(): string
    {
        return '<p>' . $this->date->getDayOfWeek() . ', the ' . $this->date->getDayOfMonth() . $this->getDayOfMonthEnding() . 'of ' . $this->date->getMonth() . ' ' . $this->date->getYear() . ', The time is ' . $this->date->getTimeOfDay() . '</p>';
    }

    private function getDayOfMonthEnding(): string
    {
        if ($this->date->getDayOfMonth() == '1') {
            return 'st ';
        } else if ($this->date->getDayOfMonth() == '2') {
            return 'nd ';
        } else if ($this->date->getDayOfMonth() == '3') {
            return 'rd ';
        }

        return 'th ';
    }
}
