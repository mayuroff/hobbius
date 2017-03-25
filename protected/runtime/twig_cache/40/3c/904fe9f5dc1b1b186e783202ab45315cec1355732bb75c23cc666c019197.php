<?php

/* //views/layouts/main.twig */
class __TwigTemplate_403c904fe9f5dc1b1b186e783202ab45315cec1355732bb75c23cc666c019197 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'container' => array($this, 'block_container'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"ru\">
<head>
\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
\t<meta name=\"language\" content=\"ru\" />
\t<link rel=\"shortcut icon\" href=\"/favicon.ico\" />
    <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 7
        if (isset($context["App"])) { $_App_ = $context["App"]; } else { $_App_ = null; }
        echo $this->getAttribute($_App_, "baseUrl");
        echo "/css/styles.css\" />

\t<title>";
        // line 9
        if (isset($context["this"])) { $_this_ = $context["this"]; } else { $_this_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_this_, "pageTitle"));
        echo "</title>

\t";
        // line 11
        if (isset($context["App"])) { $_App_ = $context["App"]; } else { $_App_ = null; }
        echo $this->getAttribute($this->getAttribute($_App_, "bootstrap"), "register", array(), "method");
        echo "
</head>

<body>

";
        // line 16
        if (isset($context["this"])) { $_this_ = $context["this"]; } else { $_this_ = null; }
        if (isset($context["App"])) { $_App_ = $context["App"]; } else { $_App_ = null; }
        $this->getAttribute($_this_, "widget", array(0 => "bootstrap.widgets.TbNavbar", 1 => array("items" => array(0 => array("label" => "Home", "url" => array(0 => "/site/index")), 1 => array("label" => "Каталог", "url" => array(0 => "/site/catalog")), 2 => array("label" => "Магазины", "url" => array(0 => "/site/shops")), 3 => array("label" => "Компания", "url" => array(0 => "/site/company")), 4 => array("label" => "Гостевая книга", "url" => array(0 => "/site/guestbook")), 5 => array("label" => "Вопросы-ответы", "url" => array(0 => "/site/faq")), 6 => array("label" => "Оптовая торговля", "url" => array(0 => "/site/wholesale")), 7 => array("label" => "Конкурс", "url" => array(0 => "/site/konkurs")), 8 => array("label" => "Contact", "url" => array(0 => "/site/contact")), 9 => array("label" => "Test", "url" => array(0 => "/site/test")), 10 => array("label" => "Login", "url" => array(0 => "/admin/login"), "visible" => $this->getAttribute($this->getAttribute($_App_, "user"), "isGuest")), 11 => array("label" => (("Logout (" . $this->getAttribute($this->getAttribute($_App_, "user"), "name")) . ")"), "url" => array(0 => "/site/logout"), "visible" => (!$this->getAttribute($this->getAttribute($_App_, "user"), "isGuest"))), 12 => array("label" => "Admin", "url" => array(0 => "/admin"))))), "method");
        // line 36
        echo "
<div class=\"container\" id=\"page\">

\t";
        // line 39
        if (isset($context["this"])) { $_this_ = $context["this"]; } else { $_this_ = null; }
        if ($this->getAttribute($_this_, "breadcrumbs")) {
            // line 40
            echo "\t\t";
            if (isset($context["this"])) { $_this_ = $context["this"]; } else { $_this_ = null; }
            $this->getAttribute($_this_, "widget", array(0 => "bootstrap.widgets.TbBreadcrumbs", 1 => array("links" => $this->getAttribute($_this_, "breadcrumbs"))), "method");
            // line 43
            echo "\t";
        }
        // line 44
        echo "
\t";
        // line 45
        $this->displayBlock('container', $context, $blocks);
        // line 47
        echo "
\t<div class=\"clear\"></div>

\t<div id=\"footer\">
\t\tCopyright &copy; ";
        // line 51
        if (isset($context["now"])) { $_now_ = $context["now"]; } else { $_now_ = null; }
        echo twig_date_format_filter($this->env, $_now_, "Y");
        echo " by My Company.<br/>
\t\tAll Rights Reserved.<br/>
\t\t";
        // line 53
        if (isset($context["Yii"])) { $_Yii_ = $context["Yii"]; } else { $_Yii_ = null; }
        echo $this->getAttribute($_Yii_, "powered");
        echo "
\t</div><!-- footer -->

</div><!-- page -->

</body>
</html>
";
    }

    // line 45
    public function block_container($context, array $blocks = array())
    {
        // line 46
        echo "\t";
    }

    public function getTemplateName()
    {
        return "//views/layouts/main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  101 => 46,  98 => 45,  85 => 53,  79 => 51,  73 => 47,  71 => 45,  68 => 44,  65 => 43,  61 => 40,  58 => 39,  53 => 36,  49 => 16,  40 => 11,  34 => 9,  28 => 7,  20 => 1,);
    }
}
