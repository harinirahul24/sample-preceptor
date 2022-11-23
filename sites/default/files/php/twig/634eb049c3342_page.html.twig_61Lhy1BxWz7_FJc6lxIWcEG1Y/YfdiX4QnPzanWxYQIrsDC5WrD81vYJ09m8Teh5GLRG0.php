<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/custom/sahaj_marg/templates/page/page.html.twig */
class __TwigTemplate_41db65a9ddc3fd27119ce666db2feda3583a46fc1ac0992335f14945e270bcdd extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'highlighted' => [$this, 'block_highlighted'],
            'main' => [$this, 'block_main'],
            'content' => [$this, 'block_content'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 54
        $this->loadTemplate("@sahaj_marg/system/header.html.twig", "themes/custom/sahaj_marg/templates/page/page.html.twig", 54)->display($context);
        // line 55
        echo " ";
        // line 56
        echo "  ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 56)) {
            // line 57
            echo "    <div class=\"container\">
      <div class=\"row\">
    ";
            // line 59
            $this->displayBlock('highlighted', $context, $blocks);
            // line 62
            echo "    </div>
  </div>
  ";
        }
        // line 65
        echo "
";
        // line 67
        $this->displayBlock('main', $context, $blocks);
        // line 84
        echo "
";
        // line 85
        $this->loadTemplate("@sahaj_marg/system/footer.html.twig", "themes/custom/sahaj_marg/templates/page/page.html.twig", 85)->display($context);
        // line 86
        echo "    ";
    }

    // line 59
    public function block_highlighted($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 60
        echo "      ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 60), 60, $this->source), "html", null, true);
        echo "
    ";
    }

    // line 67
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 68
        echo "  <div role=\"main\" class=\"main-container js-quickedit-main-content\">
    <div class=\"main-container-content\"> 

      ";
        // line 72
        echo "      <section class=\"content-section\">     
        ";
        // line 74
        echo "        ";
        $this->displayBlock('content', $context, $blocks);
        // line 78
        echo "      </section>

      
    </div>
  </div>
";
    }

    // line 74
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 75
        echo "          <a id=\"main-content\"></a>
          <div class=\"main-content\">";
        // line 76
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 76), 76, $this->source), "html", null, true);
        echo "</div>
        ";
    }

    public function getTemplateName()
    {
        return "themes/custom/sahaj_marg/templates/page/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  116 => 76,  113 => 75,  109 => 74,  100 => 78,  97 => 74,  94 => 72,  89 => 68,  85 => 67,  78 => 60,  74 => 59,  70 => 86,  68 => 85,  65 => 84,  63 => 67,  60 => 65,  55 => 62,  53 => 59,  49 => 57,  46 => 56,  44 => 55,  42 => 54,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/sahaj_marg/templates/page/page.html.twig", "/srcm/projects/preceptor/themes/custom/sahaj_marg/templates/page/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("include" => 54, "if" => 56, "block" => 59);
        static $filters = array("escape" => 60);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['include', 'if', 'block'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
