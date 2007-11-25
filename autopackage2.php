<?php

/**
 * script to automate the generation of the
 * package.xml file.
 * 
 * @author      Kiril Angov
 * @package     sfUtilitiesPlugin
 */

require_once 'PEAR/PackageFileManager2.php';

/**
 * Base version
 */
$baseVersion = '1.0.0';

/**
 * current version
 */
$version  = $baseVersion;
$dir      = dirname( __FILE__ );

/**
 * Current API version
 */
$apiVersion = '1.0.0';

/**
 * current state
 */
$state = 'stable';

/**
 * current API stability
 */
$apiStability = 'stable';

/**
 * release notes
 */
$notes = <<<EOT
--
EOT;

/**
 * package description
 */
$description = "Gives a symfony powered project various utilities in the form of classes.";

$package = new PEAR_PackageFileManager2();

$result = $package->setOptions(array(
  'filelistgenerator' => 'file',
  'ignore'            => array('autopackage2.php', 'package.xml', '.svn'),
  'simpleoutput'      => true,
  'baseinstalldir'    => 'sfUtilitiesPlugin/',
  'packagedirectory'  => $dir
));
if (PEAR::isError($result)) {
  echo $result->getMessage();
  die();
}

$package->setPackage('sfUtilitiesPlugin');
$package->setSummary('Various utilities for use in your symfony project');
$package->setDescription($description);

$package->setChannel('pear.symfony-project.com');
$package->setAPIVersion($apiVersion);
$package->setReleaseVersion($version);
$package->setReleaseStability($state);
$package->setAPIStability($apiStability);
$package->setNotes($notes);
$package->setPackageType('php');
$package->setLicense('MIT License', 'http://www.symfony-project.com/license');

$package->addMaintainer('lead', 'kupokomapa', 'Kiril Angov', 'kupokomapa@gmail.com', 'yes');

$package->setPhpDep('5.1.0');
$package->setPearinstallerDep('1.4.1');

$package->addPackageDepWithChannel(
  'required',
  'symfony',
  'pear.symfony-project.com',
  '1.0.0',
  '1.1.0',
  false,
  '1.1.0'
);

$package->generateContents();

$result = $package->writePackageFile();
if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}
