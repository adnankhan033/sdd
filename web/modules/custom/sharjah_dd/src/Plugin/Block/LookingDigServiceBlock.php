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
 * Provides a  Are you looking for digital service?  block.
 *
 * @Block(
 *   id = "looking_digital_service_block",
 *   admin_label = @Translation("Are you looking for digital service? "),
 *   category = @Translation("sharjah_dd"),
 * )
 */
final class LookingDigServiceBlock extends BlockBase implements ContainerFactoryPluginInterface
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

    $config_page = ConfigPages::config('general_pages');
    if (!$config_page) {
      return [];
    }
    $link_uri = $config_page->get('field_digital_service_link')->getValue();
    $title = $config_page->get('field_digital_service_title')->value ?? '';
    $highlight = $config_page->get('field_digital_service_highlight')->value ?? '';
    $description = $config_page->get('field_ds_descriptio')->value ?? '';

    if ($link_uri) {
      $link_uri = $link_uri[0]['uri'] ?? '';
      $link_title = $config_page->get('field_digital_service_link')->getValue()[0]['title'] ?? '';
    } else {
      $link_uri = '';
      $link_title = '';
    }

    $items = [
      'title' => $title,
      'highlight' => $highlight,
      'description' => $description,
      'link_uri' => $link_uri,
      'link_title' => $link_title,
    ];

    return [
      '#theme' => 'looking_digital_service',
      '#items' => $items,
      '#cache' => [
        'tags' => $config_page ? $config_page->getCacheTags() : [],
        'contexts' => ['languages'],
      ],

    ];
  }
}
