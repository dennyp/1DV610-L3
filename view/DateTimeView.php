<?php

namespace View;

class DateTimeView {


	public function show() {

		$timeString = time();

		return '<p>' . date('l', $timeString) . ', the ' . date('d', $timeString) . 'th of ' . date('F Y', $timeString) . ', The time is ' . date('H:i:s', $timeString) . '</p>';
	}
}
