<?php

namespace Controller;

class LayoutController
{

    private $view;

    public function __construct(\View\LayoutView $view)
    {
        $this->view = $view;
    }

    public function renderPage()
    {
        $this->view->render();
    }
}
