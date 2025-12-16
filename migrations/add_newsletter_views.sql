-- Migration: Add views column to newsletters table
ALTER TABLE newsletters ADD COLUMN IF NOT EXISTS views INT DEFAULT 0;
ALTER TABLE newsletters ADD COLUMN IF NOT EXISTS status ENUM('draft', 'published') DEFAULT 'published';
