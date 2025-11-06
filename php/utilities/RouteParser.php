<?php

class RouteParser
{
    protected $Route;

    protected $basePath;
    protected $siteDir;
    protected $request;
    protected $pagePath;
    protected $codePath;
    protected $resourcePath;

    public function __construct($type = "view")
    {
        $this->siteDir = $_SERVER['DOCUMENT_ROOT'];
        $this->request = $_SERVER['REDIRECT_URL'];

        switch (strtolower($type)) {
            case "view":
                $this->basePath = "/pages";
                $this->ValidateRoute();
                break;
            case "api":
                $this->basePath = "/api";
                $this->ValidateAPIRoute();
                break;
            default:
                throw new Exception("Invalid RouteParser Type");
                break;
        }
    }

    protected function ValidateRoute()
    {
        if (preg_match("~^/$~", $this->request)) {
            $this->resourcePath = "/index";
            return;
        }
        if (preg_match("~/vehicle/create$~", $this->request)) {
            $this->resourcePath = "/vehicle/create";
            return;
        }


        if (preg_match("~^/vehicle/(\d+)/summary$~", $this->request)) {
            $this->resourcePath = "/vehicle/summary";
            return;
        }
        if (preg_match("~^/vehicle/(\d+)/edit$~", $this->request)) {
            $this->resourcePath = "/vehicle/edit";
            return;
        }
        if (preg_match("~^/vehicle/(\d+)/delete$~", $this->request)) {
            $this->resourcePath = "/vehicle/delete";
            return;
        }

        /* index */
        if (preg_match("~^/vehicle/(\d+)/fillup$~", $this->request)) {
            $this->resourcePath = "/fillup/index";
            return;
        }

        /* create */
        if (preg_match("~^/vehicle/(\d+)/fillup/create$~", $this->request)) {
            $this->resourcePath = "/fillup/create";
            return;
        }

        /* edit */
        if (preg_match("~^/vehicle/(\d+)/fillup/(\d+)/edit$~", $this->request)) {
            $this->resourcePath = "/fillup/edit";
            return;
        }

        /* delete */
        if (preg_match("~^/vehicle/(\d+)/fillup/(\d+)/delete$~", $this->request)) {
            $this->resourcePath = "/fillup/delete";
            return;
        }


        /* basic */
        if (preg_match("~^/error$~", $this->request)) {
            $this->resourcePath = "/error";
            return;
        }
        if (preg_match("~^/unauthorized$~", $this->request)) {
            $this->resourcePath = "/unauthorized";
            return;
        }
    }

    protected function ValidateAPIRoute()
    {
        if (preg_match("~^/api/vehicle$~", $this->request)) {
            $this->resourcePath = "/vehicle";
            return;
        }
        if (preg_match("~^/api/vehicle/(\d+)$~", $this->request)) {
            $this->resourcePath = "/vehicle";
            return;
        }

        if (preg_match("~^/api/vehicle/(\d+)/fillup$~", $this->request)) {
            $this->resourcePath = "/fillup";
            return;
        }
        if (preg_match("~^/api/vehicle/(\d+)/fillup/(\d+)$~", $this->request)) {
            $this->resourcePath = "/fillup";
            return;
        }
    }

    function Request()
    {
        return $this->request;
    }
    function PagePath()
    {
        if ($this->resourcePath == "")
            return "";
        return $this->siteDir . $this->basePath . $this->resourcePath . ".php";
    }
    function CodePath()
    {
        if ($this->resourcePath == "")
            return "";
        return $this->siteDir . $this->basePath . $this->resourcePath . ".code.php";;
    }
    function CSS()
    {
        if ($this->resourcePath == "")
            return "";
        return $this->basePath . $this->resourcePath . ".php.css";
    }
    function JS()
    {
        if ($this->resourcePath == "")
            return "";
        return $this->basePath . $this->resourcePath . ".php.js";
    }
    function ResourcePath()
    {
        return $this->resourcePath;
    }
    function Page404()
    {
        return $this->siteDir . $this->basePath . "/404.php";
    }
}
