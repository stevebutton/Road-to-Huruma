/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
These routines address common layout styles for menu pages.
*/
jQuery (document).ready (function($)
	{
		$ ('div.ws-menu-page-group').each (function(index)
			{
				var ins = '<ins>+</ins>', group = $ (this), title = group.attr ('title');
				/**/
				var header = $ ('<div class="ws-menu-page-group-header">' + ins + title + '</div>');
				/**/
				header.css ({'z-index': 100 - index}); /* Stack them sequentially, top to bottom. */
				/**/
				header.insertBefore (group), group.hide (), header.click (function()
					{
						var ins = $ ('ins', this), group = $ (this).next ();
						/**/
						if (group.css ('display') === 'none')
							{
								$ (this).addClass ('open'), ins.html ('-'), group.show ();
							}
						else
							{
								$ (this).removeClass ('open'), ins.html ('+'), group.hide ();
							}
						/**/
						return false;
					});
				if (index === 0) /* These are the buttons for showing/hiding all groups. */
					{
						$ ('<div class="ws-menu-page-groups-show">+</div>').insertBefore (header).click (function()
							{
								$ ('div.ws-menu-page-group-header').each (function()
									{
										var ins = $ ('ins', this), group = $ (this).next ();
										/**/
										$ (this).addClass ('open'), ins.html ('-'), group.show ();
										/**/
										return;
									});
								/**/
								return false;
							});
						$ ('<div class="ws-menu-page-groups-hide">-</div>').insertBefore (header).click (function()
							{
								$ ('div.ws-menu-page-group-header').each (function()
									{
										var ins = $ ('ins', this), group = $ (this).next ();
										/**/
										$ (this).removeClass ('open'), ins.html ('+'), group.hide ();
										/**/
										return;
									});
								/**/
								return false;
							});
					}
				/**/
				if (group.attr ('default-state') === 'open')
					header.trigger ('click');
				/**/
				return;
			});
		/**/
		$ ('div.ws-menu-page-hr:first').css ({'margin-top': '10px', 'margin-bottom': '20px'});
		/**/
		$ ('div.ws-menu-page-section:first > h3').css ({'margin-top': '0'});
		/**/
		$ ('div.ws-menu-page-group > div.ws-menu-page-section:first-child > h3').css ({'margin-top': '0'});
		$ ('div.ws-menu-page-group-header:first').css ({'margin-top': '0', 'margin-right': '140px'});
		$ ('div.ws-menu-page-group:first').css ({'margin-right': '145px'});
		/**/
		$ ('div.ws-menu-page-readme > div.readme > div.section:last-child').css ({'border-bottom-width': '0'});
		/**/
		$ ('input.ws-menu-page-media-btn').filter (function() /* Only those that have a rel attribute. */
			{
				return ($ (this).attr ('rel')) ? true : false; /* Must have rel targeting an input id. */
			})/**/
		.click (function() /* Attach click events to media buttons with send_to_editor(). */
			{
				$this = $ (this), window.send_to_editor = function(html)
					{
						var $inp, $txt; /* Looking for input|textarea. */
						/**/
						if (($inp = $ ('input#' + $this.attr ('rel'))).length > 0)
							{
								var oBg = $inp.css ('background-color'), src = $.trim ($ (html).attr ('src'));
								src = (!src) ? $.trim ($ ('img', html).attr ('src')) : src;
								/**/
								$inp.val (src), $inp.css ({'background-color': '#FFFFCC'}), setTimeout (function()
									{
										$inp.css ({'background-color': oBg});
									}, 2000);
								/**/
								tb_remove ();
								/**/
								return;
							}
						else if (($txt = $ ('textarea#' + $this.attr ('rel'))).length > 0)
							{
								var oBg = $txt.css ('background-color'), src = $.trim ($ (html).attr ('src'));
								src = (!src) ? $.trim ($ ('img', html).attr ('src')) : src;
								/**/
								$txt.val ($.trim ($txt.val ()) + '\n' + src), $txt.css ({'background-color': '#FFFFCC'}), setTimeout (function()
									{
										$txt.css ({'background-color': oBg});
									}, 2000);
								/**/
								tb_remove ();
								/**/
								return;
							}
					};
				/**/
				tb_show ('', './media-upload.php?type=image&TB_iframe=true');
				/**/
				return false;
			});
	});