<?php

declare(strict_types=1);

namespace Drupal\sharjah_dd\Plugin\Block;

use Drupal\Core\Block\BlockBase;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\config_pages\Entity\ConfigPages;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Url;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;


/**
 * Provides a Header block.
 *
 * @Block(
 *   id = "header_block",
 *   admin_label = @Translation("Header Block"),
 *   category = @Translation("sharjah_dd"),
 * )
 */
final class HeaderBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  /**
   * Constructs the plugin instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly ConfigFactoryInterface $configFactory,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self
  {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array
  {
    $config_page = ConfigPages::config('home_settings');
    if (!$config_page) {
      return [];
    }
    $top_logo_left = $config_page->get('field_top_logo_left')->entity ?? '';
    $top_logo_right = $config_page->get('field_top_logo_right')->entity ?? '';

    $left_logo_url = '';
    if ($top_logo_left instanceof \Drupal\file\FileInterface) {
      $left_logo_url = \Drupal::service('file_url_generator')->generateAbsoluteString($top_logo_left->getFileUri());
    } 
    $right_logo_url = '';
    if ($top_logo_right instanceof \Drupal\file\FileInterface) {
      $right_logo_url = \Drupal::service('file_url_generator')->generateAbsoluteString($top_logo_right->getFileUri());
    }
    $items = [
      'left_logo_url' => $left_logo_url,
      'right_logo_url' => $right_logo_url,
    ];
    return [
      '#theme' => 'header',
      '#items' => $items,
      '#cache' => [
        'tags' => $config_page ? $config_page->getCacheTags() : [],
        'contexts' => ['languages'],
      ],

    ];
  }
}
