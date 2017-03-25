<?php

/* /modules/sitepages/views/frontend/view.php */
class __TwigTemplate_ff5b457181a8ed2f3b49420babd654c6fe70649007e247c2621e85460c02bd8a extends Twig_Template
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
        echo "<?php
/* @var \$this FrontendController */
/* @var \$model FrontendSitepages */


/*
\$this->breadcrumbs=array(
\t//'Frontend Sitepages'=>array('index'),
\t'Новости'=>array('all'),
\t'Новостиаа'=>array(Yii::app()->createUrl('sitepages/frontend/category', array('category'=>'dop/test/dd'))),
//'Новостиd'=>Yii::app()->createUrl('sitepages/frontend/category', array('category'=>'dop/test')),
//'Новостиsd'=>array('url'=>Yii::app()->createUrl('sitepages/frontend/category', array('category'=>'dop/test/dd'))),
\t\$model->url_page,
);
*/

//echo \$model->url_page;




if (strcmp(\$model->url_page,\"main\") != 0)
{
\t\$cat = \"\";
\tfor (\$i = 0; \$i < count(\$mas)-1; \$i++)
\t{
\t\tif (\$i == 0) \$cat .= \$mas[\$i];
\t\telse \$cat .= \"/\".\$mas[\$i];
\t\t\$this->breadcrumbs[\$mas_title[\$i]]=array(Yii::app()->createUrl('sitepages/frontend/category', array('category'=>\$cat)));
\t}
\t\$this->breadcrumbs[]=\$model->title_for_admin;
}

echo \$model->title_short;

\t//echo \$mas[\$i].\"<br />\";

/*
\$this->breadcrumbs['Новостиаа']=array(Yii::app()->createUrl('sitepages/frontend/category', array('category'=>'dop/test/dd')));
\$this->breadcrumbs[]='Edit';
*/
/*
\$this->menu=array(
\tarray('label'=>'List FrontendSitepages', 'url'=>array('index')),
\tarray('label'=>'Create FrontendSitepages', 'url'=>array('create')),
\tarray('label'=>'Update FrontendSitepages', 'url'=>array('update', 'id'=>\$model->id)),
\tarray('label'=>'Delete FrontendSitepages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>\$model->id),'confirm'=>'Are you sure you want to delete this item?')),
\tarray('label'=>'Manage FrontendSitepages', 'url'=>array('admin')),
);
*/
?>

<h1>View FrontendSitepages #<?php echo \$model->id; ?></h1>

<?php
/* \$this->widget('zii.widgets.CDetailView', array(
\t'data'=>\$model,
\t'attributes'=>array(
\t\t'id',
\t\t'parent_id',
\t\t'status',
\t\t'url_page',
\t\t'title_for_admin',
\t\t'title_short',
\t\t'keywords',
\t\t'description',
\t),
)); */?>
";
    }

    public function getTemplateName()
    {
        return "/modules/sitepages/views/frontend/view.php";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
