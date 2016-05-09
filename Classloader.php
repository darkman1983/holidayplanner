<?php

/**
 * @author Timo Stepputtis
 *
 */

/**
 * Loads all classes recursive
 */
class Classloader {

  const BASE_DIR = __DIR__;

  const searchDirs = array ('classes', 'controllers','models' );

  /**
   * Search for $className recursive
   * 
   * @param string $className
   */
  public static function load( $className ) {
    foreach ( Classloader::searchDirs as &$cDir ) {
      $dir = new RecursiveDirectoryIterator ( Classloader::BASE_DIR . DIRECTORY_SEPARATOR . $cDir, RecursiveDirectoryIterator::SKIP_DOTS );
      $itr = new RecursiveIteratorIterator ( $dir );
      
      foreach ( $itr as $filename ) {
        if ( strstr ( $filename, $className ) ) {
          require_once $filename;
        }
      }
    }
  }
}

?>