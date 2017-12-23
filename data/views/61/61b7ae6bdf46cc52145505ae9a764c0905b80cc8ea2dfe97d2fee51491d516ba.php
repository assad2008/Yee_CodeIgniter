<?php

/* main.html */
class __TwigTemplate_c79d97e18e2f31a64b70028a942d1a916e22a010148fc0a673d7ac65b653b072 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"utf-8\">
    </head>
    <body>
    ";
        // line 7
        echo twig_escape_filter($this->env, ($context["welcome"] ?? null), "html", null, true);
        echo "
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "main.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 7,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"utf-8\">
    </head>
    <body>
    {{ welcome }}
    </body>
</html>", "main.html", "/www/wwwroot/ci.yeedev.xyz/application/views/main.html");
    }
}
