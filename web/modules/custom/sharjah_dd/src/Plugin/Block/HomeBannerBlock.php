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
 * Provides a home Banner block.
 *
 * @Block(
 *   id = "home_banner_block",
 *   admin_label = @Translation("Home Banner Block"),
 *   category = @Translation("custom"),
 * )
 */
final class HomeBannerBlock extends BlockBase implements ContainerFactoryPluginInterface
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
    $front_banner = $config_page->get('field_banner')->entity ?? '';
    $banner_info = $config_page->get('field_banner_info')->value ?? '';
    $banner_url = '';
    if ($front_banner instanceof \Drupal\file\FileInterface) {
      $banner_url = \Drupal::entityTypeManager()->getStorage('image_style')->load('large'); // Replace 'large' with your desired style
      $banner_url = $banner_url->buildUrl($front_banner->getFileUri());
    }


    $items = [
      'banner_info' => $banner_info,
      'banner_url' => $banner_url,
    ];


    return [
      '#theme' => 'home_banner',
      '#items' => $items,
      '#cache' => [
        'tags' => $config_page ? $config_page->getCacheTags() : [],
        'contexts' => ['languages'],
      ],

    ];
 
  }
}
