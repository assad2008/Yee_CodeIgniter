<?php

/* main.html */
class __TwigTemplate_d6d621141b6184f95d67be1a4b53524db22ef7e4ff64dfea771890544666e899 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
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
        echo "，";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "post_title", []), "html", null, true);
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
        return array (  31 => 7,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"utf-8\">
    </head>
    <body>
    {{ welcome }}，{{ post.post_title }}
    </body>
</html>", "main.html", "/www/wwwroot/ci.yeedev.xyz/application/views/main.html");
    }
}
