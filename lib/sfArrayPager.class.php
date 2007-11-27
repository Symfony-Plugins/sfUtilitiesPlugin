<?php
/*
 * This file is part of the sfUtilitiesPlugin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class sfArrayPager extends sfPager
{
  protected $resultsArray = array();
  
  public function init()
  {
    $this->setNbResults(count($this->resultsArray));
 
    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0)) {
      $this->setLastPage(0);
    } else {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
  }

  public function setResultArray($array)
  {
    $this->resultsArray = $array;
  }
 
  public function getResultArray()
  {
    return $this->resultsArray;
  }
 
  public function retrieveObject($offset) 
  {
    return (isset($this->resultsArray[$offset]))?$this->resultsArray[$offset]:null;
  }
 
  public function getResults()
  {
    return array_slice(
      $this->resultsArray, 
      ($this->getPage() - 1) * $this->getMaxPerPage(), 
      $this->maxPerPage
    );
  }
}
