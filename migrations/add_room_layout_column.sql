-- Add room_layout column to bookings table
-- Run this migration to add the room layout feature

ALTER TABLE bookings
ADD COLUMN room_layout VARCHAR(50) DEFAULT 'none' AFTER media;

-- Optional: Update existing records to have default value
UPDATE bookings SET room_layout = 'none' WHERE room_layout IS NULL;
