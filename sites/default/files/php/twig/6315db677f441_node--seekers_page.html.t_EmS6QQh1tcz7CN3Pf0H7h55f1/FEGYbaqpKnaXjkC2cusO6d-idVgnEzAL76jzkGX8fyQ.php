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

/* themes/custom/sahaj_marg/templates/node/node--seekers_page.html.twig */
class __TwigTemplate_183ac53acf62f9ebc43937825ea08922653d112bc99df40465ee894bf5ac44fe extends \Twig\Template
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
        echo "
";
        // line 56
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 56)) {
            // line 57
            echo "  ";
            $this->displayBlock('highlighted', $context, $blocks);
        }
        // line 61
        echo "


";
        // line 64
        $this->displayBlock('main', $context, $blocks);
        // line 139
        echo "
";
        // line 140
        $this->loadTemplate("@sahaj_marg/system/footer.html.twig", "themes/custom/sahaj_marg/templates/node/node--seekers_page.html.twig", 140)->display($context);
        // line 141
        echo "
";
    }

    // line 57
    public function block_highlighted($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 58
        echo "    <div class=\"highlighted\">";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 58), 58, $this->source), "html", null, true);
        echo "</div>
  ";
    }

    // line 64
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 65
        echo "  <div role=\"main\" class=\"main-container js-quickedit-main-content\">
    <div class=\"main-container-content\">

      ";
        // line 69
        echo "      <section class=\"content-section\">

        
        ";
        // line 73
        echo "        <div class=\"container-fluid\">
            <div class=\"row\">
\t\t\t\t";
        // line 75
        if (($context["sidebar_menu"] ?? null)) {
            // line 76
            echo "\t\t\t\t\t\t<div class=\"col-lg-2 col-md-12 left-side-menu light-theme-color pt-3\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["sidebar_menu"] ?? null), 76, $this->source), "html", null, true);
            echo "</div> 
\t\t\t
\t\t\t\t";
        }
        // line 79
        echo "\t\t\t\t
\t\t\t\t
\t\t\t\t
\t\t\t\t";
        // line 83
        echo "\t\t\t\t";
        $this->displayBlock('content', $context, $blocks);
        // line 131
        echo "          </div>
        
        </section>
      
      
    </div>
  </div>
";
    }

    // line 83
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 84
        echo "\t\t\t\t<div class=\"col-lg-7\">
\t\t\t\t\t<div class=\"col inner-page-content p-0 mt-2\">
\t\t\t\t\t\t<div class=\"main-content abhyasi-center\">
\t\t\t\t\t\t\t<div class=\"main-title seekers-title PlayfairDisplay-Bold\"><h1>";
        // line 87
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["node"] ?? null), "title", [], "any", false, false, true, 87), "value", [], "any", false, false, true, 87), 87, $this->source), "html", null, true);
        echo "</h1></div>
\t\t\t\t\t\t\t<div class=\"subnav\">";
        // line 88
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["node"] ?? null), "field_tabbed_pane_optional", [], "any", false, false, true, 88), "value", [], "any", false, false, true, 88), 88, $this->source));
        echo "</div>
\t\t\t\t\t\t\t\t

\t\t\t\t\t\t\t";
        // line 91
        if ((($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = twig_get_attribute($this->env, $this->source, ($context["content"] ?? null), "field_slider_optional", [], "any", false, false, true, 91)) && is_array($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4) || $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 instanceof ArrayAccess ? ($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4[0] ?? null) : null)) {
            // line 92
            echo "\t\t\t\t\t\t\t\t<div id=\"carouselExampleControls\" class=\"carousel slide\" data-ride=\"carousel\">
\t\t\t\t\t\t\t\t <div class=\"carousel-inner\">
\t\t\t\t\t\t\t\t ";
            // line 94
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["content"] ?? null), "field_slider_optional", [], "any", false, false, true, 94));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                if ((twig_first($this->env, $context["key"]) != "#")) {
                    // line 95
                    echo "\t\t\t\t\t\t\t\t  ";
                    if (twig_get_attribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, true, 95)) {
                        // line 96
                        echo "\t\t\t\t\t\t\t\t    <div class=\"carousel-item active\">
\t\t\t\t\t\t\t\t\t  <img src=\"";
                        // line 97
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["item"], 97, $this->source), "html", null, true);
                        echo "\" class=\"d-block w-100\">
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t  ";
                    } else {
                        // line 100
                        echo "\t\t\t\t\t\t\t\t    <div class=\"carousel-item\">
\t\t\t\t\t\t\t\t\t  <img src=\"";
                        // line 101
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["item"], 101, $this->source), "html", null, true);
                        echo "\" class=\"d-block w-100\">
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t  ";
                    }
                    // line 104
                    echo "\t\t\t\t\t\t\t\t";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 105
            echo "\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<a class=\"carousel-control-prev\" href=\"#carouselExampleControls\" role=\"button\" data-slide=\"prev\">
\t\t\t\t\t\t\t\t\t\t<span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
\t\t\t\t\t\t\t\t\t\t<span class=\"sr-only\">Previous</span>
\t\t\t  \t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t<a class=\"carousel-control-next\" href=\"#carouselExampleControls\" role=\"button\" data-slide=\"next\">
\t\t\t\t\t\t\t\t\t\t<span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>
\t\t\t\t\t\t\t\t\t\t<span class=\"sr-only\">Next</span>
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t";
        }
        // line 116
        echo "\t\t\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"abhyasi-trans text-justify\">";
        // line 117
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["node"] ?? null), "field_page_content", [], "any", false, false, true, 117), "value", [], "any", false, false, true, 117), 117, $this->source));
        echo "</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-lg-3\">
\t\t\t\t\t\t<div class=\"abhyasi-rightbar mt-5\">
\t\t\t\t\t\t";
        // line 123
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["node"] ?? null), "field_side_panel_image_optional", [], "any", false, false, true, 123))) {
            // line 124
            echo "\t\t\t\t\t\t\t<div class=\"quotes-img text-center\"><img src=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, call_user_func_array($this->env->getFunction('file_url')->getCallable(), [$this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["node"] ?? null), "field_side_panel_image_optional", [], "any", false, false, true, 124), "entity", [], "any", false, false, true, 124), "fileuri", [], "any", false, false, true, 124), 124, $this->source)]), "html", null, true);
            echo "\"></div>
\t\t\t\t\t    ";
        }
        // line 125
        echo "\t\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"quotes-text px-2 mt-3\">";
        // line 126
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["node"] ?? null), "field_side_panel_content", [], "any", false, false, true, 126), "value", [], "any", false, false, true, 126), 126, $this->source));
        echo "</div>
\t\t\t\t\t\t</div>
\t\t\t\t</div>
            </div>
            ";
    }

    public function getTemplateName()
    {
        return "themes/custom/sahaj_marg/templates/node/node--seekers_page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  228 => 126,  225 => 125,  219 => 124,  217 => 123,  208 => 117,  205 => 116,  192 => 105,  182 => 104,  176 => 101,  173 => 100,  167 => 97,  164 => 96,  161 => 95,  150 => 94,  146 => 92,  144 => 91,  138 => 88,  134 => 87,  129 => 84,  125 => 83,  114 => 131,  111 => 83,  106 => 79,  99 => 76,  97 => 75,  93 => 73,  88 => 69,  83 => 65,  79 => 64,  72 => 58,  68 => 57,  63 => 141,  61 => 140,  58 => 139,  56 => 64,  51 => 61,  47 => 57,  45 => 56,  42 => 54,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/sahaj_marg/templates/node/node--seekers_page.html.twig", "/srcm/projects/sahajmarg/themes/custom/sahaj_marg/templates/node/node--seekers_page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 56, "block" => 57, "include" => 140, "for" => 94);
        static $filters = array("escape" => 58, "raw" => 88, "first" => 94);
        static $functions = array("file_url" => 124);

        try {
            $this->sandbox->checkSecurity(
                ['if', 'block', 'include', 'for'],
                ['escape', 'raw', 'first'],
                ['file_url']
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
