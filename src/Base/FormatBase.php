<?php

namespace Emerap\Ra\Base;

use Emerap\Ra\Core\FormatInterface;

/**
 * Class FormatBase.
 *
 * @package Emerap\Ra\Base
 */
abstract class FormatBase implements FormatInterface {

  /**
   * Get Format mime-type.
   *
   * @return string
   *   Format mime-type.
   */
  public function getMimeType() {
    return 'text/plain';
  }

  /**
   * Check requirements.
   *
   * @return bool
   *   Requirements state.
   */
  public function requirements() {
    return TRUE;
  }

}
