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

/* themes/custom/sahaj_marg/templates/links/links--language-block.html.twig */
class __TwigTemplate_619c7474211411a7b521d8e102aa999a6f8088c1159f6c2578c9b64a360cc0c7 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 37
        echo "<div class=\"language-ref-links language-select\">
";
        // line 38
        if (($context["links"] ?? null)) {
            // line 39
            if (($context["heading"] ?? null)) {
                // line 40
                if (twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "level", [], "any", false, false, true, 40)) {
                    // line 41
                    echo "<";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "level", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "attributes", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
                    echo ">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "text", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
                    echo "</";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "level", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
                    echo ">";
                } else {
                    // line 43
                    echo "<h2";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "attributes", [], "any", false, false, true, 43), 43, $this->source), "html", null, true);
                    echo ">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["heading"] ?? null), "text", [], "any", false, false, true, 43), 43, $this->source), "html", null, true);
                    echo "</h2>";
                }
            }
            // line 46
            if (twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "hasClass", [0 => "inline"], "method", false, false, true, 46)) {
                // line 47
                echo "<select";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => "language-select-box"], "method", false, false, true, 47), 47, $this->source), "html", null, true);
                echo " onchange=\"location = this.value;\">";
            } else {
                // line 49
                echo "<select";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => "language-select-box form-control"], "method", false, false, true, 49), 49, $this->source), "html", null, true);
                echo " onchange=\"location = this.value;\">";
            }
            // line 51
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["links"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                // line 52
                echo "<option";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 52), "addClass", [0 => \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed($context["key"], 52, $this->source))], "method", false, false, true, 52), 52, $this->source), "html", null, true);
                echo " value=\"/";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["key"], 52, $this->source), "html", null, true);
                echo "/";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, (($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, true, 52)) && is_array($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4) || $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 instanceof ArrayAccess ? ($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4["#url"] ?? null) : null), "internalPath", [], "any", false, false, true, 52), 52, $this->source), "html", null, true);
                echo "\" ";
                if (twig_get_attribute($this->env, $this->source, $context["item"], "in_active_trail", [], "any", false, false, true, 52)) {
                    echo " selected=\"selected\" ";
                }
                echo ">";
                // line 53
                if (twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, true, 53)) {
                    // line 54
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_upper_filter($this->env, $this->sandbox->ensureToStringAllowed($context["key"], 54, $this->source)), "html", null, true);
                } elseif (twig_get_attribute($this->env, $this->source,                 // line 55
$context["item"], "text_attributes", [], "any", false, false, true, 55)) {
                    // line 56
                    echo "<span";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "text_attributes", [], "any", false, false, true, 56), 56, $this->source), "html", null, true);
                    echo ">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_upper_filter($this->env, $this->sandbox->ensureToStringAllowed($context["key"], 56, $this->source)), "html", null, true);
                    echo "</span>";
                } else {
                    // line 58
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_upper_filter($this->env, $this->sandbox->ensureToStringAllowed($context["key"], 58, $this->source)), "html", null, true);
                }
                // line 60
                echo "</option>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 62
            echo "</select>";
        }
        // line 64
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "themes/custom/sahaj_marg/templates/links/links--language-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  119 => 64,  116 => 62,  110 => 60,  107 => 58,  100 => 56,  98 => 55,  96 => 54,  94 => 53,  82 => 52,  78 => 51,  73 => 49,  68 => 47,  66 => 46,  58 => 43,  48 => 41,  46 => 40,  44 => 39,  42 => 38,  39 => 37,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/sahaj_marg/templates/links/links--language-block.html.twig", "/srcm/projects/sahajmarg/themes/custom/sahaj_marg/templates/links/links--language-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 38, "for" => 51);
        static $filters = array("escape" => 41, "clean_class" => 52, "upper" => 54);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape', 'clean_class', 'upper'],
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
