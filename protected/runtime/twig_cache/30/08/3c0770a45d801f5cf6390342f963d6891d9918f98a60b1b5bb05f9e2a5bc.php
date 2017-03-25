<?php

/* /views//layouts/layoutSitePage.twig */
class __TwigTemplate_30083c0770a45d801f5cf6390342f963d6891d9918f98a60b1b5bb05f9e2a5bc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("//views/layouts/main.twig");

        $this->blocks = array(
            'container' => array($this, 'block_container'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "//views/layouts/main.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_container($context, array $blocks = array())
    {
        // line 4
        echo "222

";
        // line 6
        if (isset($context["this"])) { $_this_ = $context["this"]; } else { $_this_ = null; }
        $this->getAttribute($_this_, "widget", array(0 => "application.modules.sitepages.widgets.ShablonsWidget", 1 => array("params" => array("id_layout" => "1"))), "method");
        // line 7
        echo "



";
    }

    public function getTemplateName()
    {
        return "/views//layouts/layoutSitePage.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 7,  35 => 6,  31 => 4,  28 => 3,);
    }
}
