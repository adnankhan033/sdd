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
 * Provides a Performance Highlights block.
 *
 * @Block(
 *   id = "performance_highlights",
 *   admin_label = @Translation("Performance Highlights Block"),
 *   category = @Translation("sharjah_dd"),
 * )
 */
final class PerformanceHighlightsBlock extends BlockBase implements ContainerFactoryPluginInterface
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
    
    $highlight = $config_page->get('field_ph_highlight')->value ?? '';
    $title = $config_page->get('field_ph_title')->value ?? '';
    $description = $config_page->get('field_ph_description')->value ?? '';
    $supporting_govt = $config_page->get('field_supporting_government')->value ?? '';
    $featured_solutions = $config_page->get('field_featured_solutions')->value ?? '';
    $serving_sharjah = $config_page->get('field_serving_sharjah')->value ?? '';
    $our_datacenter = $config_page->get('field_our_datacenter')->value ?? '';
    
    $items = [
      'highlight' => $highlight,
      'title' => $title,
      'description' => $description,
      'supporting_govt' => $supporting_govt,
      'featured_solutions' => $featured_solutions,
      'serving_sharjah' => $serving_sharjah,
      'our_datacenter' => $our_datacenter,
    ];
  
    return [
      '#theme' => 'performance_highlights',
      '#items' => $items,
      '#cache' => [
        'tags' => $config_page ? $config_page->getCacheTags() : [],
        'contexts' => ['languages'],
      ],

    ];
 
  }
}
