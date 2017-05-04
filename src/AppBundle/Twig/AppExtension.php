<?php
// http://twig.sensiolabs.org/doc/2.x/advanced.html#creating-an-extension
namespace AppBundle\Twig;

    use Doctrine\ORM\EntityManager;
    use Symfony\Component\HttpFoundation\RequestStack;
    use Twig_Environment;

    class AppExtension extends \Twig_Extension
    {
        protected $em;
        protected $stack;

        public function __construct(EntityManager $em, RequestStack $stack)
        {
            $this->em = $em;
            $this->stack = $stack;
        }

        public function getFunctions()
        {
            return array(
                // http://twig.sensiolabs.org/api/2.x/Twig_SimpleFunction.html
                new \Twig_SimpleFunction(
                        //http://twig.sensiolabs.org/doc/2.x/advanced.html#creating-an-extension
                        'stampaTabella1',                   // The first argument passed to the Twig_Filter constructor is the name of the function/filter you will use in templates
                        array($this, 'stampaTabella2'),     // the second one is the PHP callable to associate with it (in this case is the method written by Licari)
                                                            // riga 13 e 14 della sez. filters di http://twig.sensiolabs.org/doc/2.x/advanced.html#creating-an-extension (class method)
                        array('needs_environment' => true, 'is_safe' => array('html'))  //If you want to access the current environment instance in your filter, set the <needs_environment> option to true; Twig will pass the current environment as the first argument to the filter call:
                                                                                        //If <automatic escaping> is enabled, the output of the filter may be escaped before printing. If your filter acts as an escaper (or explicitly outputs HTML or JavaScript code), you will want the raw output to be printed. In such a case, set the is_safe option:
                                                                                        // senza il  settaggio  'is_safe' => array('html') viene a mancare l'interpretazione HTML, script ect
                )
            );
        }

        //If you want to access the current environment instance in your filter, set the needs_environment option to true;
        // Twig will pass the current environment as the first argument to the function/filter call:
        // Tip: in this case the third Twig_SimpleFunction's  parameter  is: array('needs_environment' => true)
        public function stampaTabella2(Twig_Environment $env, $persone){
            return $env->render("AppBundle:Template:stampaTabella.html.twig",array('persone' => $persone));
        }
    }
