<?php

namespace Drupal\fourspots;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class developmentStorage extends SqlContentEntityStorage implements developmentStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(developmentInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {development_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {development_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(developmentInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {development_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('development_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
