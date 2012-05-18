import ascb.util.Proxy;
import caurina.transitions.*;
import mx.data.types.Obj;
import mx.data.types.Str;
import oxylus.utils.UNode;


import mx.events.EventDispatcher;
import oxylus.utils.UXml


class oxylus.template03.mainMenu.MainMenu_MainInstance extends MovieClip 
{
	private var xml:XML;	
	private var node:XMLNode;
	private var settingsObj:Object;
	public var totalWidth:Number;
	
	private var holder:MovieClip;
	private var bg:MovieClip;
	private var moveBg:MovieClip;
	
	private var newBgWidth:Number;
	private var origX:Number;
	
	private var activatedButtons:Object;
	
	private var firstLoad:Number = 1;
	
	public var addEventListener:Function;
    public var removeEventListener:Function;
    public var dispatchEvent:Function;
	
	private var firstLevelButtons:Array;
	
	private var firstLevelArray:Array;
	private var secondLevelArray:Array;
	
	private var defWBgOver:Number;
	
	private var universH:Number;
	
	public function MainMenu_MainInstance() {
		EventDispatcher.initialize(this);
		
		moveBg._alpha = 0;
		
		activatedButtons = new Object();
		activatedButtons.firstLevel = undefined;
		activatedButtons.secondLevel = undefined;
		
		_global.mainMenuVisibleWidth = 0;
		
		this._visible = false;
		
		loadMyXml()
	}
	
	private function loadMyXml() { 
		var xmlString:String = _level0.xml == undefined ? "data.xml" : _level0.xml;
		xml = UXml.loadXml(xmlString, xmlLoaded, this, true, true);
	}
	
	private function xmlLoaded(s:Boolean) {
		if (!s) { trace("XML error !"); return; }	
		
		settingsObj = UNode.nodeToObj(xml.firstChild.firstChild);
	
		setNode(xml.firstChild);
	}
	
	

	/**
	 * the main node for the menu is being set here
	 * @param	pNode
	 */
	public function setNode(pNode:XMLNode)
	{
		node = pNode;
		
		node = node.firstChild
		settingsObj = UNode.nodeToObj(node);
		
		node = node.nextSibling.firstChild;
		
		defWBgOver = moveBg["centers"]._width
		var currentPos:Number = 0;
		var idx:Number = 0;
		
		firstLevelArray = new Array();
		
		for (; node != null; node = node.nextSibling) {
			var but:MovieClip = holder.attachMovie("IDFirstLevelButton", "FirstLevelButton_" + idx, holder.getNextHighestDepth());
			
			but.addEventListener("FirstLevelButtonPressed", Proxy.create(this, FirstLevelButtonPressed));
			but.addEventListener("overFirstLevelButton", Proxy.create(this, overFirstLevelButton));
			but.addEventListener("outFirstLevelButton", Proxy.create(this, outFirstLevelButton));
			but.addEventListener("SecondLevelButtonPressed", Proxy.create(this, SecondLevelButtonPressed));
			
			but.parentMC = this;
			but._x = currentPos;
			but.idx = idx;
			but.setNode(node, settingsObj);

			currentPos += but.totalWidth;

			firstLevelArray.push(but);
			
			if (idx == 0) {
				universH = but.refBg._height;
			}
			idx++;
		}
		
		_global.mainMenuVisibleWidth = currentPos;
		
		var idx:Number = 0;
		secondLevelArray = new Array();
		while (holder["FirstLevelButton_" + idx]) {
			var currentSubMenu:MovieClip = holder["FirstLevelButton_" + idx].subMenu;
			if (currentSubMenu) {
				var i:Number = 0;
				while (currentSubMenu.holder["lst"]["SecondLevelButton_" + i]) {
					secondLevelArray.push(currentSubMenu.holder["lst"]["SecondLevelButton_" + i]);
					i++;
				}
			}
			idx++;
		}
		
		bg._width = totalWidth  = currentPos + 2;
		bg._height = but._height + 2;
	
		loadStageResize();

		if (_level0.firstLevel) {
			var idx:Number = 0;
			while (holder["FirstLevelButton_" + idx]) {
				if (holder["FirstLevelButton_" + idx].node.attributes.title == _level0.firstLevel) {
					holder["FirstLevelButton_" + idx].initialBlankRelease();
					break;
				}
				idx++;
			}
		}
		
		this._visible = true;
	}
	
	/**
	 * this function will properly calculate and move the background under the menu
	 */
	public function moveTheBg(theMc:MovieClip) {
		if (!_global.whitePresent) {
			Tweener.addTween(moveBg["inside"], { _width:Math.ceil(theMc.refBg._width), 
											_height:Math.ceil(universH), 
											time: settingsObj.mainMenuMovingBgAnimationTime, 
											transition: settingsObj.mainMenuMovingBgAnimationType } );
		
			var newWCen:Number = Math.ceil(moveBg["centers"]._width);
			var dec:Number = 0;
			
			if (defWBgOver > theMc.refBg._width) {
				newWCen = theMc.refBg._width - 26;
				dec = -0.5;
			}
			else {
				newWCen = defWBgOver;
			}
												
			Tweener.addTween(moveBg["centers"], { _x:Math.ceil(theMc.refBg._width / 2 - newWCen / 2), 
												  _width:newWCen,
												time:settingsObj.mainMenuMovingBgAnimationTime, 
												transition: settingsObj.mainMenuMovingBgAnimationType } );
		}
		else {
			Tweener.addTween(moveBg["bg"], { _width:Math.ceil(theMc.refBg._width), 
											_height:Math.ceil(theMc.refBg._height), 
											time:settingsObj.mainMenuMovingBgAnimationTime, 
											transition: settingsObj.mainMenuMovingBgAnimationType } );
			Tweener.addTween(moveBg["arrow"], { _x:Math.ceil(theMc.refBg._width/2-moveBg["arrow"]._width/2), 
											_y:Math.ceil(theMc.refBg._height), 
											time: settingsObj.mainMenuMovingBgAnimationTime, 
											transition: settingsObj.mainMenuMovingBgAnimationType } );
		}
		
		
		Tweener.addTween(moveBg, { _alpha:theMc._alpha, _x:Math.round(theMc._x), time:settingsObj.mainMenuMovingBgAnimationTime, transition: settingsObj.mainMenuMovingBgAnimationType } );
		
	

	}
	private function FirstLevelButtonPressed(pObj:Object) {
		if (activatedButtons.firstLevel != pObj.mc) {
				activatedButtons.secondLevel.off();
				activatedButtons.secondLevel = undefined;
	
				
			
				var id:Number = 0;
				while (holder["FirstLevelButton_" + id]) {
					if (holder["FirstLevelButton_" + id] != pObj.mc) {
						holder["FirstLevelButton_" + id].subMenuReset();
					}
					id++
					
				}
				
				activatedButtons.firstLevel.subMenuReset();
				activatedButtons.firstLevel = pObj.mc;
				activatedButtons.firstLevel.blockActivated();
				moveTheBg(pObj.mc);
				
				dispatchEvent( { target:this, type:"buttonPressed", mc:pObj.mc } );
			
		}
		else {
			moveTheBg(pObj.mc);
			dispatchEvent( { target:this, type:"buttonPressedTheSame", mc:pObj.mc } );
		}
	}
	
	private function SecondLevelButtonPressed(pObj:Object) {	
		if (activatedButtons.secondLevel != pObj.mc) {

				activatedButtons.secondLevel.off();
				activatedButtons.secondLevel = pObj.mc;
				activatedButtons.secondLevel.onn();
				
				var id:Number = 0;
				while (holder["FirstLevelButton_" + id]) {
					if (holder["FirstLevelButton_" + id] != pObj.mc.mcParent) {
						holder["FirstLevelButton_" + id].subMenuReset();
					}
					id++
					
				}
			
			
				//	activatedButtons.firstLevel.subMenuReset();
					activatedButtons.firstLevel = pObj.mc.mcParent;
					activatedButtons.firstLevel.blockActivated();
					
				moveTheBg(pObj.mc.mcParent)
				dispatchEvent( { target:this, type:"buttonPressed", mc:pObj.mc } );

		}
		else {
			moveTheBg(pObj.mc.mcParent)
			dispatchEvent( { target:this, type:"buttonPressedTheSame", mc:pObj.mc } );

		}
	}
	
	private function overFirstLevelButton(pObj:Object){
		var idx:Number = 0;
		var cB:MovieClip = firstLevelArray[idx];
		
		while (cB) {
			if (cB != pObj.mc) {
				cB.cancelSubMenu();
				cB.showNormalState();
			}
			idx++;
			cB = firstLevelArray[idx];
		}
	}
	
	
	private function outFirstLevelButton(pObj:Object){
		
	}
	
	
	
	public function overStateMainButton() {
		
	}
	
	
	
	
	/**
	 * this function will place the menu taking into consideration the settings from the xml file
	 * @param	pW
	 * @param	pH
	 */
	private function resize(pW:Number, pH:Number) {
		switch(settingsObj.menuPosition) {
			case "center":
				this._x = Math.ceil(settingsObj.correctMenuXpos + pW / 2 - totalWidth / 2);
				break;
			case "left":
				this._x = settingsObj.correctMenuXpos;
				break;
			case "right":
				this._x = Math.ceil(pW - totalWidth - settingsObj.correctMenuXpos);
				break;
			default:
				this._x = Math.ceil(settingsObj.correctMenuXpos);
				break;
		}
		
		this._y = Math.ceil(settingsObj.correctMenuYPos);
	}
	
	
	private function onResize() {
		
			resize(Stage.width, Stage.height);
	
	}
	
	
	/**
	 * this will load the stage resize and it will listen to it
	 */
	private function loadStageResize() {
		Stage.addListener(this);
		onResize();
	}
}