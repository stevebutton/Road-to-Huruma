package com.webtako.flash {	
	import caurina.transitions.Tweener;
	import caurina.transitions.properties.ColorShortcuts;
	ColorShortcuts.init();
	
	import flash.display.CapsStyle;
	import flash.display.Graphics;
	import flash.display.JointStyle;
	import flash.display.LineScaleMode;
	import flash.display.Sprite;
	import flash.events.MouseEvent;
	import flash.display.GradientType;
	import flash.display.SpreadMethod;
	import flash.geom.Matrix;
	import flash.display.Shape;
	import flash.geom.ColorTransform;
	
	public class MenuWrapper extends Sprite {
	
		public static const ROUND_TAB:String = "ROUND";
		public static const SQUARE_TAB:String = "SQUARE";
				
		public static const AUTO_ALIGN:String = "AUTO";
		public static const LEFT_ALIGN:String = "LEFT";
		public static const RIGHT_ALIGN:String = "RIGHT";
		public static const CENTER_ALIGN:String = "CENTER";
		
		private var _menu:TabMenu;
		private var _menuItem:MenuItem;
		private var _subItems:Array;
		
		private var _menuOutline:Shape;
		private var _menuFill:Shape;
		private var _filterFill:Shape;
		
		private var _bgColor:uint;	
		private var _gradientColor:uint;
		private var _borderColor:uint;
		
		private var _filterBgColor:uint;			
		private var _filterGradientColor:uint;
		private var _filterBorderColor:uint;

		private var _menuWidth:Number;
		private var _menuHeight:Number;
		private var _submenuX:Number;
		private var _borderSize:Number;

		private var _tabType:String;
		private var _fadeSubmenu:Boolean;
		private var _darkenBackMenu:Boolean;
		private var _borderOn:Boolean;
		private var _filterOn:Boolean;
		
		public function MenuWrapper(menu:TabMenu, menuItem:MenuItem, submenuItems:Array, 
									bgColor:uint = 0xFFFFFF, gradientColor:uint = 0xCCCCCC, borderColor:uint = 0x999999, 
									filterOn:Boolean = false, 
									filterBgColor:uint = 0xFFFFFF, filterGradientColor:uint = 0xCCCCCC, filterBorderColor:uint = 0x999999, 
									width:Number = 600, height:Number = 65, submenuAlign:String = LEFT_ALIGN,
									fadeSubmenu:Boolean = true, darkenBackMenu:Boolean = false, borderOn:Boolean = true, tabType:String = ROUND_TAB):void {			
			//set properties
			this._menu = menu;
			this._menuItem = menuItem;
			this._subItems = submenuItems;	
			
			this._bgColor = bgColor;
			this._gradientColor = gradientColor;
			this._borderColor = borderColor;
			
			this._filterBgColor = filterBgColor;
			this._filterGradientColor = filterGradientColor;
			this._filterBorderColor = filterBorderColor;
			
			this._menuWidth = width;
			this._menuHeight = height;
			this._submenuX = 0;
			
			this._tabType = tabType.toUpperCase();
			this._fadeSubmenu = fadeSubmenu;
			this._borderOn = borderOn;
			this._filterOn = filterOn;
			this._darkenBackMenu = darkenBackMenu;
			
			this._borderSize = this._borderOn ? 1 : 0;
			
			//determine submenu x offset
			submenuAlign = submenuAlign.toUpperCase();
			if (isNaN(Number(submenuAlign))) {
				this._submenuX = this.getSubmenuX(submenuAlign);
			}
			else {
				this._submenuX = Number(submenuAlign);
			}
			
			//init & display menu and menu items	
			this.initWrapper();			
			this.initMenuItem();
			this.initSubmenuItems();
			
			//check if it's default selected menu
			if (this._menu.selectedTab != this) {
				this.unfocus();
			}
			
			//init mouse behaviors
			this.buttonMode = false;
			this.useHandCursor = false;
			this.mouseChildren = true;			
			
		}

		public function get currentSelected():Boolean {
			return (this._menu.selectedTab == this);
		}
		
		public function focus():void {
			if (this._menu.selectedTab) {	
				//disable previous selected menu
				this._menu.selectedTab.unfocus();				
			}
			
			//assign new selected menu
			this._menu.selectedTab = this;		
			this._menu.setChildIndex(this, this._menu.numChildren-1);
			
			//perform enable display effect
			if (this._filterOn) {		
				this._menuItem.focus = true;
				this.changeBorderColor(this._borderColor);
				this._filterFill.alpha = 0;
			}
			if (this._darkenBackMenu) {
				Tweener.addTween(this, {_brightness:0,time:0.5,transition:"linear"});
			}
			if (this._fadeSubmenu && this._subItems.length > 1) {
				Tweener.addTween(this._subItems, {alpha:1,time:1.25,transition:"easeInOutQuart"});		
			}
		}
		
		public function unfocus():void {
			//perform disable display effect
			if (this._filterOn) {	
				this._menuItem.focus = false;
				this.changeBorderColor(this._filterBorderColor);
				this._filterFill.alpha = 1;
			}
			if (this._darkenBackMenu) {
				Tweener.addTween(this, {_brightness:-.20,time:0.5,transition:"linear"});
			}
			if (this._fadeSubmenu && this._subItems.length > 1) {
				Tweener.addTween(this._subItems, {alpha:0,time:0.5,transition:"linear"});		
			}
		}
		
		private function initWrapper():void {
			//init and draw menu container shape
			this._menuFill = new Shape();	
			this.fillShape(this._menuFill, this._bgColor, this._gradientColor);
  			this.addChild(this._menuFill);
			
			if (this._filterOn) {
				this._filterFill = new Shape();
				this.fillShape(this._filterFill, this._filterBgColor, this._filterGradientColor);
				this._filterFill.alpha = 0;
				this.addChild(this._filterFill);
			}
			
			if (this._borderOn) {
	  			this.drawBorder();
			}
		}
		
		private function drawBorder():void {
			this._menuOutline = new Shape();		
  			this._menuOutline.graphics.lineStyle(this._borderSize, this._borderColor, 1, true, LineScaleMode.NORMAL, CapsStyle.NONE, JointStyle.MITER);	
  			if (this._tabType == MenuWrapper.SQUARE_TAB) {
  				this.traceSquareOutline(this._menuOutline.graphics); 
  			}
  			else {
				this.traceRoundOutline(this._menuOutline.graphics);  										
			}
  			this.addChild(this._menuOutline);
		}
		
		private function fillShape(shape:Shape, color1:uint, color2:uint) {
			if (color1 != color2) {
  				var colors:Array = [color1, color2];
				var matrix:Matrix = new Matrix();
	  			matrix.createGradientBox(this._menuWidth, this._menuHeight, Math.PI/2, 0, 0);
			
				shape.graphics.lineGradientStyle(GradientType.LINEAR, colors, [1, 1], [0, 255], matrix, SpreadMethod.PAD);
 				shape.graphics.beginGradientFill(GradientType.LINEAR, colors, [1, 1], [0, 255], matrix, SpreadMethod.PAD);   				
  			}
  			else {
  				shape.graphics.beginFill(color1, 1); 
  			}
  			
  			if (this._tabType == MenuWrapper.SQUARE_TAB) {
	  			this.traceSquareOutline(shape.graphics); 
  			}
  			else {
	  			this.traceRoundOutline(shape.graphics);		  			
	  		}
  			shape.graphics.endFill();
		}
		
		private function traceRoundOutline(graphics:Graphics):void {
			var curveSize:Number = Math.floor(this._menuItem.height/3);
			var menuWidth:Number = (this._menuItem.width < (2 * curveSize)) ? (2 * curveSize) : this._menuItem.width;
			
			graphics.moveTo(this._menuItem.x, curveSize);
  			graphics.curveTo(this._menuItem.x, 0, this._menuItem.x + curveSize, 0);
			graphics.lineTo(this._menuItem.x + menuWidth - this._borderSize - curveSize, 0);
			graphics.curveTo(this._menuItem.x + menuWidth - this._borderSize, 0, this._menuItem.x + menuWidth - this._borderSize, curveSize);			
			graphics.lineTo(this._menuItem.x + menuWidth - this._borderSize, this._menuItem.height - this._borderSize);
			graphics.lineTo(this._menuWidth - this._borderSize, this._menuItem.height - this._borderSize);
			graphics.lineTo(this._menuWidth - this._borderSize, this._menuHeight - this._borderSize);
			graphics.lineTo(0, this._menuHeight - this._borderSize);
			graphics.lineTo(0, this._menuItem.height - this._borderSize);
			graphics.lineTo(this._menuItem.x, this._menuItem.height - this._borderSize);
			graphics.lineTo(this._menuItem.x, curveSize);			
		}
		
		private function traceSquareOutline(graphics:Graphics):void {			
			graphics.moveTo(this._menuItem.x, 0);
			graphics.lineTo(this._menuItem.x + this._menuItem.width - this._borderSize, 0);
			graphics.lineTo(this._menuItem.x + this._menuItem.width - this._borderSize, this._menuItem.height - this._borderSize);
			graphics.lineTo(this._menuWidth - this._borderSize, this._menuItem.height - this._borderSize);
			graphics.lineTo(this._menuWidth - this._borderSize, this._menuHeight - this._borderSize);
			graphics.lineTo(0, this._menuHeight - this._borderSize);
			graphics.lineTo(0, this._menuItem.height - this._borderSize);
			graphics.lineTo(this._menuItem.x, this._menuItem.height - this._borderSize);
			graphics.lineTo(this._menuItem.x, 0);
		}
		
		private function initMenuItem():void {
			//assign selected if one of its menu item is selected
			if (this._menuItem.currentSelected) {
				this._menu.selectedTab = this;
			}
			this.addChild(this._menuItem);
		}
		
		private function initSubmenuItems():void {			
			var startX:Number = 0;			
			if (this._submenuX > 0) {			
				startX = this._submenuX;
			}
			
			//add submenu items
			for (var i:uint = 0; i < this._subItems.length; i++) {
				var item:MenuItem = MenuItem(this._subItems[i]);
				//assign selected if one of its menu item is selected
				if (item.currentSelected) {
					this._menu.selectedTab = this;
				}			
				item.x = startX;
				item.y = this._menuItem.height;
				if (item.x + item.width <= this._menuWidth) {
					this.addChild(item);		
					startX += item.width;
				}
				else {	//if items can no longer fit within 2nd level container, do not add items
					return;
				}
			}
		}				
		
		private function changeBorderColor(color:uint):void {
			if (this._menuOutline) {
				var colorTransform:ColorTransform = this._menuOutline.transform.colorTransform;
				colorTransform.color = color;
				this._menuOutline.transform.colorTransform = colorTransform;
			}
		}
		
		private function getSubmenuX(submenuAlign:String):Number {
			var submenuX:Number = 0;
			
			if (submenuAlign == LEFT_ALIGN) {
				return submenuX;
			}
			else {
				var submenuWidth:Number = this.getSubmenuWidth();
				if (submenuAlign == AUTO_ALIGN) {
					submenuX = this._menuItem.x - Math.round((submenuWidth - this._menuItem.width)/2);
				}
				else if (submenuAlign == CENTER_ALIGN) {;
					submenuX = Math.round((this._menuWidth - submenuWidth)/2);		
				}
				else if (submenuAlign == RIGHT_ALIGN) {
					submenuX = Math.round(this._menuWidth - submenuWidth);
				}					
			}
			
			return submenuX;
		}
		
		private function getSubmenuWidth():Number {
			var submenuWidth:Number = 0;
			for (var i:uint = 0; i < this._subItems.length; i++) {
				var item:MenuItem = MenuItem(this._subItems[i]);
				submenuWidth += item.width;
			}
			return submenuWidth;
		}
	}
}