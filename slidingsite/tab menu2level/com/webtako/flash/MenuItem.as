package com.webtako.flash {	
	import caurina.transitions.Tweener;
	import caurina.transitions.properties.TextShortcuts;
	TextShortcuts.init();

	import flash.display.Sprite;
	import flash.display.Shape;
	import flash.events.MouseEvent;
	import flash.net.URLRequest;
	import flash.net.navigateToURL;
	import flash.text.AntiAliasType;
	import flash.text.Font;
	import flash.text.TextField;
	import flash.text.TextFieldAutoSize;
	import flash.text.TextFormat;
	import flash.display.Loader;

	public class MenuItem extends Sprite {	
		public static const LINK_MODE:String = "LINK";
		public static const SWF_MODE:String = "SWF";
		public static const FN_MODE:String = "FN";		
		public static const DEFAULT_FONT_SIZE:Number = 12;	
		public static const DEFAULT_PADDING:Number = 10;
		
		private static var menuFont:MenuFont = new MenuFont();		

		private var _menu:TabMenu;
		private var _tab:MenuWrapper;
		private var _labelText:TextField;		
		private var _link:String;
		private var _urlReq:URLRequest;
		private var _openTarget:String;	
		private var _textColor:uint; 
		private var _hoverTextColor:uint;
		private var _selectedTextColor:uint;
		private var _disabledTextColor:uint;
		private var _focus:Boolean; 
		
		public function MenuItem(menu:TabMenu, labelText:String, link:String, openTarget:String = "_self", 
									textSize:Number = DEFAULT_FONT_SIZE, menuWidth:Number = 0, menuHeight:Number = 30,									 
									textColor:uint = 0x000000, hoverTextColor:uint = 0x0066FF, selectedTextColor:uint = 0xFF0000, disabledTextColor:uint = 0x000000, 
									mode:String = LINK_MODE):void {															
			this._menu = menu;
			this._link = link;
			this._urlReq = new URLRequest(this._link);
			this._openTarget = openTarget;
			this._focus = true;			
			mode = mode.toUpperCase();
			//auto select menu item if current page matches menu item's link
			if (this._menu.autoSelect && mode == MenuItem.LINK_MODE) {
				this.autoSelectMenuItem();
			}
			
			//init text color
			this._textColor = textColor;
			this._hoverTextColor = hoverTextColor;
			this._selectedTextColor = selectedTextColor;
			this._disabledTextColor = disabledTextColor;

			//init text format 
			var textFormat:TextFormat = new TextFormat();
			textFormat.color = this.currentSelected ? this._selectedTextColor : this._textColor;	
			textFormat.font = menuFont.fontName;
			textFormat.size = FlashUtil.withinNumberRange(textSize, 10, 18) ? textSize : DEFAULT_FONT_SIZE;
			textFormat.bold = false;
			
			//init text field label
			this._labelText = new TextField();
			this._labelText.defaultTextFormat = textFormat;
			this._labelText.text = labelText;
			this._labelText.antiAliasType = flash.text.AntiAliasType.ADVANCED;
			this._labelText.autoSize =  TextFieldAutoSize.LEFT;		
			this._labelText.embedFonts = true;
			this._labelText.multiline = false;			
			this._labelText.wordWrap = false;			

			//init menu container
			if (menuWidth < 1) {	//auto size if size not specified 
				menuWidth = Math.round(this._labelText.width + (2 * DEFAULT_PADDING));
			}			
					
			this.graphics.beginFill(0xffffff, 0);
			this.graphics.drawRect(0, 0, menuWidth, menuHeight);
			this.graphics.endFill();		
			
			//adjust textfield's x and y 
			this._labelText.x = (this._labelText.width <= menuWidth) ? (menuWidth - this._labelText.width)/2 : 0;				
			this._labelText.y = (menuHeight - this._labelText.height)/2;
			
			//add label		
			this.addChild(this._labelText);
			
			//init mouse behavior			
			this.buttonMode = true;
			this.useHandCursor = true;	
			this.mouseChildren = false;
			this.addEventListener(MouseEvent.MOUSE_OVER, onMouseover);
			this.addEventListener(MouseEvent.MOUSE_OUT, onMouseout);

			if (!FlashUtil.isNullEmptyString(this._link)) {		
				if (mode == SWF_MODE) {
					this.addEventListener(MouseEvent.MOUSE_DOWN, openClip);
				}
				else {
					this.addEventListener(MouseEvent.MOUSE_DOWN, openLink);									
				}
			}	
			else {					
				this.addEventListener(MouseEvent.MOUSE_DOWN, openNone);
			}
		}
				
		public function onMouseover(event:MouseEvent):void {
			if (this._tab && !this._tab.currentSelected) {
				this._tab.focus();	
			}
			if (!this.currentSelected) {
				Tweener.addTween(this._labelText, {_text_color:this._hoverTextColor,time:1.0,transition:"easeOutQuart"});
			}
		}
	
		public function onMouseout(event:MouseEvent):void {
			if (!this.currentSelected) {
				var color:uint = this._focus ? this._textColor : this._disabledTextColor;
				Tweener.addTween(this._labelText, {_text_color:color,time:1.0,transition:"easeOutQuart"});
			}
		}
		
		public function highlight():void {
			if (this._menu.selectedMenuItem) {	
				//disable highlight of previous selected menu item
				this._menu.selectedMenuItem.unhighlight();
			}
			//assign new selected menu item
			this._menu.selectedMenuItem = this;
			Tweener.addTween(this._labelText, {_text_color:this._selectedTextColor,time:1.0,transition:"easeOutQuart"});
		}
		
		public function unhighlight():void {
			var color:uint = this._focus ? this._textColor : this._disabledTextColor;			
			Tweener.addTween(this._labelText, {_text_color:color,time:1.0,transition:"easeOutQuart"});		
		}
			
		public function set focus(focus:Boolean):void {
			this._focus = focus;
			var color:uint;
			if (this._focus) {
				color = (this.currentSelected ? this._selectedTextColor : this._textColor);  			
			}
			else {
				color = this._disabledTextColor;
			}
			Tweener.addTween(this._labelText, {_text_color:color,time:0.1,transition:"easeOutQuart"});	
		}
		
		public function openLink(event:MouseEvent):void {		
			this.highlight();				
			//open regular URL
			try {
				navigateToURL(this._urlReq, this._openTarget);
			} 
			catch (e:Error) {
				trace("Cannot be load.");
			}
		}		
		
		public function openClip(event:MouseEvent):void {			
			this.highlight();				
			//load external file into movieclip or sprite
			try {
				var loader:Loader = new Loader();
				var displayWin:Sprite = this._menu.getExternalFrame(this._openTarget);
				displayWin.addChild(loader);
				loader.load(this._urlReq);
			} 
			catch (e:Error) {
				trace("Cannot be load.");
			}
		}	
		
		public function openNone(event:MouseEvent):void {		
			//do not open anything
			this.highlight();	
		}
		
		public function set tab(tab:MenuWrapper):void {
			this._tab = tab;	
		}
		
		public function get currentSelected():Boolean {
			return (this._menu.selectedMenuItem == this);
		}
		
		private function autoSelectMenuItem():void {
			try {
				//auto select menu item if current page matches menu item's link
				if (this._menu.currentPage && (FlashUtil.extractPageName(this._link) == this._menu.currentPage)) {
					this._menu.selectedMenuItem = this;
				}
			}
			catch (e:Error) {
				trace("Error auto-selecting menu item");
			}		
		}
		
	}
}