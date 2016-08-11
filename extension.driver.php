<?php

	Class extension_lang_croatian extends Extension {
		
		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#getSubscribedDelegates
		 */
		public function getSubscribedDelegates(){
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'Save',
					'callback' => '__toggleCroatian'
				)
			);
		}
		
		/**
		 * Toggle between Croatian and default date and time settings
		 */
		public function __toggleCroatian($context) {
			
			// Set German date and time settings
			if($context['settings']['symphony']['lang'] == 'hr') {
				$this->__setCroatian();
			}
			
			// Restore default date and time settings
			else {
				$this->__unsetCroatian();
			}
		}
		
		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#install
		 */
		public function install() {
		
			// Fetch current date and time settings
			$date = Symphony::Configuration()->get('date_format', 'region');
			$time = Symphony::Configuration()->get('time_format', 'region');
			$separator = Symphony::Configuration()->get('datetime_separator', 'region');
			
			// Store current date and time settings
			Symphony::Configuration()->set('date_format', $date, 'lang-croatian-storage');
			Symphony::Configuration()->set('time_format', $time, 'lang-croatian-storage');
			Symphony::Configuration()->set('datetime_separator', $separator, 'lang-croatian-storage');
			Symphony::Configuration()->write();
		}

		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#enable
		 */
		public function enable(){
			if(Symphony::Configuration()->get('lang', 'symphony') == 'hr') {
				$this->__setCroatian();
			}
		}

		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#disable
		 */
		public function disable(){
			$this->__unsetCroatian();
		}

		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#uninstall
		 */
		public function uninstall() {
			$this->__unsetCroatian();

			// Remove storage
			Symphony::Configuration()->remove('lang-croatian-storage');
			Symphony::Configuration()->write();
		}
		
		/**
		 * Set Croatian date and time format
		 */
		private function __setCroatian() {
		
			// Set Croatian date and time settings
			Symphony::Configuration()->set('date_format', 'd. F Y', 'region');
			Symphony::Configuration()->set('time_format', 'H:i', 'region');
			Symphony::Configuration()->set('datetime_separator', ', ', 'region');			
			Symphony::Configuration()->write();
		}
		
		/**
		 * Reset default date and time format
		 */
		private function __unsetCroatian() {
		
			// Fetch current date and time settings
			$date = Symphony::Configuration()->get('date_format', 'lang-croatian-storage');
			$time = Symphony::Configuration()->get('time_format', 'lang-croatian-storage');
			$separator = Symphony::Configuration()->get('datetime_separator', 'lang-croatian-storage');	
			
			// Store new date and time settings
			Symphony::Configuration()->set('date_format', $date, 'region');
			Symphony::Configuration()->set('time_format', $time, 'region');
			Symphony::Configuration()->set('datetime_separator', $separator, 'region');
			Symphony::Configuration()->write();
		}

	}
	
