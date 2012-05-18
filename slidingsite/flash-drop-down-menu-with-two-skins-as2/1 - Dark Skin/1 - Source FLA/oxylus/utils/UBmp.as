/* @author: Adrian Bota, adrian@oxylus.ro, www.oxylusflash.com 
 * @last_update: 10/18/2009 (mm/dd/yyyy) */

import flash.display.BitmapData;
import flash.geom.ColorTransform;
import flash.geom.Matrix;
import oxylus.utils.UObj;

class oxylus.utils.UBmp {
	private function UBmp() { trace("Static class. No instantiation.") }
	
	/* "flipKind" parameter for the "attach" method. */
	public static var NO_FLIP:Number = 0;
	/* "flipKind" parameter for the "attach" method. */
	public static var FLIP_VERTICALLY:Number = 1;
	/* "flipKind" parameter for the "attach" method. */
	public static var FLIP_HORIZONTALLY:Number = 2;
	/* "pixelSnap" parameter for the "attach" method. */
	public static var SNAP_AUTO:String = "auto";
	/* "pixelSnap" parameter for the "attach" method. */
	public static var SNAP_ALWAYS:String = "always";
	/* "pixelSnap" parameter for the "attach" method. */
	public static var SNAP_NEVER:String = "never";
	
	/* Attach source MovieClip bitmap-data to holder MovieClip. */
	public static function attach(source:MovieClip, holder:MovieClip, width: Number, height: Number, smoothing:Boolean, pixelSnap:String, blendMode:String, flipKind:Number):Void {
		smoothing 	= UObj.valueOrAlt(smoothing, true);
		pixelSnap 	= UObj.valueOrAlt(pixelSnap, SNAP_NEVER);
		blendMode 	= UObj.valueOrAlt(blendMode, "normal");
		flipKind 	= UObj.valueOrAlt(flipKind, NO_FLIP);

		var w:Number 			= UObj.valueOrAlt(width, source._width);
		var h:Number 			= UObj.valueOrAlt(height, source._height);
		var bmp:BitmapData 		= new BitmapData(w, h, true, 0);
		var matrix:Matrix 		= new Matrix();
		var ct:ColorTransform 	= new ColorTransform(0, 0, 0);
		
		switch(flipKind) {
			case FLIP_VERTICALLY:
				matrix.scale(1, -1);
				matrix.translate(0, h);
				break;
				
			case FLIP_HORIZONTALLY:
				matrix.scale( -1, 1);
				matrix.translate(w, 0);
		}		
		bmp.draw(source, matrix, ct, blendMode, null, smoothing);		
		holder.attachBitmap(bmp, holder.getNextHighestDepth(), pixelSnap, smoothing);
	}
}