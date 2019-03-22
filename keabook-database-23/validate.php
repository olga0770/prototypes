<?php

function isTextValid($sData, $iMin, $iMax){
  if( strlen($sData) >= $iMin && strlen($sData) <= $iMax ){
    return true;
  }
  return false;
  
}