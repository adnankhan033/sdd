<?php

declare(strict_types=1);

namespace Drupal\sharjah_dd\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for sharjah_dd routes.
 */
final class FrontController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t(''),
    ];

    return $build;
  }

}
