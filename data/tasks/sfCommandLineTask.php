<?php
/*
 * This file is part of the sfUtilitiesPlugin package.
 * (c) 2007 Romain Cambien
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

pake_desc('Run a batch');
pake_task('run', 'project_exists');

function run_run($task, $args) 
{
  if (empty($args[0])) {
    throw new sfException('Missing batch name');
  }

  if (!defined('SF_ROOT_DIR')) {
    define('SF_ROOT_DIR', sfConfig::get('sf_root_dir'));
  }  

  $batchName = SF_ROOT_DIR.'/batch/'.$args[0].'.php';
  
  if (!file_exists($batchName)) {
    throw new sfException("Can't find batch file : ".$batchName);
  }

  $argv = array();
  for ($i = 1; $i < $_SERVER["argc"]; $i++) 
  {
    if ($_SERVER["argv"][$i]{0} === '-') 
    {
      // argument
      $value =  (
        isset($_SERVER["argv"][$i+1]) 
        && 
        $_SERVER["argv"][$i+1]{0} !== '-'
        ?
        $_SERVER["argv"][$i+1]
        :
        true
      );
      
      if ($_SERVER["argv"][$i]{1} === '-') 
      {
        // long argument
        $argv[substr($_SERVER["argv"][$i], 2)] = $value;
      }
      else 
      {
        foreach (str_split($_SERVER["argv"][$i]) as $arg) 
        {
          if (ereg('[a-zA-Z0-9]', $arg)) 
          {
            $last_arg   = $arg;
            $argv[$arg] = true;
          }
        }
        $argv[$last_arg] = $value;
      }
    }
  }
  
  define('SF_APP',         (isset($argv['app'])?$argv['app']:'frontend'));
  define('SF_ENVIRONMENT', (isset($argv['env'])?$argv['env']:'prod'));
  define('SF_DEBUG',       (isset($argv['debug'])?1:0));

  if (!is_dir(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP)) {
    throw new sfException(sprintf('Appliction %s does not exist in the project', SF_APP));
  }

  require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
  require_once($batchName);
}
