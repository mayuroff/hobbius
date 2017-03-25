<?php

/* /views//layouts/layoutSitePage.php */
class __TwigTemplate_3936064facd458de5bc91bfdf6736692f82730bb32165e5263c85ddfd1858183 extends Twig_Template
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
        echo "<?php /* @var \$this Controller */ ?>
<?php \$this->beginContent('//layouts/main'); ?>

<?php \$this->widget('application.modules.sitepages.widgets.ShablonsWidget',array('params'=>array('id_layout' => '1'))); ?>


<div class=\"my_lay\">Шаблон №22 layoutSitePage</div>
<div class=\"row\">
    <div class=\"span9\">
        <div id=\"content\">
            <?php echo \$content; ?>
            ";
        // line 12
        if (isset($context["content"])) { $_content_ = $context["content"]; } else { $_content_ = null; }
        echo twig_escape_filter($this->env, $_content_, "html", null, true);
        echo "
        </div><!-- content -->
    </div>
    <div class=\"span3\">
        <div id=\"sidebar\">
        <?php
            \$this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            \$this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>\$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            \$this->endWidget();
        ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php \$this->endContent(); ?>";
    }

    public function getTemplateName()
    {
        return "/views//layouts/layoutSitePage.php";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  32 => 12,  19 => 1,);
    }
}
