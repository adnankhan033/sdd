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
 * Provides a about Block"), block.
 *
 * @Block(
 *   id = "about_block",
 *   admin_label = @Translation("About Block"),
 *   category = @Translation("sharjah_dd"),
 * )
 */
final class AboutBlock extends BlockBase implements ContainerFactoryPluginInterface
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
    $facebook = $config_page->get('field_facebook')->getValue()[0]['uri'] ?? '';
    $instagram = $config_page->get('field_instagram')->getValue()[0]['uri'] ?? '';
    $youtube = $config_page->get('field_youtube')->getValue()[0]['uri'] ?? '';
    $twitter = $config_page->get('field_twitter')->getValue()[0]['uri'] ?? '';
    $copy_right = $config_page->get('field_copyrights')->value?? '';
    
    //  $twitter1 = $config_page->get('field_twitter')->getValue()[0]['uri'] ?? '';

 
// dd( $copy_right); exit;
     $copy_right_text = '';
    if ($copy_right) {
      $copy_right_text = str_replace('[year]', date('Y'), $copy_right);
    }

    $items = [
      'facebook' => $facebook,    
      'instagram' => $instagram,    
      'youtube' => $youtube,    
      'twitter' => $twitter,    
      'copy_right'=> $copy_right_text,
      'about'=> 'about',
    ];
    
    return [
      '#theme' => 'about',
      '#items' => $items,
      '#cache' => [
        'tags' => $config_page ? $config_page->getCacheTags() : [],
        'contexts' => ['languages'],
      ],

    ];
  }
}
