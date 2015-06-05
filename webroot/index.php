<?php
define('DS', DIRECTORY_SEPARATOR); 
define('WEBDIR', dirname(__FILE__) . DS);
define('ROOTDIR', dirname(WEBDIR) . DS);
define('LIBDIR', ROOTDIR . 'lib' . DS);

if ( !file_exists(LIBDIR . 'config.php') ) {
    header('Location: install/' );
    die;
}

require_once LIBDIR . 'autoloader.php';
require_once LIBDIR . 'declarations.php';
require_once LIBDIR . 'config.php';

//standart rout
$rout = Router::getInstance();
$rout->map('GET|POST','/---', '', 'admin');
$rout->map('GET','/[ln:lang]/[page:page]', 'home#index', 'data');
$rout->map('GET','/','','start');
unset($rout);

// compilations
$compiler = new Compiler;
$compiler->processGlobalCache();
$plugins = $compiler->getPreloadPlugins();

foreach($plugins as $plugin) { 
    //TODO: require pluguns 
}

$compiler->prepare();
die('-= INDEX =-');
foreach($compiler->plugins as $plugin) { require_once $plugin; }
$scope = $compiler->processBundles();
$compiler->processTemplate($compiler->template,$scope);



/*
//$router = new Router();
//$lang   = new Languages();

// match current request
$match = $router->match();
?>

<h1>AltoRouter</h1>

<h3>Current request: </h3>
<pre>
	Target: <?php var_dump($match['target']); ?>
	Params: <?php var_dump($match['params']); ?>
	Name: 	<?php var_dump($match['name']); ?>
</pre>

<h3>Try these requests: </h3>
<p><a href="<?php echo $router->generate('data', array('lang'=>'en', 'action'=>'forgot_password')); ?>">GET <?php echo $router->generate('data', array('lang'=>'en', 'action'=>'forgot_password')); ?></a></p>
 */
?>
