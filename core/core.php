<?php
namespace VSamPlugin\Core;
use VSamPlugin\Front;
use VSamPlugin\Admin;

/**
 * Файл, определяющий класс основного плагина
 *
 * Определение класса, которое включает атрибуты и функции, 
 * используемые как для публичной стороны сайта, 
 * так и для области администрирования.
 * 
 * Это используется для определения интернационализации, 
 * хуков, специфичных для администратора, 
 * а также для привязок к сайтам с открытым доступом.
 * 
 * Таким образом, уникальный идентификатор этого плагина является текущей версией плагина.
 * 
 */

class Core {

	/**
	 * Загрузчик, который отвечает за сохранение 
   * и регистрацию всех хуков, которые подключает плагин.
	 */
	protected $loader;

	/**
	 * Уникальный идентификатор этого плагина
	 *
	 */
	protected $plugin_name;

	/**
	 * Текущая версия плагина.
	 */
	protected $version;

	/**
	 * Определние основных функции плагина
	 *
	 * Задаем имя и версию плагина - они будут использоваться везде
	 * Загружаем зависимости, определяем локаль, 
   * устанавливаем хуки для публичной и административной частей сайта
	 *
	 */


	public function __construct() {
		if ( defined( '\VSamPlugin\VERSION_MODULE' ) ) {
			$this->version = \VSamPlugin\VERSION_MODULE;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = \VSamPlugin\NAME_MODULE;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Loader. Управляет хуками плагина.
	 * - I18n. Определяет функциональность интернационализации.
	 * - AdminModule. Определяет все хуки для админ части
	 * - PublicModule. Определяет все хуки для публинной части.
	 *
	 * Создайте экземпляр загрузчика, который будет использоваться для регистрации хуков
	 * WordPress.
	 */
	private function load_dependencies() {
		# Класс, ответственный за организацию действий и фильтров
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'core/loader.php';
		# Класс, отвечающий за определение функциональности интернационализации
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'core/i18n.php';
		# определение всех действий, которые происходят в админке
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/admin-module.php';
		# определение всех действий, которые происходят в публичной части
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'front/front-module.php';
		$this->loader = new Loader();
	}

	/**
	 * Определите локаль для этого плагина для интернационализации
	 *
	 * Использует класс ModuleI18n для установки домена и регистрации хука
	 * with WordPress.
	 */
	private function set_locale() {
		$plugin_i18n = new I18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	# Register all of the hooks related to the admin area functionality
	private function define_admin_hooks() {
		$plugin_admin = new Admin\AdminModule( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	# Register all of the hooks related to the public-facing functionality
	private function define_public_hooks() {
		$plugin_public = new Front\FrontModule( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	# Run the loader to execute all of the hooks with WordPress.
	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	# The reference to the class that orchestrates the hooks with the plugin.
	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}