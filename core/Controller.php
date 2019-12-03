<?php

namespace Core;

abstract class Controller
{
    protected $viewRoot = __DIR__.'/../views';
    protected $viewPath = 'main';
    protected $viewFile = 'index';

    /**
     * Render view file.
     *
     * @param array $data
     */
    public function render(array $data = [])
    {

        require $this->viewRoot .'/'. $this->viewPath .'/'. $this->viewFile . '.php';
    }
}