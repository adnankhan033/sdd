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
 * Provides a footer block.
 *
 * @Block(
 *   id = "footer_block",
 *   admin_label = @Translation("Footer"),
 *   category = @Translation("sharjah_dd"),
 * )
 */
final class FooterBlock extends BlockBase implements ContainerFactoryPluginInterface
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
    // $address = $config_page->get('field_footer_address')->value ?? '';
    // $details = $config_page->get('field_footer_details')->value ?? '';
    // $duty_timing = $config_page->get('field_footer_duty_timing')->value ?? '';
    // $email = $config_page->get('field_footer_email')->value ?? '';
    // $highlight = $config_page->get('field_fact_highlight')->value ?? '';
    // $instagram = $config_page->get('field_instagram_link')->value ?? '';
    // $linkedin = $config_page->get('field_linkedin_link')->value ?? '';
    // $twitter = $config_page->get('field_twitter_link')->value ?? '';
    // $website_link = $config_page->get('field_website_link')->value ?? '';
    // $facebook = $config_page->get('field_facebook_link')->value ?? '';
    
    
    $items = [
      'address' => $address,
      'details' => $details,    
      'duty_timing' => $duty_timing,    
      'email' => $email,    
      'highlight' => $highlight,    
      'instagram' => $instagram,    
      'linkedin' => $linkedin,    
      'twitter' => $twitter,    
      'website_link' => $website_link,    
      'facebook' => $facebook,    
    ];

    return [
      '#theme' => 'footer',
      '#items' => $items,
      '#cache' => [
        'tags' => $config_page ? $config_page->getCacheTags() : [],
        'contexts' => ['languages'],
      ],

    ];
  }
}
