package com.webtako.flash {
	import flash.external.ExternalInterface;
		
	public class FlashUtil {
		public function FlashUtil() {}
		
		public static function extractPageName(hrefString:String):String {
			if (isNullEmptyString(hrefString)) {
				return null;
			}
			
			var arr:Array = hrefString.split('/');
			if (arr.length < 2) {
				return hrefString 
			}
			
			var val:String = "";
			
			for (var i:uint = 0; i < arr.length; i++) {
				val += arr[i].toLowerCase();				
			}
			return val;
		}

		public static function getCurrentPath():String {
			var path:String = null;
			try {
				path = ExternalInterface.call("window.location.pathname.toString");
			}
			catch (e:Error) {
				trace("javascript disabled!");
			}
			return path;
		}
		
		public static function getStringParam(param:String, defaultValue:String):String {
			if (!isNullEmptyString(param)) {
				return param;
			}
			return defaultValue;
		}
		
		public static function getBooleanParam(param:String, defaultValue:Boolean):Boolean {
			if (!isNullEmptyString(param)) {
				if (param == "true") {
					return true;
				}
				else if (param == "false") {
					return false;
				} 
			}
			return defaultValue;	
		}
		
		public static function getNumberParam(param:String, defaultValue:Number):Number {
			if (!isNullEmptyString(param) && !isNaN(Number(param))) {
				return Number(param);
			}
			return defaultValue;
		}
		
		public static function getUintParam(param:String, defaultValue:uint):uint {
			if (!isNullEmptyString(param) && !isNaN(uint(param))) {
				return uint(param);
			}
			return defaultValue;
		}
		
		public static function isNullEmptyString(str:String):Boolean {
			if (str == null || str.length == 0) {
				return true;
			}
			return false;
		}
		
		public static function isPostiveNumber(num:Number):Boolean {
			return (num > 0) ? true : false;
		}
		
		public static function isNonnegativeNumber(num:Number):Boolean {
			return (num >= 0) ? true : false;
		}
		
		public static function isNegativeNumber(num:Number):Boolean {
			return (num < 0) ? true : false;
		}
		
		public static function withinNumberRange(num:Number, min, max):Boolean {
			if (num >= min && num <= max) {
				return true;
			}
			return false;
		}
	}
}