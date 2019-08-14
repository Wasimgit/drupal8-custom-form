<?php

namespace Drupal\fourspots\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Development entities.
 *
 * @ingroup fourspots
 */
interface developmentInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Development name.
   *
   * @return string
   *   Name of the Development.
   */
  public function getName();

  /**
   * Sets the Development name.
   *
   * @param string $name
   *   The Development name.
   *
   * @return \Drupal\fourspots\Entity\developmentInterface
   *   The called Development entity.
   */
  public function setName($name);

  /**
   * Gets the Development creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Development.
   */
  public function getCreatedTime();

  /**
   * Sets the Development creation timestamp.
   *
   * @param int $timestamp
   *   The Development creation timestamp.
   *
   * @return \Drupal\fourspots\Entity\developmentInterface
   *   The called Development entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Development published status indicator.
   *
   * Unpublished Development are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Development is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Development.
   *
   * @param bool $published
   *   TRUE to set this Development to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\fourspots\Entity\developmentInterface
   *   The called Development entity.
   */
  public function setPublished($published);

  /**
   * Gets the Development revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Development revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\fourspots\Entity\developmentInterface
   *   The called Development entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Development revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Development revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\fourspots\Entity\developmentInterface
   *   The called Development entity.
   */
  public function setRevisionUserId($uid);

}
