-- Migration: Add letter column to m_loc table
-- Date: 2025-09-03
-- Description: Adds boolean letter field to m_loc and tmp_mloc tables

-- Add letter column to m_loc table if it doesn't exist
ALTER TABLE `m_loc` 
ADD COLUMN IF NOT EXISTS `letter` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Letter flag: 0 = No, 1 = Yes (Boolean field)' 
AFTER `returnDate`;

-- Add letter column to tmp_mloc table if it doesn't exist  
ALTER TABLE `tmp_mloc` 
ADD COLUMN IF NOT EXISTS `letter` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Letter flag: 0 = No, 1 = Yes (Boolean field)' 
AFTER `returnDate`;

-- Update existing data with sample letter values (optional)
-- This is just for demo purposes - you can remove this section if not needed
UPDATE `m_loc` SET `letter` = 0 WHERE `id` IN (1, 3, 5, 7, 9, 16, 18, 20, 22, 24);
UPDATE `m_loc` SET `letter` = 1 WHERE `id` IN (2, 4, 6, 8, 10, 17, 19, 21, 23, 25);