<?php

namespace Emerap\Ra\Base;

use Emerap\Ra\Core\FormatInterface;

abstract class FormatBase implements FormatInterface {

  /**
   * Get format mime-type
   * @return string
   */
  public function getMimeType() {
    return 'text/plain';
  }

  /**
   * Check requirements
   * @return bool
   */
  public function requirements() {
    return TRUE;
  }

}