<?php
namespace Craft;

/**
 * Pimp My Matrix by Supercool
 *
 * @package   PimpMyMatrix
 * @author    Josh Angell
 * @copyright Copyright (c) 2014, Supercool Ltd
 * @link      http://www.supercooldesign.co.uk
 */

class PimpMyMatrix_BlockTypeLayoutRecord extends BaseRecord
{

	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc BaseRecord::getTableName()
	 *
	 * @return string
	 */
	public function getTableName()
	{
		return 'pimpmymatrix_blocktypelayouts';
	}


	/**
	 * @inheritDoc BaseRecord::defineRelations()
	 *
	 * @return array
	 */
	public function defineRelations()
	{
		return array(
			'matrixBlockType' => array(static::BELONGS_TO, 'MatrixBlockTypeRecord', 'required' => true, 'onDelete' => static::CASCADE),
		);
	}


	// Protected Methods
	// =========================================================================

	/**
	 * @inheritDoc BaseRecord::defineAttributes()
	 *
	 * @return array
	 */
	protected function defineAttributes()
	{
		return array(
			'tabName' => array(AttributeType::String, 'required' => true), // 'Content'
			'context' => array(AttributeType::String, 'required' => true), // 'entryType:23'
		);
	}

}
