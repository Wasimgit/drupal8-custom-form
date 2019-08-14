<?php

namespace Drupal\custom_breadcrumbs\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;

class CustomBreadcrumbsService implements BreadcrumbBuilderInterface{
   /**
    * {@inheritdoc}
    */
   public function applies(RouteMatchInterface $attributes) {
       $parameters = $attributes->getParameters()->all();
       if (!empty($parameters['node'])) {
           return $parameters['node']->getType() == 'article';
       }
   }

   /**
    * {@inheritdoc}
    */
   public function build(RouteMatchInterface $route_match) {
       $breadcrumb = new Breadcrumb();
       $breadcrumb->addLink(Link::createFromRoute('Home', ''));
       $breadcrumb->addLink(Link::createFromRoute('Article', '>>
'));
       //dump($breadcrumb);exit;
       return $breadcrumb;
   }

}
