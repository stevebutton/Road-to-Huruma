import caurina.transitions.*;
import mx.events.EventDispatcher;
import ascb.util.Proxy;


/**
 * this class handles the first level menu button's actions and data
 * here, the second level menu is being initialised and processed
 */
class oxylus.template03.mainMenu.First_Level_Button extends MovieClip 
{
	public var node:XMLNode;
	private var settingsObj:Object;
	public var idx:Number;
	public var totalWidth:Number;
	public var defaultPos:Number;
	public var totalWidthOpen:Number = 0;
	
	public var activated:Number = 0;
	
	public var refBg:MovieClip;
	private var normal:MovieClip;
	private var over:MovieClip;
	private var pressed:MovieClip;
	private var pressedBg:MovieClip;
	private var holder:MovieClip;
	
	
	public var subMenu:MovieClip;
	
	public var addEventListener:Function;
    public var removeEventListener:Function;
    public var dispatchEvent:Function;
	
	
	private var hitZone:MovieClip;
	private var subMenuState:Number = 0;
	private var myInterval:Number;
	
	public var parentMC:MovieClip;
	public var urlAddress:String;
	public var urlTitle:String;
	
	private var whitePresent:MovieClip;
	private var line:MovieClip;
	
	public function First_Level_Button() {
		EventDispatcher.initialize(this);
		
		refBg._alpha = 0;
		over._alpha = pressed._alpha = 0;
		normal["txt"].autoSize = over["txt"].autoSize = pressed["txt"].autoSize = true;
		
		
		refBg.onRollOver = Proxy.create(this, ponRollOver);
		refBg.onRollOut = Proxy.create(this, ponRollOut);
		refBg.onRelease = refBg.onReleaseOutside = Proxy.create(this, ponRelease);
		
		
			line = over["line"];
		
	}
	
	
	/**
	 * this function will get the xml node and it will process the data, if needed the second level menu will be created
	 * @param	pNode
	 * @param	pSettingsObj
	 */
	public function setNode(pNode:XMLNode, pSettingsObj:Object) {
		node =  pNode;
		settingsObj = pSettingsObj;
		
//		urlAddress = UAddr.contract(node.attributes.url) + "/";
		urlTitle = node.attributes.urlTitle;
		
		normal["txt"].text = over["txt"].text = pressed["txt"].text = node.attributes.title;
		
		
		refBg._width = Math.round(normal["txt"].textWidth + 2 * settingsObj.firstLevelButtonWidth);
		refBg._height = Math.round(normal["txt"].textHeight + 2 * settingsObj.firstLevelButtonHeight);
		
		pressedBg["inside"]._width = refBg._width;
		pressedBg["inside"]._height = refBg._height;
		pressedBg._alpha = 0;
		
		if (pressedBg["centers"]._width > pressedBg["inside"]._width) {
			pressedBg["centers"]._width = pressedBg["inside"]._width - 16;
		}
		pressedBg["centers"]._x = Math.ceil(pressedBg["inside"]._width / 2 - pressedBg["centers"]._width / 2);
		pressedBg["centers"]["down"]._y = Math.ceil(pressedBg["inside"]._height - pressedBg["centers"]._height + 9);
		
		normal._x = over._x = pressed._x = settingsObj.firstLevelButtonWidth;
		normal._y = over._y = pressed._y = settingsObj.firstLevelButtonHeight - 1;
		
		totalWidth = refBg._width;
		
		defaultPos = this._x;
		
		if ((node.attributes.toggleSubMenu == 1) && (node.firstChild)) {
			subMenu = holder.attachMovie("IDSecond_Menu", "Second_Menu_" + idx, holder.getNextHighestDepth());
			subMenu.addEventListener("SecondLevelButtonPressed", Proxy.create(this, SecondLevelButtonPressed));
			
			subMenu.firstLevelParentButton = this;
			subMenu.setNode(node.firstChild, settingsObj);
			
			
			subMenu._x = Math.ceil(settingsObj.subMenuXDistance + totalWidth / 2 - subMenu.totalWidth / 2);
			subMenu._y = settingsObj.subMenuYDistance + 12;
		
				subMenu._y += 8
			
			
			hitZone = holder.createEmptyMovieClip("hitZone", holder.getNextHighestDepth());
			
			drawOval(hitZone, Math.max(totalWidth, subMenu.totalWidth), Math.round(settingsObj.subMenuYDistance + subMenu.totalHeight), 0, 0x00ff00, 0);
			
			refBg.useHandCursor = false;
		}
		
		
		
			line._width = Math.ceil(over["txt"].textWidth);
			line._y = Math.ceil(over["txt"].textHeight + 3);
		
		pressedBg._visible = false;
	}

	public function completeArray(pSecondLevelArray:Array) {
		if (subMenu) {
			var idx:Number = 0;
			var tMc:MovieClip = subMenu["content"]["holder"]["SecondLevelButton_" + idx];
			while (tMc) {
				pSecondLevelArray.push(tMc);
				idx++;
				tMc = subMenu["content"]["holder"]["SecondLevelButton_" + idx];
			}
		}
	}
	
	private function SecondLevelButtonPressed(pObj:Object) {
		dispatchEvent( { target:this, type:"SecondLevelButtonPressed", mc:pObj.mc, mcParent:this } );
	}
	
	private function ponRollOver() {
		dispatchEvent( { target:this, type:"overFirstLevelButton", mc:this } );
		showSubMenu();
	}
	
	public function showSubMenu() {
		if (subMenu) {
			activated = 1;
			subMenuState = 1;
			subMenu.show();
			overState();
			clearInterval(myInterval);
			myInterval = setInterval(this, "checkOver", 30);
		}
		else {
			overState();
		}
	}
	
	private function ponRollOut() {
		normalState();
	}
	
	public function cancelSubMenu() {
		if (subMenu) {
			clearInterval(myInterval);
			activated = 0;
			subMenuState = 0;
			subMenu.hide();
			normalState();
		}
	}
	
	
	private function checkOver() {
		var adjust:Number = 0;
		
			
				adjust = 15;
			
		if ((this._xmouse-subMenu._x > settingsObj.subMenuXDistance)
			&& (this._xmouse < subMenu.totalWidth + settingsObj.subMenuXDistance + subMenu._x)
			&& (this._ymouse > subMenu._x) && 
			(this._ymouse < settingsObj.subMenuYDistance + subMenu.totalHeight + adjust)){
			
		}
		else {
			clearInterval(myInterval);
			cancelSubMenu();
		}
	}
	

	public function dispatchMc() {
		if (!subMenu) {
				
			dispatchEvent( { target:this, type:"FirstLevelButtonPressed", mc:this } );
		}	
	}
	
	public function initialBlankRelease() {
		if (!subMenu) {
			dispatchMc()
		}	
	}
	
	/**
	 * modify the getURL command to change the action launched upon pressing the button
	 */
	public function ponRelease() {
		if (!subMenu) {
			getURL(node.attributes.url, node.attributes.target);
			dispatchMc();
		}	
	}
	
	
	public function overState() {
		Tweener.addTween(over, { _alpha:100, time:0.2, transition:"linear" } );
	}
	
	public function normalState() {
		if (subMenuState == 0) {
			
			Tweener.addTween(over, { _alpha:0, time:0.2, transition:"linear" } );
		}
		
	}
	
	
	public function subMenuReset() {
		if (subMenu) {
			subMenu.subMenuReset();
		}
		
		initialState();
	}
	
	public function blockActivated() {
		activated = 1;
			
				Tweener.addTween(pressed, { _alpha:100, delay:.2, time:0.2, transition:"linear" } );
			
	
	
	}
	
	public function initialState() {
		Tweener.addTween(normal, { _alpha:100, time:0.2, transition:"linear" } );
		Tweener.removeTweens(pressed)
		Tweener.addTween(pressed, { _alpha:0, time:0.2, transition:"linear" } );
		
		Tweener.addTween(over, { _alpha:0, time:0.2, transition:"linear" } );
		
		activated = 0;
	}
	
	
	private function drawOval(mc:MovieClip, mw:Number, mh:Number, r:Number, fillColor:Number, alphaAmount:Number) {
		mc.clear();
		mc.beginFill(fillColor,alphaAmount);
		mc.moveTo(r,0);
		mc.lineTo(mw-r,0);
		mc.curveTo(mw,0,mw,r);
		mc.lineTo(mw,mh-r);
		mc.curveTo(mw,mh,mw-r,mh);
		mc.lineTo(r,mh);
		mc.curveTo(0,mh,0,mh-r)
		mc.lineTo(0,r);
		mc.curveTo(0,0,r,0);
		mc.endFill();
	}
}