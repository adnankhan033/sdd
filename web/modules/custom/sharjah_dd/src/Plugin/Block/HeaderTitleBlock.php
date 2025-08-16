<?php

declare(strict_types=1);

namespace Drupal\sharjah_dd\Plugin\Block;

use Drupal\config_pages\Entity\ConfigPages;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Routing\RouteObjectInterface;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\file\FileInterface;

/**
 * Provides a header title block.
 *
 * @Block(
 *   id = "sharjah_dd_header_title",
 *   admin_label = @Translation("Header Title"),
 *   category = @Translation("sharjah_dd"),
 * )
 */
final class HeaderTitleBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  /**
   * Constructs the plugin instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly RouteMatchInterface $routeMatch,
    private readonly EntityTypeManagerInterface $entityTypeManager,
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
      $container->get('current_route_match'),
      $container->get('entity_type.manager')
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

    $routeName = $this->routeMatch->getRouteName();
    // dd($routeName);
    $title = '';
    $request = \Drupal::request();
    if ($route = $request->attributes->get(RouteObjectInterface::ROUTE_OBJECT)) {
      $title = \Drupal::service('title_resolver')->getTitle($request, $route);
    }
    $image = '';
    $type = '';
    $bundle = '';
    $shared_title = '';
    $shared_link = '';
    $cacheTags = ['config_pages:general_pages'];
    $mapping = [
      'view.leadership_message.about_list' => [
        'title' => 'field_featured_solutions',
        'image' => 'field_leadership_banner',
        'type' => 'leadership_message',
      ],
      'view.services.main_page' => [
        'title' => 'field_featured_solutions',
        'image' => 'field_leadership_banner',
        'type' => 'services',
      ],
      'view.faqs.list' => [
        'title' => 'field_featured_solutions',
        'image' => 'field_leadership_banner',
        'type' => 'faqs',
      ],
      // initiatives
      'view.initiatives.grid' => [
        'title' => 'field_featured_solutions',
        'image' => 'field_leadership_banner',
        'type' => 'initiatives',
      ],

      // publications_reports
      'view.publications_reports.grid' => [
        'title' => 'field_featured_solutions',
        'image' => 'field_leadership_banner',
        'type' => 'publications_reports',
      ],
      // regulations
      'view.regulations.grid' => [
        'title' => 'field_featured_solutions',
        'image' => 'field_leadership_banner',
        'type' => 'regulations',
      ],
      // news main_page
      'view.news.main_page' => [
        'title' => 'field_featured_solutions',
        'image' => 'field_leadership_banner',
        'type' => 'news',
      ],
      //  "entity.webform.canonical"
      'entity.webform.canonical' => [
        'title' => 'field_webform_title',
        'image' => 'field_contact_header_banner',
        'type' => 'webform',
      ],
      // multimedia_gallery
      'view.media_images.page_grid' => [
        'title' => 'field_featured_solutions',
        'image' => 'field_multimedia_gallery_banner',
        'type' => 'multimedia_gallery',
      ],
    ];

    if ($routeName === 'entity.node.canonical') {
      $node = $this->routeMatch->getParameter('node');
      $title = $node->getTitle();
      $bundle = $node->bundle();
      $type = 'node';

      switch ($node->bundle()) {
        case 'about':
          $image_uri = $node->get('field_banner')->entity?->getFileUri() ?? '';
          $image = $image_uri ? ImageStyle::load('wide')->buildUrl($image_uri) : '';
          $type = 'node:about';
          break;
          
          case 'initiatives':
            $shared_title = $node->label();
            $shared_link = $node->toUrl('canonical', ['absolute' => TRUE])->toString();
            $type = 'node:initiatives';
            break;
          
        case 'our_strategy':
          $image_uri = $node->get('field_banner')->entity?->getFileUri() ?? '';
          $image = $image_uri ? ImageStyle::load('wide')->buildUrl($image_uri) : '';
          $type = 'node:our_strategy';
          break;
        case 'custom_page':
          $image_uri = $node->get('field_banner')->entity?->getFileUri() ?? '';
          $image = $image_uri ? ImageStyle::load('wide')->buildUrl($image_uri) : '';
          $type = 'node:custom_page';
          break;
          

      }

      $cacheTags = array_merge($cacheTags, $node->getCacheTags());
    }


    /** @var \Drupal\config_pages\Entity\ConfigPages $config_page */
    if (isset($mapping[$routeName]) && $config_page) {
      $map = $mapping[$routeName];

      // Optional: override title from config if provided in the map.
      if (!empty($map['title']) && $config_page->hasField($map['title'])) {
        $t_items = $config_page->get($map['title']);
        if ($t_items instanceof FieldItemListInterface && !$t_items->isEmpty()) {
          $title = (string) ($t_items->first()->get('value')->getValue() ?? $title);
        }
      }

      // Resolve banner image from config (supports Image field or Media(Image)).
      if (!empty($map['image']) && $config_page->hasField($map['image'])) {
        $items = $config_page->get($map['image']);
        if ($items instanceof FieldItemListInterface && !$items->isEmpty()) {
          $fileUri = '';

          // Detect field target type from definition.
          $def = $config_page->getFieldDefinition($map['image']);
          $targetType = $def->getSetting('target_type') ?? '';
          $fieldType  = $def->getType();

          if ($targetType === 'media') {
            // Media reference -> get image file from media source field.
            $media = $items->entity;
            if ($media) {
              $source = $media->getSource();
              $srcField = $source->getSourceFieldDefinition($media->bundle())->getName();
              /** @var \Drupal\file\FileInterface|null $file */
              $file = $media->get($srcField)->entity;
              if ($file instanceof FileInterface) {
                $fileUri = $file->getFileUri();
                $cacheTags = array_merge($cacheTags, $file->getCacheTags());
              }
            }
          } elseif ($fieldType === 'image' || $targetType === 'file') {
            // Image field (file) -> first item’s file entity.
            /** @var \Drupal\file\FileInterface|null $file */
            $file = $items->first()->entity;
            if ($file instanceof FileInterface) {
              $fileUri = $file->getFileUri();
              $cacheTags = array_merge($cacheTags, $file->getCacheTags());
            }
          }

          // Build final URL (use an image style if you want).
          if ($fileUri) {
            $style = ImageStyle::load('wide'); // change if needed
            $image = $style ? $style->buildUrl($fileUri)
              : \Drupal::service('file_url_generator')->generateAbsoluteString($fileUri);
          }
        }
      }

      // Optional type from mapping.
      if (!empty($map['type'])) {
        $type = $map['type'];
      }

      // Add config page cache tags.
      $cacheTags = array_merge($cacheTags, $config_page->getCacheTags());
    }

    $items = [
      'title' => $title,
      'image' => $image,
      'type' => $type,
      'bundle' => $bundle,
      'shared_title' => $shared_title ?? '',
      'shared_link' => $shared_link ?? '',
    ];
    
    $build = [
      '#theme' => 'header_title_block',
      '#items' => $items,
      '#cache' => [
        'contexts' => ['route'],
        'tags' => $cacheTags,
      ],
    ];
    return $build;
  }
}
