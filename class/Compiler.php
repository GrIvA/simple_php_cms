<?php
class Compiler {
    public $settings;



    public function __construct() {
    }

    public function processGlobalCache() {
        $db = Database::getInstance();
        $cache = $db::getField("settings","value",array('id'=>1));
        $this->settings = $cache ? unserialize($cache) : array();
    }

    public function getPreloadPlugins() {
        // TODO: get plugin list
        return array();
    }

    public function prepare() {
        $rout = Router::getInstance();
        $match = $rout->match();
        // ['target', 'params', 'mame'];

        $this->processSessionCleanup();
        $this->style=$this->processStyle($request);
        $this->session=$this->processSession($request);
        $this->page=$this->processPage($request);
        $this->processSessionUpdate();
        $styleid=$this->style["id"];
        $bundles=$this->page["bundles"];
        $this->template=$this->page["template"];
        $this->bundles=$optimizer->getBundles($styleid,$bundles);
        if(!$this->bundles) $this->bundles=
          $optimizer->addBundles($styleid,$bundles,$this->compileBundles($bundles));
        $this->plugins=$optimizer->getBundlesPlugins($this->bundles);
        foreach($this->plugins as $index=>$name) {
          $filename=format(CompilerPluginFilename,$name);
          $fileSystem->normalize($filename);
          $this->plugins[$index]=$filename;
        }
        if(class_exists("StatisticsSupport"))
          StatisticsSupport::processVisitor($this->session,$request);
    }

    function processSessionCleanup() {
        /*
        if(!PhpcSessionEnabled || random(PhpcSessionGCDivisor)>=PhpcSessionGCProbability) return;
        $minimalTime=phpctime()-PhpcSessionTimeout;
        if(PhpcSessionCleanup && class_exists("UsersSupport")) {
            $sessions=$database->getLines("sessions","lastactivity<$minimalTime");
            if(count($sessions)) {
                $usersSupport->processSessionCleanup($sessions);
                $hashes=extractArrayColumn($sessions,"hash");
                $conditions=$database->getListCondition("hash",$hashes,true);
                $database->deleteLines("sessions",$conditions);
            }
        }
        else $database->deleteLines("sessions","lastactivity<$minimalTime");
        */
    }

  function processStyle(&$request)
  {
    global $usersSupport;
    $styles=$this->getStyles();
    $styleid=isset($_COOKIE[PhpcStyleCookie])?(int)$_COOKIE[PhpcStyleCookie]:0;
    if(class_exists("UsersSupport")) $usersSupport->processStyle($styleid);
    $bestWeight=-1;
    foreach($styles as $style) {
      if(!$style["visible"] && !isAdministrator()) continue;
      $hostMatch=$style["host"]==$_SERVER["HTTP_HOST"];
      $folder=$style["folder"]."/";
      $folderMatch=substr("$request/",0,strlen($folder))==$folder;
      if($style["host"]!="" && !$hostMatch) continue;
      if($style["folder"]!="" && !$folderMatch) continue;
      $weight=0;
      if($style["forusers"]) $weight+=1;
      if($style["id"]==$styleid) $weight+=2;
      if($folderMatch) $weight+=4;
      if($hostMatch) $weight+=8;
      if($weight>=$bestWeight) { $result=$style; $bestWeight=$weight; }
    }
    if($bestWeight<0) fatalError("fatal_nostyle");
    $cutoff=strlen($result["folder"]);
    if($cutoff) $request=(string)substr($request,$cutoff+1);
    return $result;
  }


}
?>
