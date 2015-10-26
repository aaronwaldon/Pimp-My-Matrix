<?php
namespace Craft;

/**
 * Pimp My Matrix by Supercool
 *
 * @package   PimpMyMatrix
 * @author    Josh Angell
 * @copyright Copyright (c) 2015, Supercool Ltd
 * @link      http://www.supercooldesign.co.uk
 */

class PimpMyMatrixPlugin extends BasePlugin
{

  public function getName()
  {
    return Craft::t('Pimp My Matrix');
  }

  public function getVersion()
  {
    return '1.3.2';
  }

  public function getDeveloper()
  {
    return 'Supercool';
  }

  public function getDeveloperUrl()
  {
    return 'http://plugins.supercooldesign.co.uk';
  }

  public function hasCpSection()
  {
    return true;
  }

  public function registerCpRoutes()
  {
    return array(
      // Edit Global Context
      'pimpmymatrix' => array('action' => 'pimpMyMatrix/editGlobalContext'),
    );
  }

  public function init()
  {

    // Check the conditions are right to run
    if ( craft()->request->isCpRequest() && craft()->userSession->isLoggedIn() && !craft()->request->isAjaxRequest() )
    {

      $segments = craft()->request->getSegments();

      /**
       * Work out the context for the block type groups configuration
       */
      // Entry types
      if ( count($segments) == 5
           && $segments[0] == 'settings'
           && $segments[1] == 'sections'
           && $segments[3] == 'entrytypes'
           && $segments[4] != 'new'
         )
      {
        craft()->pimpMyMatrix->loadConfigurator('#fieldlayoutform', 'entrytype:'.$segments[4]);
      }

      // Category groups
      if ( count($segments) == 3
           && $segments[0] == 'settings'
           && $segments[1] == 'categories'
           && $segments[2] != 'new'
         )
      {
        craft()->pimpMyMatrix->loadConfigurator('#fieldlayoutform', 'categorygroup:'.$segments[2]);
      }

      // Global sets
      if ( count($segments) == 3
           && $segments[0] == 'settings'
           && $segments[1] == 'globals'
           && $segments[2] != 'new'
         )
      {
        craft()->pimpMyMatrix->loadConfigurator('#fieldlayoutform', 'globalset:'.$segments[2]);
      }

      // Users
      if ( count($segments) == 3
           && $segments[0] == 'settings'
           && $segments[1] == 'users'
           && $segments[2] == 'fields'
         )
      {
        craft()->pimpMyMatrix->loadConfigurator('#fieldlayoutform', 'users');
      }

      /**
       * Work out the context for the Matrix field manipulation
       */
      // Global
      $context = 'global';

      // Entry types
      if ( count($segments) == 3 && $segments[0] == 'entries' )
      {

        if ($segments[2] == 'new')
        {
          $section = craft()->sections->getSectionByHandle($segments[1]);
          $sectionEntryTypes = $section->getEntryTypes();
          $entryType = ArrayHelper::getFirstValue($sectionEntryTypes);
        }
        else
        {
          $entryId = explode('-',$segments[2])[0];
          $entry = craft()->entries->getEntryById($entryId);

          if ($entry)
          {
            $entryType = $entry->type;
          }
        }

        $context = 'entrytype:'.$entryType->id;

      }
      // Category groups
      else if ( count($segments) == 3 && $segments[0] == 'categories' )
      {
        $group = craft()->categories->getGroupByHandle($segments[1]);
        if ($group)
        {
          $context = 'categorygroup:'.$group->id;
        }
      }
      // Global sets
      else if ( count($segments) == 2 && $segments[0] == 'globals' )
      {
        $set = craft()->globals->getSetByHandle($segments[1]);
        if ($set)
        {
          $context = 'globalset:'.$set->id;
        }
      }
      // Users
      else if ( (count($segments) == 1 && $segments[0] == 'myaccount') || (count($segments) == 2 && $segments[0] == 'users') )
      {
        $context = 'users';
      }

      // Run the field manipulation code
      craft()->pimpMyMatrix->loadFieldManipulator($context);

    }

  }

}
