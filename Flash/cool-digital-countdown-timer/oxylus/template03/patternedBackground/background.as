import caurina.transitions.*;
import ascb.util.Proxy;

class oxylus.template03.patternedBackground.background extends MovieClip 
{
	private var bg:MovieClip;
		private var bgIdx:Number = 0;
		
	private var grad:MovieClip;
	
	public function background() {
		bg = this["bg"];
		grad["up"]._y = -4;
		loadStageResize();
		Tweener.addTween(this, { _alpha:100, time: .5, transition: "linear" } );
	}


	private function resize(w:Number, h:Number) {
		grad["up"]._width = grad["down"]._width = w + 4;
		grad["down"]._y = Math.round(h - grad["down"]._height + 4);
		
		
		backgroundResize(w, h);
	}
	
	private function onResize() {
		resize(Stage.width, Stage.height);
	}
	
	private function loadStageResize() {
		Stage.addListener(this);
		onResize();
	}
	
	private function backgroundResize(w:Number, h:Number) {
		/**
		 * this will resize the background, the background is formed by many squares multiplied to fill the whole screen
		 */
		var posX:Number = 0;
		var posY:Number = 0;
		
		if ((bg._width < w) || (bg._height < h)) {
			var i:Number = 1;
			
			while (bg["copy" + i]) {
				bg["copy" + i].removeMovieClip();
				i++;
			}
			
			while (posX < w) {
				bgIdx++;
				posX += bg["copy"]._width;
				var duplicate:MovieClip = bg["copy"].duplicateMovieClip("copy" + bgIdx, bg.getNextHighestDepth(), { _x:posX, _y:posY } );
				if (posX >= w) {
					posX = -bg["copy"]._width;
					posY += bg["copy"]._height;
				}
				if (posY > h) {
					break;
				}
			}
		}
	}
}