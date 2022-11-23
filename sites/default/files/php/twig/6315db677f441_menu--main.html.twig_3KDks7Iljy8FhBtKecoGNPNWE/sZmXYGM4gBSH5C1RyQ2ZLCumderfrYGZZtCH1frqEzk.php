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

/* themes/custom/sahaj_marg/templates/menu/menu--main.html.twig */
class __TwigTemplate_2902aea828af3a86a781d8e078613d9f00e62ce3fc51d897229c1b089eb29268 extends \Twig\Template
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
        // line 20
        echo "
";
        // line 47
        echo "
<nav class=\"navbar navbar-expand-xl sahajmarg-hover-menu custom-carets\">
<div class=\"header-menu\">
<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarCollapse\" aria-controls=\"navbarCollapse\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
<span class=\"navbar-toggler-icon\"></span>
</button>
  <div class=\"collapse navbar-collapse\" id=\"navbarCollapse\">
  \t";
        // line 54
        if (($context["items"] ?? null)) {
            // line 55
            echo "      <ul class=\"navbar-nav\">
      \t ";
            // line 56
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 57
                echo "          ";
                $context["active_class"] = ((twig_get_attribute($this->env, $this->source, $context["item"], "in_active_trail", [], "any", false, false, true, 57)) ? ("is-active") : (""));
                // line 58
                echo "      \t";
                if ((((($context["menu_level"] ?? null) == 0) && twig_get_attribute($this->env, $this->source, $context["item"], "is_expanded", [], "any", false, false, true, 58)) && twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 58))) {
                    // line 59
                    echo "      \t\t<li class=\"nav-item dropdown\">
      \t\t\t<a class=\"nav-link smd-link dropdown-toggle ";
                    // line 60
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["active_class"] ?? null), 60, $this->source), "html", null, true);
                    echo "\" href=\"";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 60), 60, $this->source), "html", null, true);
                    echo "\" id=\"navbarDropdownMenuLink\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                  ";
                    // line 61
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 61), 61, $this->source), "html", null, true);
                    echo "
              </a>
              ";
                    // line 63
                    if (twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 63)) {
                        // line 64
                        echo "                ";
                        $context["child_link"] = ["title" => twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 64), "url" => twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 64)];
                        // line 65
                        echo "\t\t\t\t        ";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["_self"], "macro_menu_links", [twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 65), twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "removeClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 65), (($context["menu_level"] ?? null) + 1), ($context["classes"] ?? null), ($context["child_link"] ?? null)], 65, $context, $this->getSourceContext()));
                        echo "
\t\t\t\t      ";
                    }
                    // line 67
                    echo "      \t\t</li>
      \t";
                } else {
                    // line 69
                    echo "      \t\t<li class=\"nav-item\">
              <a class=\"nav-link ";
                    // line 70
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["active_class"] ?? null), 70, $this->source), "html", null, true);
                    echo "\" href=\"";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 70), 70, $this->source), "html", null, true);
                    echo "\">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 70), 70, $this->source), "html", null, true);
                    echo " </a>
          </li>
      \t";
                }
                // line 73
                echo "      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 74
            echo "      </ul>
  \t";
        }
        // line 76
        echo "  </div>
  </div>
</nav>";
    }

    // line 21
    public function macro_menu_links($__items__ = null, $__attributes__ = null, $__menu_level__ = null, $__classes__ = null, $__child_link__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "items" => $__items__,
            "attributes" => $__attributes__,
            "menu_level" => $__menu_level__,
            "classes" => $__classes__,
            "child_link" => $__child_link__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 22
            echo "\t";
            if (($context["items"] ?? null)) {
                // line 23
                echo "\t\t<ul class=\"dropdown-menu\">
      <li class=\"d-xl-none\"><a href=\"";
                // line 24
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["child_link"] ?? null), "url", [], "any", false, false, true, 24), 24, $this->source), "html", null, true);
                echo "\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["child_link"] ?? null), "title", [], "any", false, false, true, 24), 24, $this->source), "html", null, true);
                echo "</a> </li>
      \t ";
                // line 25
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                    // line 26
                    echo "          ";
                    $context["active_class"] = ((twig_get_attribute($this->env, $this->source, $context["item"], "in_active_trail", [], "any", false, false, true, 26)) ? ("is-active") : (""));
                    // line 27
                    echo "      \t";
                    if ((twig_get_attribute($this->env, $this->source, $context["item"], "is_expanded", [], "any", false, false, true, 27) && twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 27))) {
                        // line 28
                        echo "      \t\t<li>

      \t\t\t<a  class=\"dropdown-item smd-link dropdown-toggle ";
                        // line 30
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["active_class"] ?? null), 30, $this->source), "html", null, true);
                        echo "\" href=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 30), 30, $this->source), "html", null, true);
                        echo "\" id=\"navbarDropdownMenuLink\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                  ";
                        // line 31
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 31), 31, $this->source), "html", null, true);
                        echo "
              </a>
              ";
                        // line 33
                        if (twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 33)) {
                            // line 34
                            echo "                 ";
                            $context["child_link"] = ["title" => twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 34), "url" => twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 34)];
                            // line 35
                            echo "\t\t\t\t        ";
                            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["_self"], "macro_menu_links", [twig_get_attribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 35), twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "removeClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 35), (($context["menu_level"] ?? null) + 1), ($context["classes"] ?? null), ($context["child_link"] ?? null)], 35, $context, $this->getSourceContext()));
                            echo "
\t\t\t\t      ";
                        }
                        // line 37
                        echo "      \t\t</li>
      \t";
                    } else {
                        // line 39
                        echo "      \t\t<li>
              <a class=\"dropdown-item ";
                        // line 40
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["active_class"] ?? null), 40, $this->source), "html", null, true);
                        echo "\" href=\"";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                        echo "\">";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                        echo " </a>
          </li>
      \t";
                    }
                    // line 43
                    echo "      ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 44
                echo "      </ul>
\t";
            }

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "themes/custom/sahaj_marg/templates/menu/menu--main.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  213 => 44,  207 => 43,  197 => 40,  194 => 39,  190 => 37,  184 => 35,  181 => 34,  179 => 33,  174 => 31,  168 => 30,  164 => 28,  161 => 27,  158 => 26,  154 => 25,  148 => 24,  145 => 23,  142 => 22,  125 => 21,  119 => 76,  115 => 74,  109 => 73,  99 => 70,  96 => 69,  92 => 67,  86 => 65,  83 => 64,  81 => 63,  76 => 61,  70 => 60,  67 => 59,  64 => 58,  61 => 57,  57 => 56,  54 => 55,  52 => 54,  43 => 47,  40 => 20,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/sahaj_marg/templates/menu/menu--main.html.twig", "/srcm/projects/sahajmarg/themes/custom/sahaj_marg/templates/menu/menu--main.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 54, "for" => 56, "set" => 57, "macro" => 21);
        static $filters = array("escape" => 60);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for', 'set', 'macro', 'import'],
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
