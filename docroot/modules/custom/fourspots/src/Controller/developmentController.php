<?php

namespace Drupal\fourspots\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\fourspots\Entity\developmentInterface;

/**
 * Class developmentController.
 *
 *  Returns responses for Development routes.
 */
class developmentController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Development  revision.
   *
   * @param int $development_revision
   *   The Development  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($development_revision) {
    $development = $this->entityManager()->getStorage('development')->loadRevision($development_revision);
    $view_builder = $this->entityManager()->getViewBuilder('development');

    return $view_builder->view($development);
  }

  /**
   * Page title callback for a Development  revision.
   *
   * @param int $development_revision
   *   The Development  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($development_revision) {
    $development = $this->entityManager()->getStorage('development')->loadRevision($development_revision);
    return $this->t('Revision of %title from %date', ['%title' => $development->label(), '%date' => format_date($development->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Development .
   *
   * @param \Drupal\fourspots\Entity\developmentInterface $development
   *   A Development  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(developmentInterface $development) {
    $account = $this->currentUser();
    $langcode = $development->language()->getId();
    $langname = $development->language()->getName();
    $languages = $development->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $development_storage = $this->entityManager()->getStorage('development');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $development->label()]) : $this->t('Revisions for %title', ['%title' => $development->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all development revisions") || $account->hasPermission('administer development entities')));
    $delete_permission = (($account->hasPermission("delete all development revisions") || $account->hasPermission('administer development entities')));

    $rows = [];

    $vids = $development_storage->revisionIds($development);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\fourspots\developmentInterface $revision */
      $revision = $development_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $development->getRevisionId()) {
          $link = $this->l($date, new Url('entity.development.revision', ['development' => $development->id(), 'development_revision' => $vid]));
        }
        else {
          $link = $development->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.development.translation_revert', ['development' => $development->id(), 'development_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.development.revision_revert', ['development' => $development->id(), 'development_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.development.revision_delete', ['development' => $development->id(), 'development_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['development_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
