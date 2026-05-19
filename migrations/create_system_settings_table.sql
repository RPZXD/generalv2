-- Create system_settings table
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(255) NOT NULL UNIQUE,
  `setting_value` TEXT DEFAULT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert initial configurations
INSERT INTO `system_settings` (`setting_key`, `setting_value`, `description`) VALUES
('room_line_token', '3K7fh1bhbCn0uPjgNoGQpN3jNgpwpSoMA0QaE6m4dOMJkly+SeGyDyS73+EV6wSVuLoB6M/+FwdbxRWlY6ZGuQymNTYSrFzA5xQ7AhwlwOufu+et60PnAnYK2vpyvUyy3ye0yBe7cTu+PoiFDxsmmgdB04t89/1O/w1cDnyilFU=', 'LINE Channel Access Token for Room Booking'),
('room_group_id', 'Cafbcad04d9e78bbee85b2447ee768baf', 'LINE Group ID for Room Booking'),
('room_discord_webhook', 'https://discord.com/api/webhooks/1324990236822241300/lZk9s-t-l324_uD6s-kK4v-lZk9s-t-l324_uD6s-kK4v', 'Discord Webhook URL for Room Booking'),
('car_discord_webhook', 'https://discord.com/api/webhooks/1392375583215714334/DBG1syD7eINQWBEYXhcOf2ctFh0Qo71N51V2jkZ9g-Lx4DKFZHy3S_w4FcWbyRf1B0xe', 'Discord Webhook URL for Car Booking'),
('car_line_token', '', 'LINE Notify Token for Car Booking'),
('telegram_bot_token', '8651480824:AAFrSmCpnfqjMd6BskpKmv-3vZyVpRk4Zrg', 'Telegram Bot Token'),
('telegram_chat_id', '', 'Telegram Chat ID for Car Booking'),
('telegram_repair_chat_id', '-1003940681082', 'Telegram Chat ID for Repair Request'),
('telegram_driver_chat_id', '', 'Telegram Chat ID for Driver Group'),
('repair_discord_webhook', 'https://discord.com/api/webhooks/1392374493686665226/_Sl9fYw2L193asCqZpxyJkw7ApioLhrPBlmImGwFvTY_L6I-kfvzK93W6yJqicbmlF09', 'Discord Webhook URL for Repair Request'),
('driver_discord_webhook', '', 'Discord Webhook URL for Driver Group'),
('driver_line_token', '', 'LINE Notify Token for Driver Group')
ON DUPLICATE KEY UPDATE 
  `setting_value` = VALUES(`setting_value`),
  `description` = VALUES(`description`);
