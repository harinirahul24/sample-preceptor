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

/* themes/custom/sahaj_marg/templates/sm-sidebar-menu.html.twig */
class __TwigTemplate_2b40f4c4014daa12cd8772c6155740956ef5ab1676480c7cb8ed52883ca81de3 extends \Twig\Template
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
        // line 1
        echo "<div aria-multiselectable=\"true\" class=\"panel-group sidebar-menu\" id=\"accordion\" role=\"tablist\">
";
        // line 2
        $context["i"] = 1;
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["menu_items"] ?? null), "subtree", [], "any", false, false, true, 3));
        foreach ($context['_seq'] as $context["_key"] => $context["menu_item"]) {
            // line 4
            echo "  ";
            $context["active_class"] = ((twig_get_attribute($this->env, $this->source, $context["menu_item"], "in_active_trail", [], "any", false, false, true, 4)) ? ("is-active") : (""));
            // line 5
            echo "  <div class=\"panel panel-default\">
    <div class=\"panel-heading\" id=\"heading";
            // line 6
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["i"] ?? null), 6, $this->source), "html", null, true);
            echo "\" role=\"tab\">
        <h5 class=\"panel-title mt-2\"><span>
          ";
            // line 8
            if (twig_get_attribute($this->env, $this->source, $context["menu_item"], "url", [], "any", false, false, true, 8)) {
                // line 9
                echo "            <a class=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["active_class"] ?? null), 9, $this->source), "html", null, true);
                echo "\" href=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["menu_item"], "url", [], "any", false, false, true, 9), 9, $this->source), "html", null, true);
                echo "\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["menu_item"], "title", [], "any", false, false, true, 9), 9, $this->source), "html", null, true);
                echo "</a>
          ";
            } else {
                // line 11
                echo "            <span class=\"";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["active_class"] ?? null), 11, $this->source), "html", null, true);
                echo "\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["menu_item"], "title", [], "any", false, false, true, 11), 11, $this->source), "html", null, true);
                echo "</span>
          ";
            }
            // line 13
            echo "        </span>
    ";
            // line 14
            if (twig_get_attribute($this->env, $this->source, $context["menu_item"], "subtree", [], "any", false, false, true, 14)) {
                // line 15
                echo "        <a class=\"collapsed collapse-handle\" aria-controls=\"collapse";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["i"] ?? null), 15, $this->source), "html", null, true);
                echo "\" aria-expanded=\"false\" data-parent=\"#accordion\" data-toggle=\"collapse\" href=\"#collapse";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["i"] ?? null), 15, $this->source), "html", null, true);
                echo "\">&nbsp;</a></h5>
      </div>
      ";
                // line 17
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["_self"], "macro_sidebar_menu_inner_links", [twig_get_attribute($this->env, $this->source, $context["menu_item"], "subtree", [], "any", false, false, true, 17), ($context["i"] ?? null)], 17, $context, $this->getSourceContext()));
                echo "
    ";
            } else {
                // line 19
                echo "      </h5></div>
    ";
            }
            // line 21
            echo "  </div>
  ";
            // line 22
            $context["i"] = (($context["i"] ?? null) + 1);
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['menu_item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo "


</div>


";
    }

    // line 30
    public function macro_sidebar_menu_inner_links($__items__ = null, $__i__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "items" => $__items__,
            "i" => $__i__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 31
            echo "  ";
            if (($context["items"] ?? null)) {
                echo "   
    <div aria-labelledby=\"heading";
                // line 32
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["i"] ?? null), 32, $this->source), "html", null, true);
                echo "\" class=\"panel-collapse collapse in\" id=\"collapse";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["i"] ?? null), 32, $this->source), "html", null, true);
                echo "\" role=\"tabpanel\">
      ";
                // line 33
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                    // line 34
                    echo "        ";
                    $context["active_class"] = ((twig_get_attribute($this->env, $this->source, $context["item"], "in_active_trail", [], "any", false, false, true, 34)) ? ("is-active") : (""));
                    // line 35
                    echo "        <p class=\"panel-body\">
          ";
                    // line 36
                    if (twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 36)) {
                        // line 37
                        echo "          <a class=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["active_class"] ?? null), 37, $this->source), "html", null, true);
                        echo "\" href=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 37), 37, $this->source), "html", null, true);
                        echo "\">";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 37), 37, $this->source), "html", null, true);
                        echo "</a>
          ";
                    } else {
                        // line 39
                        echo "            <span class=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["active_class"] ?? null), 39, $this->source), "html", null, true);
                        echo "\">";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 39), 39, $this->source), "html", null, true);
                        echo "</span>
          ";
                    }
                    // line 41
                    echo "        </p>
        ";
                    // line 42
                    if (twig_get_attribute($this->env, $this->source, $context["item"], "subtree", [], "any", false, false, true, 42)) {
                        // line 43
                        echo "          ";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["_self"], "macro_sidebar_menu_links", [twig_get_attribute($this->env, $this->source, $context["item"], "subtree", [], "any", false, false, true, 43)], 43, $context, $this->getSourceContext()));
                        echo "
        ";
                    }
                    // line 45
                    echo "      ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 46
                echo "     </div>
  ";
            }

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "themes/custom/sahaj_marg/templates/sm-sidebar-menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  193 => 46,  187 => 45,  181 => 43,  179 => 42,  176 => 41,  168 => 39,  158 => 37,  156 => 36,  153 => 35,  150 => 34,  146 => 33,  140 => 32,  135 => 31,  121 => 30,  111 => 24,  105 => 22,  102 => 21,  98 => 19,  93 => 17,  85 => 15,  83 => 14,  80 => 13,  72 => 11,  62 => 9,  60 => 8,  55 => 6,  52 => 5,  49 => 4,  45 => 3,  43 => 2,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/sahaj_marg/templates/sm-sidebar-menu.html.twig", "/srcm/projects/sahajmarg/themes/custom/sahaj_marg/templates/sm-sidebar-menu.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 2, "for" => 3, "if" => 8, "macro" => 30);
        static $filters = array("escape" => 6);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'for', 'if', 'macro', 'import'],
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
