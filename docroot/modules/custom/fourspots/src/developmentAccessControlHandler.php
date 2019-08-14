<?php

namespace Drupal\fourspots;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Development entity.
 *
 * @see \Drupal\fourspots\Entity\development.
 */
class developmentAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\fourspots\Entity\developmentInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished development entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published development entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit development entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete development entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add development entities');
  }

}
