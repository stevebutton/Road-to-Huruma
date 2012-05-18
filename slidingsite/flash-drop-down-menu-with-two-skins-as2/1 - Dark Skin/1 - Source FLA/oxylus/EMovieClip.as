/* @author: Adrian Bota, adrian@oxylus.ro, www.oxylusflash.com 
 * @last_update: 09/11/2009 (mm/dd/yyyy) */

import oxylus.utils.*;
class oxylus.EMovieClip extends MovieClip {
	private var $blurX:Number 		= 0;
	private var $blurY:Number 		= 0;
	private var $blurQuality:Number = 2;
	private var $regPointX:Number 	= 0;
	private var $regPointY:Number 	= 0;
	
	public function EMovieClip() { }
	
	/* Get/set MovieClip alpha.
	 * If alpha is 0 the _visible property is set to false. */
	public function get alpha():Number {
		return this._alpha;
	}
	public function set alpha(a:Number) {
		this._alpha 	= a;
		this._visible 	= a > 0;
	}
	/* Get/set if MovieClip is disabled.
	 * Hides hand cursor aswel if disabled. */
	public function get disabled():Boolean {
		return this.enabled;
	}
	public function set disabled(b:Boolean) {
		this.enabled = !b;
		this.useHandCursor = this.enabled;
	}
	/* Get/set MovieClip blurX. */
	public function get blurX():Number {
		return $blurX;
	}
	public function set blurX(bx:Number) {
		$blurX = bx;
		UFilter.setBlur(this, $blurX, $blurY, $blurQuality);
	}
	/* Get/set MovieClip blurY. */
	public function get blurY():Number {
		return $blurY;
	}
	public function set blurY(by:Number) {
		$blurY = by;
		UFilter.setBlur(this, $blurX, $blurY, $blurQuality);
	}	
	/* Get/set MovieClip blur quality. */
	public function get blurQuality():Number {
		return $blurQuality;
	}
	public function set blurQuality(bq:Number) {
		$blurQuality = bq;
		UFilter.setBlur(this, $blurX, $blurY, $blurQuality);
	}
	/* Get/set MovieClip blur. */
	public function get blur():Number {
		return ($blurX + $blurY) / 2;
	}
	public function set blur(b:Number) {
		$blurX = b;
		$blurY = b;
		UFilter.setBlur(this, $blurX, $blurY, $blurQuality);
	}
	/* Get/set MovieClip color. */
	public function get color():Number {
		return UColor.getColor(this);
	}
	public function set color(c:Number) {
		UColor.setColor(this, c);
	}
	/* Get/set MovieClip brightness. */
	public function get brightness():Number {
		return UColor.getBrightness(this);
	}
	public function set brightness(b:Number) {
		UColor.setBrightness(this, b);
	}
	/* Get/set MovieClip contrast. */
	public function get contrast():Number {
		return UColor.getContrast(this);
	}
	public function set contrast(c:Number) {
		UColor.setContrast(this, c);
	}
	/* Get/set MovieClip saturation. */
	public function get saturation():Number {
		return UColor.getSaturation(this);
	}
	public function set saturation(s:Number) {
		UColor.setSaturation(this, s);
	}
	/* Get/set MovieClip registration point x. */
	public function get regPointX():Number {
		return $regPointX;
	}
	public function set regPointX(rx:Number) {
		$regPointX = rx;
	}
	/* Get/set MovieClip registration point y. */
	public function get regPointY():Number {
		return $regPointY;
	}
	public function set regPointY(ry:Number) {
		$regPointY = ry;
	}
	/* Get/set MovieClip x position. */
	public function get x():Number {
		return UMc.getXPos(this, $regPointX, $regPointY);
	}
	public function set x(xPos:Number) {
		UMc.setXPos(this, xPos, $regPointX, $regPointY);
	}
	/* Get/set MovieClip y position. */
	public function get y():Number {
		return UMc.getYPos(this, $regPointX, $regPointY);
	}
	public function set y(yPos:Number) {
		UMc.setYPos(this, yPos, $regPointX, $regPointY);
	}
	/* Get/set MovieClip rotation. */
	public function get rotation():Number {
		return this._rotation;
	}
	public function set rotation(r:Number) {
		UMc.setRotation(this, r, $regPointX, $regPointY);
	}
	/* Get/set MovieClip width. */
	public function get width():Number {
		return this._width;
	}
	public function set width(nw:Number) {
		UMc.setWidth(this, nw, $regPointX, $regPointY);
	}
	/* Get/set MovieClip height. */
	public function get height():Number {
		return this._height;
	}
	public function set height(nh:Number) {
		UMc.setHeight(this, nh, $regPointX, $regPointY);
	}
	/* Get/set MovieClip x scale. */
	public function get xscale():Number {
		return this._xscale;
	}
	public function set xscale(xs:Number) {
		UMc.setXScale(this, xs, $regPointX, $regPointY);
	}
	/* Get/set MovieClip y scale. */
	public function get yscale():Number {
		return this._yscale;
	}
	public function set yscale(ys:Number) {
		UMc.setYScale(this, ys, $regPointX, $regPointY);
	}
	/* Get/set MovieClip scale. */
	public function get scale():Number {
		return (this.xscale - this.yscale) / 2;
	}
	public function set scale(s:Number) {
		UMc.setScale(this, s, $regPointX, $regPointY);
	}
}