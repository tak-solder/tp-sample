<?php


namespace Sample\Template;


class View
{

    private $vars = [];

    public function __set($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function show($file)
    {
        if (!is_file($file)) {
            throw new \Exception('unknown template file: '.$file);
        }

        $html = file_get_contents($file);

        preg_replace_callback('/\{#(\w+)#}/', function ($m) {
            if (!isset($this->vars[$m[1]])) {
                throw new \Exception('unknown var: '.$m[1]);
            }

            return $this->vars[$m[1]];
        }, $html);
    }

}