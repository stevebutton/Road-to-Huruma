/* @author: Adrian Bota, adrian@oxylus.ro, www.oxylusflash.com 
 * @last_update: 09/16/2009 (mm/dd/yyyy) */

import oxylus.utils.*;
class oxylus.EButton extends MovieClip {
		
	public function EButton() {
		this.stop();
	}
	private function onRollOver() {
		UMc.playTo(this, 0);
	}
	private function onRollOut() {
		UMc.playTo(this, 1);
	}
	private function onReleaseOutside() {
		this.onRollOut();
	}
}