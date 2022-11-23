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

/* themes/custom/sahaj_marg/templates/menu/menu.html.twig */
class __TwigTemplate_cd93c21f713f998e6420719233ae6799f7c760f2e30f6328e983827e386eb310 extends \Twig\Template
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
        $macros["_self"] = $this->macros["_self"] = $this;
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 46
        echo "
";
        // line 52
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["_self"], "macro_menu_links", [($context["items"] ?? null), ($context["attributes"] ?? null), 0, ((($context["classes"] ?? null)) ? (($context["classes"] ?? null)) : ([0 => "menu", 1 => ("menu--" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["menu_name"] ?? null), 52, $this->source))), 2 => "nav"]))], 52, $context, $this->getSourceContext()));
        echo "
";
    }

    // line 20
    public function macro_menu_links($__items__ = null, $__attributes__ = null, $__menu_level__ = null, $__classes__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "items" => $__items__,
            "attributes" => $__attributes__,
            "menu_level" => $__menu_level__,
            "classes" => $__classes__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 21
            echo "  ";
            if (($context["items"] ?? null)) {
                // line 22
                echo "    <ul";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => (((($context["menu_level"] ?? null) == 0)) ? (($context["classes"] ?? null)) : ("dropdown-menu"))], "method", false, false, true, 22), 22, $this->source), "html", null, true);
                echo ">
    ";
                // line 23
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                    // line 24
                    echo "      ";
                    // line 25
                    $context["item_classes"] = [0 => (((twig_get_attribute($this->env, $this->source,                     // line 26
$context["item"], "is_expanded", [], "any", false, false, true, 26) && twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 26))) ? ("expanded") : ("")), 1 => ((((twig_get_attribute($this->env, $this->source,                     // line 27
$context["item"], "is_expanded", [], "any", false, false, true, 27) && (($context["menu_level"] ?? null) == 0)) && twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 27))) ? ("dropdown") : ("")), 2 => ((twig_get_attribute($this->env, $this->source,                     // line 28
$context["item"], "in_active_trail", [], "any", false, false, true, 28)) ? ("active") : (""))];
                    // line 31
                    echo "      ";
                    if ((((($context["menu_level"] ?? null) == 0) && twig_get_attribute($this->env, $this->source, $context["item"], "is_expanded", [], "any", false, false, true, 31)) && twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 31))) {
                        // line 32
                        echo "        <li";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 32), "addClass", [0 => ($context["item_classes"] ?? null)], "method", false, false, true, 32), 32, $this->source), "html", null, true);
                        echo ">
        <a href=\"";
                        // line 33
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 33), 33, $this->source), "html", null, true);
                        echo "\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 33), 33, $this->source), "html", null, true);
                        echo " <span class=\"caret\"></span></a>
      ";
                    } else {
                        // line 35
                        echo "        <li";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 35), "addClass", [0 => ($context["item_classes"] ?? null)], "method", false, false, true, 35), 35, $this->source), "html", null, true);
                        echo ">
        ";
                        // line 36
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getLink($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 36), 36, $this->source), $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 36), 36, $this->source)), "html", null, true);
                        echo "
      ";
                    }
                    // line 38
                    echo "      ";
                    if (twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 38)) {
                        // line 39
                        echo "        ";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["_self"], "macro_menu_links", [twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 39), twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "removeClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 39), (($context["menu_level"] ?? null) + 1), ($context["classes"] ?? null)], 39, $context, $this->getSourceContext()));
                        echo "
      ";
                    }
                    // line 41
                    echo "      </li>
    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 43
                echo "    </ul>
  ";
            }

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "themes/custom/sahaj_marg/templates/menu/menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  125 => 43,  118 => 41,  112 => 39,  109 => 38,  104 => 36,  99 => 35,  92 => 33,  87 => 32,  84 => 31,  82 => 28,  81 => 27,  80 => 26,  79 => 25,  77 => 24,  73 => 23,  68 => 22,  65 => 21,  49 => 20,  43 => 52,  40 => 46,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/sahaj_marg/templates/menu/menu.html.twig", "/srcm/projects/sahajmarg/themes/custom/sahaj_marg/templates/menu/menu.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("macro" => 20, "if" => 21, "for" => 23, "set" => 25);
        static $filters = array("clean_class" => 52, "escape" => 22);
        static $functions = array("link" => 36);

        try {
            $this->sandbox->checkSecurity(
                ['macro', 'if', 'for', 'set', 'import'],
                ['clean_class', 'escape'],
                ['link']
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
