<?php
namespace VSamPlugin\Setup;

class Deactivator {


	public static function deactivate() {
		self::del_scheduled_cron(); # Удаляю задание из крона - Граббинг по расписанию 
	}

	# Удаляю задание из крона - Граббинг по расписанию 
	public static function del_scheduled_cron() {
		$events_name = [
			\VSamPlugin\NAME_MODULE . '_parse_sourse_scheduled_cron',
			\VSamPlugin\NAME_MODULE . '_parse_news_scheduled_cron'
		];
		foreach ($events_name as $name) {
			wp_clear_scheduled_hook( $name );
		}
	}

}
