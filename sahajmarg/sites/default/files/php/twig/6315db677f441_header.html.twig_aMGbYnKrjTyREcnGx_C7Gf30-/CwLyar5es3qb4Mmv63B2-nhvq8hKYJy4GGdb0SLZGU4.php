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

/* @sahaj_marg/system/header.html.twig */
class __TwigTemplate_0d84e0e2eb6c118593697b8b289c5b96a26fea30e8806737f6432c7b25db62e9 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'navbar' => [$this, 'block_navbar'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div id='top-header'>
  <div class='container-fluid'>
    <div class='top-header-content'>
      ";
        // line 4
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "followus", [], "any", false, false, true, 4)) {
            // line 5
            echo "      <div id=\"followus\" class=\"followus-section p-1 col\">
        ";
            // line 6
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "followus", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
            echo "
      </div>
      ";
        }
        // line 9
        echo "    </div>
  </div>
</div>



<div class=\"navlogosearch\">
  <div class=\"container-fluid\">
    <div class=\"row\">

      <div id=\"logo-header\" class=\"col-xl-2 col-lg-9 col-md-8 col-sm-8 col-4 order-xl-1 order-lg-2 order-md-2 order-2\">
        ";
        // line 20
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "branding", [], "any", false, false, true, 20)) {
            // line 21
            echo "        <div id=\"branding\" class=\"branding-section text-center\">
          ";
            // line 22
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "branding", [], "any", false, false, true, 22), 22, $this->source), "html", null, true);
            echo "
        </div>
        ";
        }
        // line 25
        echo "      </div>



      ";
        // line 30
        echo "      <div id=\"main-navigation\" class=\"col-xl-10 col-lg-2 col-md-2 col-sm-2 col-4 order-lg-1 order-md-1 order-sm-1 order-1\">
        <div class=\"responsive-navbar\">
          <div class=\"row main-navigation-content\">
            ";
        // line 33
        if ((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation", [], "any", false, false, true, 33) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation_collapsible", [], "any", false, false, true, 33))) {
            // line 34
            echo "            ";
            $this->displayBlock('navbar', $context, $blocks);
            // line 56
            echo "            ";
        }
        // line 57
        echo "          </div>
        </div>
      </div>
      <div class=\"search-bar-trigger col order-3\"><span class=\"search-icon-container\"><div class=\"search-content\"></div></span><span
          class=\"close-icon-container\"><div class=\"close-search\"></div></span></div>
    </div>
  </div>
</div>
";
    }

    // line 34
    public function block_navbar($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 35
        echo "            ";
        // line 36
        $context["navbar_classes"] = [0 => "navbar", 1 => ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 38
($context["theme"] ?? null), "settings", [], "any", false, false, true, 38), "navbar_inverse", [], "any", false, false, true, 38)) ? ("navbar-inverse") : ("navbar-default")), 2 => ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 39
($context["theme"] ?? null), "settings", [], "any", false, false, true, 39), "navbar_position", [], "any", false, false, true, 39)) ? (("navbar-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["theme"] ?? null), "settings", [], "any", false, false, true, 39), "navbar_position", [], "any", false, false, true, 39), 39, $this->source)))) : (($context["container"] ?? null)))];
        // line 42
        echo "            <header ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["navbar_attributes"] ?? null), "addClass", [0 => ($context["navbar_classes"] ?? null)], "method", false, false, true, 42), 42, $this->source), "html", null, true);
        echo " id=\"navbar\" role=\"banner\">

              <div class=\"navbar-header\">
                ";
        // line 45
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation", [], "any", false, false, true, 45), 45, $this->source), "html", null, true);
        echo "
              </div>

              ";
        // line 49
        echo "              ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation_collapsible", [], "any", false, false, true, 49)) {
            // line 50
            echo "              <div id=\"navbar-collapse\" class=\"navbar-collapse collapse\">
                ";
            // line 51
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "navigation_collapsible", [], "any", false, false, true, 51), 51, $this->source), "html", null, true);
            echo "
              </div>
              ";
        }
        // line 54
        echo "            </header>
            ";
    }

    public function getTemplateName()
    {
        return "@sahaj_marg/system/header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  146 => 54,  140 => 51,  137 => 50,  134 => 49,  128 => 45,  121 => 42,  119 => 39,  118 => 38,  117 => 36,  115 => 35,  111 => 34,  99 => 57,  96 => 56,  93 => 34,  91 => 33,  86 => 30,  80 => 25,  74 => 22,  71 => 21,  69 => 20,  56 => 9,  50 => 6,  47 => 5,  45 => 4,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@sahaj_marg/system/header.html.twig", "/srcm/projects/sahajmarg/themes/custom/sahaj_marg/templates/system/header.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 4, "block" => 34, "set" => 36);
        static $filters = array("escape" => 6, "clean_class" => 39);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'block', 'set'],
                ['escape', 'clean_class'],
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
