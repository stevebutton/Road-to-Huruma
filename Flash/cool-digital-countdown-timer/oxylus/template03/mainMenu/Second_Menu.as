import ascb.util.Proxy;
import caurina.transitions.*;
import oxylus.Utils;
import mx.events.EventDispatcher;


class oxylus.template03.mainMenu.Second_Menu extends MovieClip 
{
	private var node:XMLNode;
	private var settingsObj:Object;
	
	public var totalWidth:Number;
	public var totalHeight:Number;
	
	private var content:MovieClip;
		public var holder:MovieClip;
		public var bg:MovieClip;
	private var mask:MovieClip;
	
	private var cont:MovieClip;
	
	private var maskWidth:Number;
	
	
	public var addEventListener:Function;
    public var removeEventListener:Function;
    public var dispatchEvent:Function;
	
	private var movingBg:MovieClip;
	
	public var secondActive:MovieClip;
	public var firstLevelParentButton:MovieClip;

	private var holderMask:MovieClip;
	private var holderHit:MovieClip;
	private var myInterval2:Number;
	private var totalLstBottomY:Number;
	
	private var myInterval3:Number;
	
	public function Second_Menu() {
		EventDispatcher.initialize(this);
		this._visible = false;
		
		cont = content["cont"]
		holder = cont["holder"];
		bg = content["bg"];
		movingBg = holder["movingBg"];
		
		content.setMask(mask);
		
		
		holderMask = cont["holderMask"];
		
		holder.setMask(holderMask);
		
		holderHit = cont["holderHit"];
	}
	
	
	/**
	 * this function will get the xml node and it will create the second level menu buttons
	 * @param	pNode
	 * @param	pSettingsObj
	 */
	public function setNode(pNode:XMLNode, pSettingsObj:Object) {
		node =  pNode.firstChild;
		settingsObj = pSettingsObj;
		
		var currentPos:Number = 0;
		var idx:Number = 0;
		var maxWidth:Number = 0;
		for (; node != null; node = node.nextSibling) {
			var but:MovieClip = holder["lst"].attachMovie("IDSecondLevelButton", "SecondLevelButton_" + idx, holder["lst"].getNextHighestDepth());
			but.addEventListener("SecondLevelButtonPressed", Proxy.create(this, SecondLevelButtonPressed));
			but.mcParent = firstLevelParentButton;
			but.addEventListener("SecondLevelButtonOver", Proxy.create(this, SecondLevelButtonOver));
			but.addEventListener("SecondLevelButtonOut", Proxy.create(this, SecondLevelButtonOut));
			but._y = currentPos;
			but._x = 7;
			but.setNode(node, settingsObj);
			
			but.subMenu = this;
			
			currentPos += but.totalHeight - 5;
			maxWidth = Math.max(maxWidth, but.totalWidth);
			
			var bgBut:MovieClip = holder["lst2"].attachMovie("IDbuttonOver", "butOver" + idx, holder["lst2"].getNextHighestDepth());
			bgBut._y = but._y;
			
			idx++;
		}
		
		
		bg._width = totalWidth = Math.round(10 + maxWidth + settingsObj.subMenuAddedWidth + 10);
		bg._height = totalHeight = settingsObj.subMenuMaxHeight;
		

		content["arrow"]._x = Math.ceil(bg._width / 2 - content["arrow"]._width / 2);
		
			content["arrow"]._y -= 6;
			bg._y = content["arrow"]._y + content["arrow"]._height;	
		
		
		mask._x = -2;
		mask._y = -2;
		mask._width = bg._width + 4;
		mask._height = bg._height + 4;
		
		cont._x = 12;
			
				cont._y = 18;
				mask._height +=10
			
		
		holderMask._x -= 4;		
		content._y = -mask._height;


		movingBg._width = Math.ceil(mask._width - 2 * cont._x - 4);
		movingBg._height = Math.ceil(but.totalHeight - 8);
		movingBg._x = 0;
		movingBg._alpha = 0;
		
		var idxx:Number = 0;
		while (holder["lst2"]["butOver" + idxx]) {
			holder["lst2"]["butOver" + idxx]._width = movingBg._width;
			holder["lst2"]["butOver" + idxx]._height = movingBg._height;
			holder["lst2"]["butOver" + idxx]._x -= (settingsObj.secondLevelButtonWidth);
			holder["lst2"]["butOver" + idxx]._y += (settingsObj.secondLevelButtonHeight);
			holder["lst"]["SecondLevelButton_" + idxx].refBg._width = movingBg._width
			idxx++;
		}
		
		holderMask._height = holderHit._height = Math.ceil(bg._height - 16 - 10);
		holderMask._width = holderHit._width = bg._width;
		
		
		if (currentPos < holderMask._height) {
			trace("no scroll");
			bg._height = Math.ceil(currentPos + 16 + 7+ 5);
		}
		else {
			totalLstBottomY = Math.ceil(currentPos + 4 - holderHit._height);
		}
		
		
			totalHeight = bg._y+bg._height + 6
		
		
		if (_level0.secondLevel) {
			var idd:Number = 0;
			while (holder["lst"]["SecondLevelButton_" + idd]) {
				if (holder["lst"]["SecondLevelButton_" + idd].node.attributes.title == _level0.secondLevel) {
					holder["lst"]["SecondLevelButton_" + idd].initialBlankRelease()
					break;
				}
				idd++;
			}
		}
		this._visible = true;
	}
	
	
	public function stopScrolling() {
		clearInterval(myInterval2);
		clearInterval(myInterval3);
	}
	
	public function startScrolling() {
		clearInterval(myInterval2);
		
			holder._y = -4
		
		
		myInterval3 = setInterval(this, "nowScroll", settingsObj.subMenuOpenAnimTime*1000);
	}
	
	public function nowScroll() {
		clearInterval(myInterval3);
		myInterval2 = setInterval(this, "scrollThis", 30);
	}
	
	private function scrollThis() {
	
		if (holderHit._xmouse > 0 && holderHit._xmouse < holderHit._width && holderHit._ymouse > 0 && holderHit._ymouse < (holderHit._height+40)) {
				var per:Number = Math.ceil(holderHit._ymouse*2 / (holderHit._height-40) * 100);
				trace(per)
				if (per < 10) {
					per = 0;
				}
				
				if (per > 90) {
					per = 100;
				}

				var actualCurrentY:Number = Math.ceil(totalLstBottomY / 100 * per);
			
				Tweener.addTween(holder, { _y:-actualCurrentY, time:.05*settingsObj.scrollerAccelerationMultiplier, transition:"linear" } );
			
		}
	}
	
	public function subMenuReset() {
		secondActive = undefined;
		Tweener.addTween(movingBg, { _y:0, _alpha:0, time:.7, transition:"easeOutExpo", rounded:true } );
		
	}
	
	private function SecondLevelButtonOut(pObj:Object):Void 
	{
		if (secondActive) {
			var adjust:Number = 0;
			
				adjust = cont._y -14;
			
			Tweener.addTween(movingBg, { _y:Math.round(secondActive._y + (secondActive.totalHeight / 2 - movingBg._height / 2) + 2 + 4 - adjust),
									_alpha:100, delay:.3, time:.7, transition:"linear", rounded:true,onComplete:Proxy.create(this, rev) } );
									

				if (pObj.mc != secondActive) {
					secondActive.revert();
				}
				

		}
		else {
			subMenuReset();
		}
	}
	private function rev() {
		
				secondActive.revertBack();
	
	}
	private function SecondLevelButtonOver(pObj:Object):Void 
	{
		Tweener.addTween(movingBg, { _y:Math.round(pObj.mc._y + (pObj.mc.totalHeight / 2 - movingBg._height / 2) + 2),
									_alpha:100,  time:.7, transition:"easeOutExpo", rounded:true } );
		
			if (pObj.mc == secondActive) {
				secondActive.revertBack();
			}
			else {
				
				secondActive.revert();
			
			}

	}
	
	/**
	 * actions for pressing the second level menu button, no need to put actions here, please use the listener from the Main_Instance.as source file
	 * @param	pObj
	 */
	private function SecondLevelButtonPressed(pObj:Object) {
		dispatchEvent( { target:this, type:"SecondLevelButtonPressed", mc:pObj.mc } );
	}
	
	/**
	 * this function will show the second level menu
	 */
	public function show() {
		startScrolling()
		Tweener.addTween(content, { _y:4, time:settingsObj.subMenuOpenAnimTime, transition:settingsObj.subMenuOpenAnimType, rounded:true } );
	}
	
	/**
	 * this function will hide the second level menu
	 */
	public function hide() {
		stopScrolling();
		
			Tweener.addTween(content, { _y: -mask._height - 23, time:settingsObj.subMenuOpenAnimTime + 0.2, transition:settingsObj.subMenuOpenAnimType, rounded:true } );
	
		
		
	}
	
	private function invisThis() {
		this._visible = false;
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