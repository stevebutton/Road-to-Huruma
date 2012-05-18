package com.webtako.flash {	
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.IOErrorEvent;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	
	public class TabMenu extends Sprite {	
		public static const XML_LOADED:String = "xmlLoaded";
		
		private var _autoSelect:Boolean;					
		private var _currentPage:String;
		private var _selectedTab:MenuWrapper;
		private var _selectedMenuItem:MenuItem;
		
		public function TabMenu(xmlPath:String = "menu.xml"):void {
			//disable until xml is read
			this.alpha = 0;
			
			//get current path of html page if available for auto select
			var path:String = FlashUtil.getCurrentPath();
			this.currentPage = FlashUtil.extractPageName(path);
			
			//load xml data file
			var loader:URLLoader = new URLLoader(); 
			loader.addEventListener(IOErrorEvent.IO_ERROR, displayIOError);
			loader.addEventListener(Event.COMPLETE, processXML); 
			loader.load(new URLRequest(xmlPath)); 
		}
		
		private function processXML(event:Event):void {
			var loader:URLLoader = URLLoader(event.currentTarget);
			var xmlData:XML = new XML(loader.data);
			
			//init global parameters from xml file			
			var textSize:Number  = 		 FlashUtil.getNumberParam(xmlData.@textSize, 12);
			var textColor:uint = 		 FlashUtil.getUintParam(xmlData.@textColor, 0x000000); 
			var hoverTextColor:uint = 	 FlashUtil.getUintParam(xmlData.@hoverTextColor, 0x0066FF); 
			var selectedTextColor:uint = FlashUtil.getUintParam(xmlData.@selectedTextColor, 0xFF0000);
			
			var borderColor:uint = 	     FlashUtil.getUintParam(xmlData.@borderColor, 0x999999);
			var bgColor:uint  = 		 FlashUtil.getUintParam(xmlData.@bgColor, 0xFFFFFF);
			var gradientColor:uint = 	 FlashUtil.getUintParam(xmlData.@gradientColor, bgColor);
			
			var tabOffset:Number = 		 FlashUtil.getNumberParam(xmlData.@tabOffset, 0);
			var tabGap:Number = 		 FlashUtil.getNumberParam(xmlData.@tabGap, 2);							
			var menuWidth:Number = 		 FlashUtil.getNumberParam(xmlData.@width, 600);
			var level1Height:Number = 	 FlashUtil.getNumberParam(xmlData.@level1Height, 30);
			var level2Height:Number = 	 FlashUtil.getNumberParam(xmlData.@level2Height, 35);					
			
			var fadeSubmenu:Boolean = 	 FlashUtil.getBooleanParam(xmlData.@fadeSubmenu, true);
			var darkenBackMenu:Boolean = FlashUtil.getBooleanParam(xmlData.@darkenBackMenu, false);
			var borderOn:Boolean =		 FlashUtil.getBooleanParam(xmlData.@borderOn, true);
			
			var linkTarget:String =		 FlashUtil.getStringParam(xmlData.@target, "_self");
			var tabType:String =	 	 FlashUtil.getStringParam(xmlData.@tabType, MenuWrapper.ROUND_TAB);
			this.autoSelect = 	 		 FlashUtil.getBooleanParam(xmlData.@autoSelect, true);
			
			if (FlashUtil.isNegativeNumber(tabOffset)) {
				tabOffset = 0;	
			}	
					
			if (!FlashUtil.withinNumberRange(level1Height, 30, 50)) {
				level1Height = 30;
			}			
			if (!FlashUtil.withinNumberRange(level2Height, 30, 50)) {
				level2Height = 35;
			}			
			var menuHeight:Number = level1Height + level2Height;
			
			var filterXML:XMLList = xmlData.tabfilter;	
			var filter:Boolean = 		   FlashUtil.getBooleanParam(filterXML.@on, false);
			var filterTextColor:uint =     FlashUtil.getUintParam(filterXML.@textColor, textColor);  
			var filterBgColor:uint =   	   FlashUtil.getUintParam(filterXML.@bgColor, bgColor);
			var filterGradientColor:uint = FlashUtil.getUintParam(filterXML.@gradientColor, filterBgColor);
			var filterBorderColor:uint=    FlashUtil.getUintParam(filterXML.@borderColor, borderColor);
		
			//init each tab panel for menu
			var menuWrappers:Array = new Array();
			for each (var tab:XML in xmlData.tab) {
				//init tab panel's parameters from xml file
				var tabTextColor:uint = 		 FlashUtil.getUintParam(tab.@textColor, textColor);
				var tabHoverTextColor:uint = 	 FlashUtil.getUintParam(tab.@hoverTextColor, hoverTextColor);					
				var tabSelectedTextColor:uint =  FlashUtil.getUintParam(tab.@selectedTextColor, selectedTextColor);						
				var tabBorderColor:uint = 		 FlashUtil.getUintParam(tab.@borderColor, borderColor);								
				var tabBgColor:uint  = 			 FlashUtil.getUintParam(tab.@bgColor, bgColor);
				var tabGradientColor:uint = 	 FlashUtil.getUintParam(tab.@gradientColor, gradientColor);					
				var submenuAlign:String = FlashUtil.getStringParam(tab.@submenuAlign, MenuWrapper.LEFT_ALIGN);
			
				//init tab menu items parameters from xml file
				var item:XMLList = tab.menuitem;
				var itemLabel:String = 	item.@label;
				var itemLink:String  = 	item.@link;
				var itemTarget:String = FlashUtil.getStringParam(item.@target, linkTarget);
				var itemMode:String = 	FlashUtil.getStringParam(item.@mode, MenuItem.LINK_MODE);					
				var itemWidth:Number  = FlashUtil.getNumberParam(item.@width, 0);
				
				var itemTextColor:uint = 		 FlashUtil.getUintParam(item.@textColor, tabTextColor);
				var itemHoverTextColor:uint = 	 FlashUtil.getUintParam(item.@hoverTextColor, tabHoverTextColor);					
				var itemSelectedColor:uint = 	 FlashUtil.getUintParam(item.@selectedTextColor, tabSelectedTextColor);	
				
				//init menu item
				var menuItem:MenuItem = new MenuItem(this, itemLabel, itemLink, itemTarget, 
													textSize, itemWidth, level1Height, 
													itemTextColor, itemHoverTextColor, itemSelectedColor, filterTextColor,
													itemMode);						
				menuItem.x = tabOffset;
				menuItem.y = 0;
				tabOffset += (menuItem.width + tabGap);				
				
				//init submenu items
				var submenuItems:Array = new Array();
				for each (var subitem:XML in tab.submenuitem) {
					var subLabel:String = 	subitem.@label;
					var subLink:String  = 	subitem.@link;
					var subTarget:String = 	FlashUtil.getStringParam(subitem.@target, itemTarget);
					var subWidth:Number  = 	FlashUtil.getNumberParam(subitem.@width, 0);
					var subMode:String = 	FlashUtil.getStringParam(subitem.@mode, MenuItem.LINK_MODE);	
					
					var subTextColor:uint = 		 FlashUtil.getUintParam(subitem.@textColor, tabTextColor);
					var subHoverTextColor:uint = 	 FlashUtil.getUintParam(subitem.@hoverTextColor, tabHoverTextColor);					
					var subSelectedColor:uint = 	 FlashUtil.getUintParam(subitem.@selectedTextColor, tabSelectedTextColor);	
					
					var subMenuItem:MenuItem = new MenuItem(this, subLabel, subLink, subTarget, 
															textSize, subWidth, level2Height, 
															subTextColor, subHoverTextColor, subSelectedColor, filterTextColor,
															subMode);			
					submenuItems.push(subMenuItem);
				}		
					
				//init menu wrapper
				var menuWrapper:MenuWrapper = new MenuWrapper(this, menuItem, submenuItems, 
																tabBgColor, tabGradientColor, tabBorderColor, 
																filter, filterBgColor, filterGradientColor, filterBorderColor, 
																menuWidth, menuHeight, submenuAlign, 
																fadeSubmenu, darkenBackMenu, borderOn, tabType);	
				menuWrappers.push(menuWrapper);
				menuItem.tab = menuWrapper;				
				
				if (menuItem.x + menuItem.width <= menuWidth) {
					this.addChild(menuWrapper);						
				}
			} 			
			
			//set first menu wrapper as selected if none exist, else enable selected menu
			if (this.selectedTab == null && menuWrappers.length > 0) {
				MenuWrapper(menuWrappers[0]).focus();
			}			
			else {
				this.selectedTab.focus();
			}
			
			this.alpha = 1;
			loader.close();
			loader = null;
			
			dispatchEvent(new Event(XML_LOADED));
		}			
		
		public function getExternalFrame(name:String):Sprite {
			try {
				var displaySprite:Sprite = Sprite(this.parent.getChildByName(name));
				return displaySprite;
			}
			catch (e:Error) {
				trace(e);				
			}
			return null;
		}
		
		public function get selectedTab():MenuWrapper {
			return this._selectedTab;	
		}
		
		public function set selectedTab(tab:MenuWrapper):void {
			this._selectedTab = tab;
		}
		
		public function get selectedMenuItem():MenuItem {
			return this._selectedMenuItem;	
		}
		
		public function set selectedMenuItem(menuItem:MenuItem):void {
			this._selectedMenuItem = menuItem;
		}

		public function get currentPage():String {
			return this._currentPage;
		}
		
		public function set currentPage(page:String):void {
			this._currentPage = page;	
		}
		
		public function get autoSelect():Boolean {
			return this._autoSelect;	
		}
		
		public function set autoSelect(autoSelect:Boolean):void {
			this._autoSelect = autoSelect;
		}
		
		private function displayIOError(event:IOErrorEvent):void {
			trace("IO Error");
		}
	}
}