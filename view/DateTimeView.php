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
        if ($this->endsWith($this->date->getDayOfMonth(), '1') ||
            $this->endsWith($this->date->getDayOfMonth(), '21')) {
            return 'st ';
        } else if ($this->endsWith($this->date->getDayOfMonth(), '2') ||
            $this->endsWith($this->date->getDayOfMonth(), '22')) {
            return 'nd ';
        } else if ($this->endsWith($this->date->getDayOfMonth(), '3') ||
            $this->endsWith($this->date->getDayOfMonth(), '23')) {
            return 'rd ';
        }

        return 'th ';
    }

    private function endsWith(string $toSearch, string $valueToFind): string
    {
        $length = strlen($valueToFind);
        return (substr($toSearch, -$length) === $valueToFind);
    }
}
