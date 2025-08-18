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
 * Provides a Front Initiatives block.
 *
 * @Block(
 *   id = "front_initiatives",
 *   admin_label = @Translation("Front Initiatives Block"),
 *   category = @Translation("sharjah_dd"),
 * )
 */
final class FrontInitiativesBlock extends BlockBase implements ContainerFactoryPluginInterface
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
    
    $description = $config_page->get('field_front_initiatives_desc')->value ?? '';
    $highlight = $config_page->get('field_front_initiatives_highligh')->value ?? '';
    $title = $config_page->get('field_front_initiatives_title')->value ?? '';
    
    $items = [
      'highlight' => $highlight,
      'title' => $title,
      'description' => $description,
    ];
    return [
      '#theme' => 'front_initiatives',
      '#items' => $items,
      '#cache' => [
        'tags' => $config_page ? $config_page->getCacheTags() : [],
        'contexts' => ['languages'],
      ],

    ];
 
  }
}
