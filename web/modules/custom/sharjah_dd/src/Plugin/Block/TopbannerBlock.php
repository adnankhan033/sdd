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
 * Provides a topbanner block.
 *
 * @Block(
 *   id = "top_banner",
 *   admin_label = @Translation("TopBanner"),
 *   category = @Translation("sharjah_dd"),
 * )
 */
final class TopbannerBlock extends BlockBase implements ContainerFactoryPluginInterface
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
    // $title = $config_page->get('field_banner_title')->value ?? '';
    // $body = $config_page->get('field_banner_description')->value ?? '';
    // $banner_mobile = $config_page->get('field_banner_mobile_number')->value ?? '';
    // $cover_image = $config_page->get('field_banner_cover')->entity ?? '';
    // $cover_banner = $config_page->get('field_banner_image')->entity ?? '';

    // $cover_url = '';
    // if ($cover_image instanceof \Drupal\file\FileInterface) {
    //   $cover_url = \Drupal::entityTypeManager()->getStorage('image_style')->load('banner_image'); // Replace 'banner_image' with your desired style
    //   $cover_url = $cover_url->buildUrl($cover_image->getFileUri());
    // }
    // $banner_img_url = '';
    // if ($cover_banner instanceof \Drupal\file\FileInterface) {
    //   $banner_img_url = \Drupal::entityTypeManager()->getStorage('image_style')->load('wide'); // Replace 'large' with your desired style
    //   $banner_img_url = $banner_img_url->buildUrl($cover_banner->getFileUri());
    // }


    $items = [
      'title' => $title,
      'body' => $body,
      'cover_image' => $cover_url,
      'banner_img_url' => $banner_img_url,
      'banner_mobile' => $banner_mobile,
    ];

    return [
      '#theme' => 'top_banner',
      '#items' => $items,
      '#cache' => [
        'tags' => $config_page ? $config_page->getCacheTags() : [],
        'contexts' => ['languages'],
      ],

    ];
  }
}
