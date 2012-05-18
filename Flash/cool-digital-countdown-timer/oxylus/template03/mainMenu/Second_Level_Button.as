import caurina.transitions.*;
import mx.events.EventDispatcher;

class oxylus.template03.mainMenu.Second_Level_Button extends MovieClip 
{
	public var node:XMLNode;
	private var settingsObj:Object;
	public var totalWidth:Number;
	public var totalHeight:Number;
	
	public var activated:Number = 0;
	public var mcParent:MovieClip;
	public var refBg:MovieClip;
	private var normal:MovieClip;
	private var over:MovieClip;

	public var addEventListener:Function;
    public var removeEventListener:Function;
    public var dispatchEvent:Function;
	
	public var subMenu:MovieClip;
	
	public var urlAddress:String;
	public var urlTitle:String;
	
	public function Second_Level_Button() {
		EventDispatcher.initialize(this);
		refBg._alpha = 0;
		normal["txt"].autoSize = true;
		over["txt"].autoSize = true;
		
	}
	
	
	/**
	 * this function will setup the node and it will properly place the graphics
	 * @param	pNode
	 * @param	pSettingsObj
	 */
	public function setNode(pNode:XMLNode, pSettingsObj:Object) {
		node =  pNode;
		settingsObj = pSettingsObj;
	
		normal["txt"].text = node.attributes.title;
		over["txt"].text =node.attributes.title;
		over._alpha = 0
		
		refBg._width = Math.round(normal["txt"].textWidth + 2 * settingsObj.secondLevelButtonWidth);
		refBg._height = Math.round(normal["txt"].textHeight + 2 * settingsObj.secondLevelButtonHeight);
		
		normal._x = over._x = settingsObj.secondLevelButtonWidth + 1;
		normal._y = over._y = settingsObj.secondLevelButtonHeight ;
		
		totalWidth = refBg._width;
		totalHeight = refBg._height;
		
		refBg._width += 100;
	
	}
	
	
	/**
	 * this gets called when you roll over the button
	 */
	private function onRollOver() {
		dispatchEvent( { target:this, type:"SecondLevelButtonOver", mc:this } );
		if (activated == 0	) {
			Tweener.addTween(over, { _alpha:100, time:0.2, transition:"linear"} );
		}
	}
	

	
	private function onRollOut() {
		dispatchEvent( { target:this, type:"SecondLevelButtonOut", mc:this } );
		if (activated == 0	) {
			Tweener.addTween(over, { _alpha:0, time:0.2, transition:"linear"} );
		}
	}
	

	public function dispatchMc() {
	
		onRollOver()
		
		dispatchEvent( { target:this, type:"SecondLevelButtonPressed", mc:this } );
	}
	
	public function initialBlankRelease() {
		dispatchMc()
	}
	
	/**
	 * modify the getURL command to change the action launched upon pressing the button
	 */
	public function onRelease() {
		getURL(node.attributes.url, node.attributes.target);
		dispatchMc();
	}
	
	private function onReleaseOutside() {
		onRelease();
	}
	
	
	/**
	 * this will activate the button
	 */
	public function onn() {
		activated = 1;
		subMenu.secondActive = this;
	}
	
	/**
	 * this will make the button inactive, it will reset to the default state
	 */
	public function off() {
		activated = 0;
		Tweener.addTween(normal, { _alpha:100, time:0.2, transition:"linear" } );
		Tweener.addTween(over, { _alpha:0, time:0.2, transition:"linear"} );
	}
	
	public function revert() {
		Tweener.addTween(normal, { _alpha:100, time:0.1, transition:"linear" } );
		Tweener.addTween(over, { _alpha:0, time:0.2, transition:"linear"} );
	}
	
	public function revertBack() {
		Tweener.addTween(normal, { _alpha:0, time:0.2, transition:"linear" } );
		Tweener.addTween(over, { _alpha:100, time:0.1, transition:"linear"} );
	}
}