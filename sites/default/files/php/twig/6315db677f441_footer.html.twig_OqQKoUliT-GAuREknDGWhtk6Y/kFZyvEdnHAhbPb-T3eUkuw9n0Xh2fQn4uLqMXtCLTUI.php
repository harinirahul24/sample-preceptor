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

/* @sahaj_marg/system/footer.html.twig */
class __TwigTemplate_36cd8ee9c2c2f6dd5979b1db5b290041f98a377fc303951583aab3bbe1e88999 extends \Twig\Template
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
        // line 1
        echo "<footer class=\"footer\" role=\"contentinfo\">
\t\t
\t\t<!-- Corono Popup -->
\t\t<div class=\"modal fade\" id=\"coronoinfo-box\" style=\"padding:0px !important;\">
\t\t<div class=\"modal-dialog\" style=\"width:100%; margin:-1px; max-width:100%\">
\t\t<div class=\"modal-content\"><button aria-hidden=\"true\" class=\"close\" data-dismiss=\"modal\" type=\"button\">×</button>
\t\t<div class=\"conrtainer\">Shri Ram Chandra Mission and its associate organizations are closely monitoring the ongoing Coronavirus Disease 2019 (COVID-19) pandemic. As the situation continues to change rapidly, our top priority remains the health, safety, and well-being of all across the globe. As a contingency and taking decisive and informed action to limit the spread of COVID-19,  it is advised that all our Ashrams shall remain closed till further notified  All group satsanghs, gatherings and seminars stand suspended till further advise. Travel to Kanha Shanti Vanam and other Ashrams is strictly restricted for the time being. While  ensuring continuity of practice at home, let us take advantage of remote group and individual sittings. We will update and keep all informed about any additional measures if any.</div>
\t\t</div>
\t\t</div>
\t\t</div>
\t\t<!-- Corono Popup -->
\t
      <div class=\"container-fluid\">
      ";
        // line 14
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 14)) {
            // line 15
            echo "            ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 15), 15, $this->source), "html", null, true);
            echo "
      ";
        }
        // line 17
        echo "  </div>
      ";
        // line 18
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footerbottom", [], "any", false, false, true, 18)) {
            // line 19
            echo "          ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footerbottom", [], "any", false, false, true, 19), 19, $this->source), "html", null, true);
            echo "
      ";
        }
        // line 21
        echo "    </footer>

";
    }

    public function getTemplateName()
    {
        return "@sahaj_marg/system/footer.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 21,  67 => 19,  65 => 18,  62 => 17,  56 => 15,  54 => 14,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@sahaj_marg/system/footer.html.twig", "/srcm/projects/sahajmarg/themes/custom/sahaj_marg/templates/system/footer.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 14);
        static $filters = array("escape" => 15);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
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
