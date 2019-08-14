<?php

namespace Drupal\fourspots;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\fourspots\Entity\developmentInterface;

/**
 * Defines the storage handler class for Development entities.
 *
 * This extends the base storage class, adding required special handling for
 * Development entities.
 *
 * @ingroup fourspots
 */
interface developmentStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Development revision IDs for a specific Development.
   *
   * @param \Drupal\fourspots\Entity\developmentInterface $entity
   *   The Development entity.
   *
   * @return int[]
   *   Development revision IDs (in ascending order).
   */
  public function revisionIds(developmentInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Development author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Development revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\fourspots\Entity\developmentInterface $entity
   *   The Development entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(developmentInterface $entity);

  /**
   * Unsets the language for all Development with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
