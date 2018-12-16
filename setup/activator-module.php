<?php
namespace VSamPlugin\Setup;

class Activator {

	public static function activate() {
		self::add_scheduled_cron(); # Добовляем задачи в крон
	}

	/**
	 * Устанавливаю задание для крона
	 */
	public static function add_scheduled_cron() {
		$events_name = [
			\VSamPlugin\NAME_MODULE . '_parse_sourse_scheduled_cron',
			\VSamPlugin\NAME_MODULE . '_parse_news_scheduled_cron'
		];
		foreach ($events_name as $name) {
			# удалим такие же задачи cron
			# это может понадобиться, если до этого подключалась без проверки что она уже есть
			wp_clear_scheduled_hook( $name );

			# добовляем задачу
			wp_schedule_event( time(), 'hourly', $name);
		}
	}
}
